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
        $scopedAffiliation = null;

        if(array_key_exists('SHIB_EDU_PERSON_SCOPED_AFFILIATION', $_SERVER)){
          $scopedAffiliation = $_SERVER['SHIB_EDU_PERSON_SCOPED_AFFILIATION'];
        }else{
          $affiliationSuffix = '@'.$_SERVER['SHIB_IMPLIED_AFFILIATION_SCOPE'];
          $scopedAffiliationArr = [];
          foreach(explode(';', $_SERVER['SHIB_EDU_PERSON_AFFILIATION']) as $affiliation){
              $scopedAffiliationArr[] = $affiliation.$affiliationSuffix;
          }
          $scopedAffiliation = implode(';', $scopedAffiliationArr);
        }

        $data = [
          'eduPersonPrincipalName' => $_SERVER['SHIB_EPPN'],
          'eduPersonScopedAffiliation' => $scopedAffiliation,
          'sn' => $_SERVER['SHIB_SN'],
          'givenName' => $_SERVER['SHIB_GIVEN_NAME'],
          'mail' => $_SERVER['SHIB_MAIL']
        ];

        if(array_key_exists('SHIB_UID', $_SERVER)){
            $data['uid'] = $_SERVER['SHIB_UID'];
        }

        return (object)$data;
    }
}
