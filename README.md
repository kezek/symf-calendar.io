symf-calendar
=============

Installation
---------
1. ```composer install```
2. ```app/console doctrine:schema:update --force```

**Optional**

Frontend libraries are being managed by using Bower. If you have any issues you could run :

```app/console sp:bower:install```


Running the app
---------

```app/console server:run```


Running tests
---------
The app is fully covered by integration testing.

```phpunit -c app```


Api Documentation
---------
Api documentation is found under /api/doc (i.e. http://localhost:8000/api/doc/).