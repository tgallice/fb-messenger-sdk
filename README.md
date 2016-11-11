Facebook Messenger Bot PHP
==========================

Implementation of the Facebook messenger bot api. 

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tgallice/fb-messenger-sdk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tgallice/fb-messenger-sdk/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/tgallice/fb-messenger-sdk/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/tgallice/fb-messenger-sdk/?branch=master)
[![Build Status](https://travis-ci.org/tgallice/fb-messenger-sdk.svg?branch=master)](https://travis-ci.org/tgallice/fb-messenger-sdk)

**Still under development...**

## Install:

Via composer:

```
$ composer require tgallice/fb-messenger-sdk
```


# Usage:

### Create a Messenger instance

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Client;
use Tgallice\FBMessenger\Messenger;

$client = new Client('page_token');
$messenger = new Messenger($client);

// Or quick factory
$messenger = Messenger::create('page_token');

```

### Send a simple text message to a user:


```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Messenger;

$messenger = Messenger::create('page_token');

// Simple Text message
$response = $messenger->sendMessage('<USER_ID>', 'My Message');

```

### Send a message with quick replies

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Messenger;
use Tgallice\FBMessenger\Model\Message;
use Tgallice\FBMessenger\Model\QuickReply;

$messenger = Messenger::create('page_token');

$message = new Message('What do you like ?');
$message->setQuickReplies([
    new QuickReply('Apple', 'LIKE_APPLE_PAYLOAD'),
    new QuickReply('Peach', 'LIKE_PEACH_PAYLOAD')
]);

$response = $messenger->sendMessage('<USER_ID>', $message);

```

### Send a more complex message like a `Receipt` message

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Messenger;
use Tgallice\FBMessenger\Model\Attachment\Template\Receipt;
use Tgallice\FBMessenger\Model\Attachment\Template\Receipt\Element;
use Tgallice\FBMessenger\Model\Attachment\Template\Receipt\Summary;

$messenger = Messenger::create('page_token');

$elements = [
    new Element('My first Item', <price>),
    new Element('My Second Item', <price>),
];

$summary = new Summary(<total_cost>);
$receipt = new Receipt('My Receipt', '123456789', 'EUR', 'Visa', $elements, $summary);

$response = $messenger->sendMessage('<USER_ID>', $receipt);

```

### Buttons message

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Model\Attachment\Template\Button;
use Tgallice\FBMessenger\Model\Button\WebUrl;
use Tgallice\FBMessenger\Model\Button\Postback;

$messenger = Messenger::create('page_token');

$elements = [
    new WebUrl('Button1', 'http://google.com'),
    new Postback('Button2', 'EVENT_NAME'),
];

$template = new Button('My template', $elements);

$response = $messenger->sendMessage('<USER_ID>', $template);

```

### Image Message


```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Messenger;
use Tgallice\FBMessenger\Model\Attachment\Image;

$messenger = Messenger::create('page_token');

// Local file
$image = new Image('./image.jpg');
$response = $messenger->sendMessage('<USER_ID>', $image);

// Remote file
$image = new Image('http://www.site.com/image.jpg');
$response = $messenger->sendMessage('<USER_ID>', $image);

```


## Webhook setup

When you setup a `Callback URL` in your app, Facebook need to validate this entry point.
In this process you must define a `Verify Token`
Your job is to compare the received verify token and the one you setup them return the challenge given.
Here is how to easily handle the whole process:

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\WebhookRequestHandler;

$webookHandler = new WebhookRequestHandler('app_secret', 'verify_token');
// The Request is internally retrieve but you can set your own if you have already a Request object.
// $webookHandler = new WebhookRequestHandler('app_secret', 'verify_token', $request);


if (!$webookHandler->isValidVerifyTokenRequest()) {
    ...error
}

// you must return a 200 OK HTTP response 
header("HTTP/1.1 200 OK");

echo $webookHandler->getChallenge();
```

## Webhook listening

We assume that we receive this payload from Facebook:
```json
{
  "object": "page",
  "entry": [
    {
      "id": "PAGE_ID",
      "time": 1473204787206,
      "messaging": [
        {
          "sender":{
            "id":"USER_ID"
          },
          "recipient":{
            "id":"PAGE_ID"
          },
          "timestamp":1458692752478,
          "message":{
            "mid":"mid.1457764197618:41d102a3e1ae206a38",
            "seq":73,
            "text":"hello, world!",
            "quick_reply": {
              "payload": "DEVELOPER_DEFINED_PAYLOAD"
            }
          }
        }
      ]
    }
  ]
}

```

### Basic usage

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\WebhookRequestHandler;

$webookHandler = new WebhookRequestHandler('app_secret', 'verify_token');
// The Request is internally retrieve but you can set your own if you have already a Request object.
// $webookHandler = new WebhookRequestHandler('app_secret', 'verify_token', $request);

if (!$webookHandler->isValidCallbackRequest()) {
    ...error
}

// @see https://developers.facebook.com/docs/messenger-platform/webhook-reference
// @var CallbackEvent[] $events
$events = $webookHandler->getAllCallbackEvents();

foreach($events as $event) {
    if ($event instanceof MessageEvent) {
          echo $event->getMessageText()."\n";
          echo $event->getQuickReplyPayload()."\n";
    }
}

// Result:
//
// hello, world!
// DEVELOPER_DEFINED_PAYLOAD

// you must return a 200 OK HTTP response 
```

### Advanced usage

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\WebhookRequestHandler;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tgallice\FBMessenger\Callback\MessageEvent;

// We use the symfony/event-dispatcher package
// @see https://github.com/symfony/event-dispatcher for more details
// Create custom event listener
class MessageEventListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            MessageEvent::NAME => 'onMessageEvent',
            'DEVELOPER_DEFINED_PAYLOAD' => 'onQuickReply',
        ];
    }

    public function onMessageEvent(MessageEvent $event)
    {
        prin(__METHOD__."\n");
    }

    public function onQuickReply(MessageEvent $event)
    {
        prin(__METHOD__."\n");
    }
}

$webhookHandler = new WebhookRequestHandler('app_secret', 'verify_token');

// Register the listener
$webhook->addEventSubscriber(new MessageEventListener());

if (!$webookHandler->isValidCallbackRequest()) {
    ...error
}

$webhook->dispatchCallbackEvents();

// Result:
//
// MessageEventListener::onMessageEvent
// MessageEventListener::onQuickReply


// you must return a 200 OK HTTP response 
```

## Thread Settings

### Set greeting text

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Messenger;

$messenger = Messenger::create('page_token');
$messenger->setGreetingText('Tell me what you want.');

```

### Set started button

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Messenger;

$messenger = Messenger::create('page_token');
$messenger->setStartedButton('MY_PLAYLOAD_TO_TRIGGER');

```

### Set a Persistent Menu

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Messenger;
use Tgallice\FBMessenger\Model\ThreadSetting\PostBack;
use Tgallice\FBMessenger\Model\ThreadSetting\WebUrl;

$messenger = Messenger::create('page_token');

$buttons = [
    new PostBack('Button Title 1', 'MY_PAYLOAD'),      
    new WebUrl('Button Title 2', 'http://my-url.com'),      
];

$messenger->setPersistentMenu($buttons);

```

## Page action

### Subscribe bot to a page

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Messenger;

$messenger = Messenger::create('page_token');
$messenger->subscribe();

```

And more other cool things...

### Todo
- [ ] Improve document
- [ ] Add Airline template 
