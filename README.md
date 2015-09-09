UrlShortner Rest API
========================

Some Rest Api developed with symphony 2.
The aim was to create a simple url shortener service where some client register their url and get one shortened.

It use :
FOSOAuthServerBundle
FosRestBundle

OAuth 2 is use with client_credentials grant to give a token to the front-end client (/oauth/v2/token/client_id=XXX&client_secret=XXX&grant=client_credentials).

The site is created around a bundle call UrlShortenerBundle which define :
1 command line :
* shortenr:oauth-server:client:create (to create some oath client)

The controller define 2 routes :
* /{short_code} (GET the url with the short code)
* /url/add (save an url with POST and return the shortened url)

you may find the angular-js client here : https://github.com/gchablowski/urlshortener-angular

Created by Gérald Chablowski.
