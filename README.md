# CheshireCat PHP SDK

----

**CheshireCat PHP SDK** is a library to help the implementation
of [Cheshire Cat](https://github.com/matteocacciola/cheshirecat-core) on a PHP Project

* [Installation](#installation)
* [Usage](#usage)

## Installation

To install CheshireCat PHP SDK you can run this command:
```cmd
composer require matteocacciola/cheshirecat-php-sdk
```

Perhaps, you also need to add the following repositories to your composer.json file:
```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/matteocacciola/cheshire-cat-php-sdk"
        }
    ]
}
```

## Usage
Initialization and usage:

```php
use DataMat\CheshireCat\CheshireCatClient;
use DataMat\CheshireCat\Clients\HttpClient;
use DataMat\CheshireCat\Clients\WSClient;

$cheshireCatClient = new CheshireCatClient(
    new WSClient('cheshire_cat_core', 1865, null),
    new HttpClient('cheshire_cat_core', 1865, null)
);
```
Send a message to the websocket:

```php
$notificationClosure = function (string $message) {
 // handle websocket notification, like chat token stream
}

// result is the result of the message
$result = $cheshireCatClient->message()->sendWebsocketMessage(
    new Message("Hello world!", 'user', []),  // message body
    $notificationClosure // websocket notification closure handle
);

```

Load data to the rabbit hole:
```php
//file
$promise = $cheshireCatClient->rabbitHole()->postFile($uploadedFile->getPathname(), null, null);
$promise->wait();

//url
$promise = $cheshireCatClient->rabbitHole()->postWeb($url, null,null);
$promise->wait();
```

Memory management utilities:

```php
$cheshireCatClient->memory()->getMemoryCollections(); // get number of vectors in the working memory
$cheshireCatClient->memory()->getMemoryRecall("HELLO"); // recall memories by text

//delete memory points by metadata, like this example delete by source
$cheshireCatClient->memory()->deleteMemoryPointsByMetadata(Collection.Declarative, ["source" => $url]);
```
