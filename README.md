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


## Usage:

# Send a simple text message to a user:


```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Messenger;
use Tgallice\FBMessenger\Message\Message;

$messenger = new Messenger('page_token');

// Simple Text message
$message = new Message('<USER_ID>', 'My Message');

$response = $messenger->sendMessage($message);

```

# Send a more complex message like a `Receipt` message

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Attachment\Template\Receipt;
use Tgallice\FBMessenger\Messenger;
use Tgallice\FBMessenger\Message\Message;
use Tgallice\FBMessenger\Model\Receipt\Element;
use Tgallice\FBMessenger\Model\Summary;

$messenger = new Messenger('page_token');

$elements = [
    new Element('My first Item', <price>),
    new Element('My Second Item', <price>),
];

$summary = new Summary(<total_cost>);

$attachment = new Receipt('My Receipt', '123456789', 'EUR', 'Visa', $elements, $summary);
$message = new Message('<USER_ID>', $attachment);

$response = $messenger->sendMessage($message);

```

# Buttons message

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Attachment\Template\Button;
use Tgallice\FBMessenger\Messenger;
use Tgallice\FBMessenger\Message\Message;
use Tgallice\FBMessenger\Model\Button\WebUrl;
use Tgallice\FBMessenger\Model\Button\Postback;

$messenger = new Messenger('page_token');

$elements = [
    new WebUrl('Button1', 'http://google.com'),
    new Postback('Button2', 'EVENT_NAME'),
];

$attachment = new Button('My template', $elements);

$message = new Message('<USER_ID>', $attachment);
$response = $messenger->sendMessage($message);

```

# Image Message


```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Attachment\Image;
use Tgallice\FBMessenger\Message\Message;
use Tgallice\FBMessenger\Messenger;

$messenger = new Messenger('page_token');

// Local file
$image = new Image('./image.jpg');
$message = new Message('<USER_ID>', $image);

$response = $messenger->sendMessage($message);

// Remote file
$image = new Image('http://www.site.com/image.jpg');
$message = new Message('<USER_ID>', $image);

$response = $messenger->sendMessage($message);

```

And more other cool things...

### Todo
- [ ] Improve document
- [ ] Code cleaning
- [ ] Some rework
