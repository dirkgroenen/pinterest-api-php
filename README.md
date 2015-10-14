![](http://i.imgur.com/cacgQlq.png) Pinterest API - PHP  [![](https://travis-ci.org/dirkgroenen/Pinterest-API-PHP.svg)](https://travis-ci.org/dirkgroenen/Pinterest-API-PHP) ![](https://img.shields.io/packagist/v/dirkgroenen/pinterest-api-php.svg)
-------------------

A PHP wrapper for the official [Pinterest API](https://dev.pinterest.com).

**Still a work in progress, but all documented methods are working.**

# Requirements
- PHP 5.4 or higher
- cURL
- Registered Pinterest App

# Get started
To use the Pinterest API you have to register yourself as a developer and [create](https://dev.pinterest.com/apps/) an application. After you've created your app you will receive a `app_id` and `app_secret`. 

> The terms `client_id` and `client_secret` are in this case `app_id` and `app_secret`.

## Installation
The Pinterest API wrapper is available on Composer.

```
composer require dirkgroenen/Pinterest-API-PHP
```

## Simple Example 
```php
use DirkGroenen\Pinterest\Pinterest;

$pinterest = new Pinterest(CLIENT_ID, CLIENT_SECRET);
```

After you have initialized the class you can get a login URL:

```php
$loginurl = $pinterest->auth->getLoginUrl(CALLBACK_URL, array('read_public'));
echo '<a href=' . $loginurl . '>Authorize Pinterest</a>';
```

Check the [Pinterest documentation](https://dev.pinterest.com/docs/api/overview/#scopes) for the available scopes. 

## Get the user's profile

To get the profile of the current logged in user you can use the `Users::me(<array>);` method. 

```php
$me = $pinterest->users->me();
echo $me;
```

# Models
The API wrapper will parse all data through it's corresponding model. This results in the possibility to (for example) directly `echo` your model into a JSON string. 

Models also show the available fields (which are also described in the Pinterest documentation). By default, not all fields are returned, so this can help you when providing extra fields to the request. 

## Available models 

### [User](https://dev.pinterest.com/docs/api/users/#user-object)

### [Pin](https://dev.pinterest.com/docs/api/pins/#pin-object)

### [Board](https://dev.pinterest.com/docs/api/boards/#board-object)

### Interest
- id
- name

## Retrieving extra fields
If you want more fields you can specify these in the `$data` array. Example:

```php
$pinterest->users->me();
```

Response:

```json
{
    "id": "503066358284560467",
    "username": null,
    "first_name": "Dirk ",
    "last_name": "Groenen",
    "bio": null,
    "created_at": null,
    "counts": null,
    "image": null
}
```

By default, not all fields are returned. The returned data from the API has been parsed into the `User` model. Every field in this model can be filled by parsing an extra `$data` array with the key `fields`. Say we want the user's username, first_name, last_name and image (small and large): 

```php
$pinterest->users->me(array(
    'fields' => 'username,first_name,last_name,image[small,large]'
));
```

The response will now be: 

```json
{
    "id": "503066358284560467",
    "username": "dirkgroenen",
    "first_name": "Dirk ",
    "last_name": "Groenen",
    "bio": null,
    "created_at": null,
    "counts": null,
    "image": {
        "small": {
                "url": "http://media-cache-ak0.pinimg.com/avatars/dirkgroenen_1438089829_30.jpg",
                "width": 30,
                "height": 30
            },
            "large": {
                "url": "http://media-cache-ak0.pinimg.com/avatars/dirkgroenen_1438089829_280.jpg",
                "width": 280,
                "height": 280
            }
        }
    }
}
```

# Collection

When the API returns multiple models (for instance when your requesting the pins from a board) the wrapper will put those into a `Collection`.

The output of a collection contains the `data` and page `key`. If you echo the collection you will see a json encoded output containing both of these. Using the collection as an array will only return the items from `data`.

Available methods for the collection class:

## Get all items
`all()`

```php
$pins = $pinterest->users->getMeLikes();
$pins->all();
```

Returns: `array<Model>`

## Get item at index
`get( int $index )`

```php
$pins = $pinterest->users->getMeLikes();
$pins->get(0);
```

Returns: `Model`

## Check if collection has next page

`hasNextPage()`

```php
$pins = $pinterest->users->getMeLikes();
$pins->hasNextPage();
```

Returns: `Boolean`

# Available methods

> Every method containing a `data` array can be filled with extra data. This can be for example extra fields or pagination. 

## Authentication 

The methods below are available through `$pinterest->auth`.

### Get login URL
`getLoginUrl(string $redirect_uri, array $scopes);`

```php
$pinterest->auth->getLoginUrl("https://pinterest.dev/callback.php", array("read_public"));
```

Check the [Pinterest documentation](https://dev.pinterest.com/docs/api/overview/#scopes) for the available scopes. 

> At this moment the Pinterest API returns the user's `access_token` in the query string on the callback page. The documentation states that this should be a code, so the next method has been writing assuming this will be changed somewhere in the future

### Get access_token
`getOAuthToken(string $code );`

```php
$pinterest->auth->getOAuthToken($code);
```

### Set access_token
`setOAuthToken(string $access_token );`

```php
$pinterest->auth->setOAuthToken($access_token);
```

## Users

The methods below are available through `$pinterest->users`.

> You also cannot access a user’s boards or Pins who has not authorized your app.

### Get logged in user
`me( array $data );`

```php
$pinterest->users->me();
```

Returns: `User`

### Find a user
`find( string $username_or_id );`

```php
$pinterest->users->find('dirkgroenen');
```

Returns: `User`

### Get user's pins
`getMePins( array $data );`

```php
$pinterest->users->getMePins();
```

Returns: `Collection<Pin>`

### Search in user's pins
`getMePins( string $query, array $data );`

```php
$pinterest->users->searchMePins("cats");
```

Returns: `Collection<Pin>`

### Search in user's boards
`searchMeBoards( string $query, array $data );`

```php
$pinterest->users->searchMeBoards("cats");
```

Returns: `Collection<Board>`

### Get user's boards
`getMeBoards( array $data );`

```php
$pinterest->users->getMeBoards();
```

Returns: `Collection<Board>`

### Get user's likes
`getMeLikes( array $data );`

```php
$pinterest->users->getMeLikes();
```

Returns: `Collection<Pin>`

## Boards

The methods below are available through `$pinterest->boards`.

### Get board
`get( string $board_id, array $data );`

```php
$pinterest->boards->get("503066289565421201");
```

Returns: `Board`

### Create board
`create( array $data );`

```php
$pinterest->boards->create(array(
    "name"          => "Test board from API",
    "description"   => "Test Board From API Test"
));
```

Returns: `Board`

### Delete board
`delete( string $board_id, array $data );`

```php
$pinterest->boards->delete("503066289565421201");
```

Returns: `True|PinterestException`

## Pins

The methods below are available through `$pinterest->pins`.

### Get pin
`get( string $pin_id, array $data );`

```php
$pinterest->pins->get("181692166190246650");
```

Returns: `Pin`

### Get pins from board
`fromBoard( string $board_id, array $data );`

```php
$pinterest->pins->fromBoard("503066289565421201");
```

Returns: `Collection<Pin>`

### Create pin
`create( array $data );`

Creating a pin with an image hosted somewhere else:

```php
$pinterest->pins->create(array(
    "note"          => "Test board from API",
    "image_url"     => "https://download.unsplash.com/photo-1438216983993-cdcd7dea84ce",
    "board"         => "503066289565421201"
));
```

Creating a pin with an image located on the server:

```php
$pinterest->pins->create(array(
    "note"          => "Test board from API",
    "image"         => "/path/to/image.png",
    "board"         => "503066289565421201"
));
```

Creating a pin with a base64 encoded image:

```php
$pinterest->pins->create(array(
    "note"          => "Test board from API",
    "image_base64"  => "[base64 encoded image]",
    "board"         => "503066289565421201"
));
```


Returns: `Pin`

### Update pin
> According to the Pinterest documentation this endpoint exists, but for some reason their API is returning an error at the moment of writing.

`update( string $pin_id, array $data );`

```php
$pinterest->pins->update("181692166190246650");
```

Returns: `Pin`

### Delete pin
`delete( string $pin_id, array $data );`

```php
$pinterest->pins->delete("181692166190246650");
```

Returns: `True|PinterestException`

## Following

The methods below are available through `$pinterest->following`.

### Following users
`users( array $data );`

```php
$pinterest->following->users();
```

Returns: `Collection<User>`

### Following boards
`boards( array $data );`

```php
$pinterest->following->boards();
```

Returns: `Collection<Board>`

### Following interests/categories
`interests( array $data );`

```php
$pinterest->following->interests();
```

Returns: `Collection<Interest>`

### Follow an user
`followUser( string $username_or_id );`

```php
$pinterest->following->followUser("dirkgroenen");
```

Returns: `True|PinterestException`

### Unfollow an user
`unfollowUser( string $username_or_id );`

```php
$pinterest->following->unfollowUser("dirkgroenen");
```

Returns: `True|PinterestException`

### Follow a board
`followBoard( string $board_id );`

```php
$pinterest->following->followBoard("503066289565421201");
```

Returns: `True|PinterestException`

### Unfollow a board
`unfollowBoard( string $board_id );`

```php
$pinterest->following->unfollowBoard("503066289565421201");
```

Returns: `True|PinterestException`

### Follow an interest

> According to the Pinterest documentation this endpoint exists, but for some reason their API is returning an error at the moment.

`followInterest( string $interest );`

```php
$pinterest->following->followInterest("architecten-911112299766");
```

Returns: `True|PinterestException`

### Unfollow an interest

> According to the Pinterest documentation this endpoint exists, but for some reason their API is returning an error at the moment.

`unfollowInterest( string $interest );`

```php
$pinterest->following->unfollowInterest("architecten-911112299766");
```

Returns: `True|PinterestException`

# Examples

Please check [https://bitlabs.nl/pinterest](https://bitlabs.nl/pinterest) for an example project.
