ColoCrossing Portal API Library
===============================

This is a wrapper library for the ColoCrossing Portal API to be used by PHP applications. It tries to ease the integration of the API into your applications by handling all interactions with API and providing a simple interface to interact with.

Getting Started
-------------------------------
To begin using the Library, the ColoCrossing.php in the src folder in the repository must be included in your application. The ColoCrossing folder inside of the src folder must be in the same directory as ColoCrossing.php.

```php
require_once('/path/to/library/ColoCrossing.php');
```

An instance of the ColoCrossing_Client must be created to interact with the library. This Object is the gateway to all interactions with the library. The API token obtained from the [ColoCrossing Portal](https://portal.colocrossing.com/api/#keys) must be passed into the ColoCrossing_Client by calling setAPIToken.

```php
$colocrossing_client = new ColoCrossing_Client();
$colocrossing_client->setAPIToken('YOUR_API_TOKEN');
```

Alternatively the API Token may be passed in the constructor as seen below.

```php
$colocrossing_client = new ColoCrossing_Client('YOUR_API_TOKEN');
```