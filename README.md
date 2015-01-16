# Shibboleth/OAuth2 Bridge

## Status

The code in this repository is considered a **beta release** at this time.

## License

The Shibboleth/OAuth2 Bridge is open-source software licensed under the **BSD 3-clause license**. The full text of the license may be found in the [LICENSE](https://github.com/ebollens/shib-oauth2-bridge/blob/master/LICENSE.txt) file.

## Credits

The Shibboleth/OAuth2 Bridge was developed by [Eric Bollens](http://github.com/ebollens).

The Shibboleth/OAuth2 bridge is built on top of outstanding open platforms, packages and standards including [Laravel](http://laravel.com/), [Apache HTTP Server](http://httpd.apache.org/), [Shibboleth](https://shibboleth.net/), [OAuth 2](http://oauth.net/2), [Laravel OAuth2 Server](https://github.com/lucadegasperi/oauth2-server-laravel) and [PHP OAuth 2.0 Server](https://github.com/thephpleague/oauth2-server). A sincere thanks is extended to the authors of all these fine projects.


## Setup

## Dependencies

Download and run composer:

```
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

### App

Configure app URI in `app/config/local/app.php`.

### Database

Configure database connection in `config/local/database.php`.

Run the database migrations to generate the database:

```
php artisan migrate --package="lucadegasperi/oauth2-server-laravel" --env=local
php artisan migrate --env=local
```

Run the database seeder to define the required `basic` scope:

```
php artisan db:seed --env=local
```

### Shibboleth

If `mod_shib` is installed, add a rule to Apache for the `/oauth2/authorize` route to require Shibboleth:

```apache
<IfModule mod_shib>
  <Location /oauth2/authorize>
    AuthType shibboleth
    ShibRequireSession On
    ShibUseHeaders On
    require valid-user
  </Location>
</IfModule>
```

### Stubbed Shibboleth

If `mod_shib` is not installed, then the `public/.htaccess` file will fall back to a stub:

```apache
<IfModule !mod_shib>
    SetEnv SHIB_EPPN "ebollens@localhost"
    SetEnv SHIB_SN "Bollens"
    SetEnv SHIB_GIVEN_NAME "Eric"
    SetEnv SHIB_MAIL "ebollens@oit.ucla.edu"
    SetEnv SHIB_EDU_PERSON_AFFILIATION "staff@localhost;employee@localhost"
</IfModule>
```

This is useful during local development. Change the values in `public/.htaccess` as needed.

### Attribute Map

To map Shibboleth attributes correctly, use the following rules for `attribute-map.xml`:

```xml
<Attribute name="urn:mace:dir:attribute-def:eduPersonPrincipalName" id="SHIB_EPPN"/>
<Attribute name="urn:mace:dir:attribute-def:givenName" id="SHIB_GIVENNAME"/>
<Attribute name="urn:mace:dir:attribute-def:sn" id="SHIB_SN"/>
<Attribute name="urn:mace:dir:attribute-def:mail" id="SHIB_MAIL"/>
<Attribute name="urn:mace:dir:attribute-def:eduPersonScopedAffiliation" id="SHIB_EDU_PERSON_AFFILIATION"/>
```

## Usage

### Endpoints

OAuth2 flow:

1. `POST /oauth2/access_token`
1. `GET /oauth2/authorize`
1. `POST /oauth2/authorize`

User data from Shibboleth:

> /oauth2/user

### OAuth Clients

Add clients and client endpoints for all applications leveraging this bridge:

```sql
INSERT INTO `oauth_clients` (`id`, `secret`, `name`, `created_at`, `updated_at`)
    VALUES ('my-app', 'my-secret', 'My Example Application', now(), now());
```

```sql
INSERT INTO `oauth_client_endpoints` (`id`, `client_id`, `redirect_uri`, `created_at`, `updated_at`)
    VALUES (1, 'my-app', 'http://localhost:8080/auth/oauth2/shibboleth', now(), now());
```
