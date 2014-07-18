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
            'eduPersonPrincipalName' => 'ebollens@ucla.edu',
            'eduPersonScopedAffiliation' => 'staff@ucla.edu',
            'sn' => 'Bollens',
            'givenName' => 'Eric',
            'mail' => 'ebollens@ucla.edu'
        ];
    }
}