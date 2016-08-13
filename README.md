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

# Create a Messenger instance

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Client;
use Tgallice\FBMessenger\Messenger;

$client = new Client('page_token');
$messenger = new Messenger($client);

// Or quick factory
$messenger = Messenger::create('page_token');

```

# Send a simple text message to a user:


```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Messenger;

$messenger = Messenger::create('page_token');

// Simple Text message
$response = $messenger->sendMessage('<USER_ID>', 'My Message');

```

# Send a more complex message like a `Receipt` message

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

# Buttons message

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

# Image Message


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


## Thread Settings

# Set greeting text

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Messenger;

$messenger = Messenger::create('page_token');
$messenger->setGreetingText('Tell me what you want.');

```

# Set started button

```php

require_once __DIR__.'/vendor/autoload.php';

use Tgallice\FBMessenger\Messenger;

$messenger = Messenger::create('page_token');
$messenger->setStartedButton('MY_PLAYLOAD_TO_TRIGGER');

```

# Set a Persistent Menu

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

# Subscribe bot to a page

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
