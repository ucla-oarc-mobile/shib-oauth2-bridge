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
        $data = [
          'eduPersonPrincipalName' => $_SERVER['SHIB_EPPN'],
          'eduPersonScopedAffiliation' => $_SERVER['SHIB_EDU_PERSON_AFFILIATION'],
          'sn' => $_SERVER['SHIB_SN'],
          'givenName' => $_SERVER['SHIB_GIVEN_NAME'],
          'mail' => $_SERVER['SHIB_MAIL']
        ];

        if(array_key_exists('SHIB_UID', $_SERVER)){
            $data['uid'] = $_SERVER['SHIB_UID']
        }

        return (object)$data;
    }
}
