## ![](http://i.imgur.com/cacgQlq.png)  Pinterest API - PHP

[![](https://travis-ci.org/dirkgroenen/Pinterest-API-PHP.svg)](https://travis-ci.org/dirkgroenen/Pinterest-API-PHP)
[![](https://img.shields.io/scrutinizer/g/dirkgroenen/Pinterest-API-PHP.svg)](https://scrutinizer-ci.com/g/dirkgroenen/Pinterest-API-PHP/?branch=master)
[![](https://img.shields.io/scrutinizer/coverage/g/dirkgroenen/Pinterest-API-PHP.svg)](https://scrutinizer-ci.com/g/dirkgroenen/Pinterest-API-PHP/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dirkgroenen/Pinterest-API-PHP/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dirkgroenen/Pinterest-API-PHP/?branch=master)
[![Packagist](https://img.shields.io/packagist/v/dirkgroenen/pinterest-api-php.svg)](https://packagist.org/packages/dirkgroenen/pinterest-api-php)
-------------------

A PHP wrapper for the official [Pinterest API](https://dev.pinterest.com).

# Requirements
- PHP 5.4 or higher (actively tested on PHP >=7.1)
- cURL
- Registered Pinterest App

# Get started
To use the Pinterest API you have to register yourself as a developer and [create](https://dev.pinterest.com/apps/) an application. After you've created your app you will receive a `app_id` and `app_secret`.

> The terms `client_id` and `client_secret` are in this case `app_id` and `app_secret`.

## Installation
The Pinterest API wrapper is available on Composer.

```
composer require dirkgroenen/pinterest-api-php
```

If you're not using Composer (which you should start using, unless you've got a good reason not to) you can include the `autoload.php` file in your project.

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

After your user has used the login link to authorize he will be send back to the given `CALLBACK_URL`. The URL will contain the `code` which can be exchanged into an `access_token`. To exchange the code for an `access_token` and set it you can use the following code:

```php
if(isset($_GET["code"])){
    $token = $pinterest->auth->getOAuthToken($_GET["code"]);
    $pinterest->auth->setOAuthToken($token->access_token);
}
```

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
If you want more fields you can specify these in the `$data` (GET requests) or `$fields` (PATCH requests) array. Example:

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

## Get pagination data
Returns an array with an `URL` and `cursor` for the next page, or `false` when no next page is available.

`pagination`

```php
$pins = $pinterest->users->getMeLikes();
$pins->pagination['cursor'];
```

Returns: `Array`

# Available methods

> Every method containing a `data` array can be filled with extra data. This can be for example extra fields or pagination.

## Authentication

The methods below are available through `$pinterest->auth`.

### Get login URL
`getLoginUrl(string $redirect_uri, array $scopes, string $response_type = "code");`

```php
$pinterest->auth->getLoginUrl("https://pinterest.dev/callback.php", array("read_public"));
```

Check the [Pinterest documentation](https://dev.pinterest.com/docs/api/overview/#scopes) for the available scopes.

**Note: since 0.2.0 the default authentication method has changed to `code` instead of `token`. This means you have to exchange the returned code for an access_token.**

### Get access_token
`getOAuthToken( string $code );`

```php
$pinterest->auth->getOAuthToken($code);
```

### Set access_token
`setOAuthToken( string $access_token );`

```php
$pinterest->auth->setOAuthToken($access_token);
```

### Get state
`getState();`

```php
$pinterest->auth->getState();
```

Returns: `string`

### Set state
`setState( string $state );`

This method can be used to set a state manually, but this isn't required since the API will automatically generate a random state on initialize.

```php
$pinterest->auth->setState($state);
```

## Rate limit
> Note that you should call an endpoint first, otherwise `getRateLimit()` will return `unknown`.

### Get limit
`getRateLimit();`

This method can be used to get the maximum number of requests.

```php
$pinterest->getRateLimit();
```

Returns: `int`

### Get remaining
`getRateLimitRemaining();`

This method can be used to get the remaining number of calls.

```php
$pinterest->getRateLimitRemaining();
```

Returns: `int`

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

### Get user's followers
`getMeLikes( array $data );`

```php
$pinterest->users->getMeFollowers();
```

Returns: `Collection<Pin>`

## Boards

The methods below are available through `$pinterest->boards`.

### Get board
`get( string $board_id, array $data );`

```php
$pinterest->boards->get("dirkgroenen/pinterest-api-test");
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

### Edit board
`edit( string $board_id, array $data, string $fields = null );`

```php
$pinterest->boards-edit("dirkgroenen/pinterest-api-test", array(
    "name"  => "Test board after edit"
));
```

Returns: `Board`

### Delete board
`delete( string $board_id, array $data );`

```php
$pinterest->boards->delete("dirkgroenen/pinterest-api-test");
```

Returns: `True|PinterestException`

## Sections
The methods below are available through `$pinterest->sections`.

### Create section on board
`create( string $board_id, array $data );`

```php
$pinterest->sections->create("503066289565421205", array(
    "title" => "Test from API"
));
```

Returns: `Section`

### Get sections on board
`get( string $board_id, array $data );`

```php
$pinterest->sections->get("503066289565421205");
```

Returns: `Collection<Section>`

### Get pins from section
> Note: Returned board ids can't directly be provided to `pins()`. The id needs to be extracted from \<BoardSection xxx\>

`get( string $board_id, array $data );`

```php
$pinterest->sections->pins("5027630990032422748");
```

Returns: `Collection<Pin>`

### Delete section

`delete( string $section_id );`

```php
$pinterest->sections->delete("5027630990032422748");
```

Returns: `boolean`

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
$pinterest->pins->fromBoard("dirkgroenen/pinterest-api-test");
```

Returns: `Collection<Pin>`

### Create pin
`create( array $data );`

Creating a pin with an image hosted somewhere else:

```php
$pinterest->pins->create(array(
    "note"          => "Test board from API",
    "image_url"     => "https://download.unsplash.com/photo-1438216983993-cdcd7dea84ce",
    "board"         => "dirkgroenen/pinterest-api-test"
));
```

Creating a pin with an image located on the server:

```php
$pinterest->pins->create(array(
    "note"          => "Test board from API",
    "image"         => "/path/to/image.png",
    "board"         => "dirkgroenen/pinterest-api-test"
));
```

Creating a pin with a base64 encoded image:

```php
$pinterest->pins->create(array(
    "note"          => "Test board from API",
    "image_base64"  => "[base64 encoded image]",
    "board"         => "dirkgroenen/pinterest-api-test"
));
```


Returns: `Pin`

### Edit pin

`edit( string $pin_id, array $data, string $fields = null );`

```php
$pinterest->pins->edit("181692166190246650", array(
    "note"  => "Updated name"
));
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

Use can take a look at the `./demo` directory for a simple example.

Let me know if you have an (example) project using the this library.
