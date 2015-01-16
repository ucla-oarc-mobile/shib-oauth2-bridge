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
        }, array('except' => array('getAuthorize', 'postAuthorize', 'postAccessToken')));
    }

    public function getAuthorize()
    {
        $params = Session::get('authorize-params');
        $params['user_id'] = Shibboleth::userId();

        return View::make('oauth2/authorize', array(
            'params' => $params
        ));
    }

    public function postAuthorize()
    {
        $user = Shibboleth::user();
        $userId = $user->eduPersonPrincipalName;

        $owner = Owner::find($userId);
        if(!$owner){
            $owner = new Owner();
            $owner->id = $userId;
        }
        $owner->data = json_encode($user);
        $owner->save();

        $params = Session::get('authorize-params');
        $params['user_id'] = $user->eduPersonPrincipalName;

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

    public function getUser()
    {
        $owner = Owner::find(ResourceServer::getOwnerId());
        $ownerData = json_decode($owner->data);
        return Response::json($ownerData);
    }
}
