<?php

class Shibboleth
{
    public static function userId()
    {
        return static::user()->eduPersonPrincipalName;
    }
    
    /**
     * @return stdClass
     */
    public static function user()
    {
        return (object)[
            'eduPersonPrincipalName' => $_SERVER['SHIB_EPPN'],
            'eduPersonScopedAffiliation' => $_SERVER['SHIB_EDU_PERSON_AFFILIATION'],
            'sn' => $_SERVER['SHIB_SN'],
            'givenName' => $_SERVER['SHIB_GIVEN_NAME'],
            'mail' => $_SERVER['SHIB_MAIL']
        ];
    }
}