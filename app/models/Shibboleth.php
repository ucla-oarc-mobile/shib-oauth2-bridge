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

        if(array_key_exists('HTTP_SHIB_EDU_PERSON_SCOPED_AFFILIATION', $_SERVER)){
          $scopedAffiliation = $_SERVER['HTTP_SHIB_EDU_PERSON_SCOPED_AFFILIATION'];
        }else{
          $affiliationSuffix = '@'.$_SERVER['SHIB_IMPLIED_AFFILIATION_SCOPE'];
          $scopedAffiliationArr = [];
          foreach(explode(';', $_SERVER['HTTP_SHIB_EDU_PERSON_AFFILIATION']) as $affiliation){
              $scopedAffiliationArr[] = $affiliation.$affiliationSuffix;
          }
          $scopedAffiliation = implode(';', $scopedAffiliationArr);
        }

        $data = [
          'eduPersonPrincipalName' => $_SERVER['HTTP_SHIB_EPPN'],
          'eduPersonScopedAffiliation' => $scopedAffiliation,
          'sn' => $_SERVER['HTTP_SHIB_SN'],
          'givenName' => $_SERVER['HTTP_SHIB_GIVEN_NAME'],
          'mail' => $_SERVER['HTTP_SHIB_MAIL']
        ];

        if(array_key_exists('HTTP_SHIB_UID', $_SERVER)){
            $data['uid'] = $_SERVER['HTTP_SHIB_UID'];
        }

        return (object)$data;
    }
}
