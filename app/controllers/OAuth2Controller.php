<?php

class OAuth2Controller extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->beforeFilter('check-authorization-params', 
                array('only' => array('getAuthorize', 'postAuthorize')));
        
        $this->beforeFilter('csrf', 
                array('only' => array('postAuthorize')));
        
        
        $this->beforeFilter('oauth:basic',
                array('except' => array('getAuthorize', 'postAuthorize', 'postAccessToken')));
        
        $this->beforeFilter(function(){
            $ownerType = ResourceServer::getOwnerType();
            if(!$ownerType || !in_array($ownerType, array('user')))
                App::abort(403, 'Forbidden');
            if(Shibboleth::userId() != ResourceServer::getOwnerId())
                App::abort(401, 'Unauthorized');
        }, array('except' => array('getAuthorize', 'postAuthorize', 'postAccessToken')));
    }
    
    public function getAuthorize()
    {
        try
        {
            $params = Session::get('authorize-params');
            $params['user_id'] = Shibboleth::userId();

            return View::make('oauth2/authorize', array(
                'params' => $params
            ));
        }
        catch(NoShibbolethUser $e)
        {
            throw Exception('Stub for eventually redirecting to a Shibboleth-protected location to acquire Shibboleth attributes');
        }
    }
    
    public function postAuthorize()
    {
        $params = Session::get('authorize-params');
        $params['user_id'] = Shibboleth::userId();

        if (Input::get('approve') !== null) {
            $code = AuthorizationServer::newAuthorizeRequest('user', $params['user_id'], $params);
            Session::forget('authorize-params');
            return Redirect::to(AuthorizationServer::makeRedirectWithCode($code, $params));
        }

        if (Input::get('deny') !== null) {
            Session::forget('authorize-params');
            $url = AuthorizationServer::makeRedirectWithError($params);
            return new \Illuminate\Http\RedirectResponse((string)$url, 302, array());
        }
    }
    
    public function postAccessToken()
    {
        return AuthorizationServer::performAccessTokenFlow();
    }
}