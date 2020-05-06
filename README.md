## SmsRu notification channel for Laravel

![test](https://github.com/kafkiansky/laravel-sms-ru-channel/workflows/test/badge.svg?event=push)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Quality Score](https://img.shields.io/scrutinizer/g/kafkiansky/laravel-sms-ru-channel.svg?style=flat-square)](https://scrutinizer-ci.com/g/kafkiansky/laravel-sms-ru-channel)
[![StyleCI](https://styleci.io/repos/261535706/shield)](https://styleci.io/repos/261535706)
[![Total Downloads](https://img.shields.io/packagist/dt/kafkiansky/laravel-sms-ru-channel.svg?style=flat-square)](https://packagist.org/packages/kafkiansky/laravel-sms-ru-channel)

## Content
- [Installation](#installation)
- [Usage](#usage)
    - [Configuration](#configuration)
    - [How to](#how-to)
- [Testing](#testing)
- [License](#license)

## Installation

Install package with Composer:
```bash
composer require kafkiansky/laravel-sms-ru-channel
```

## Usage

### Configuration

Register provider:
```php
// config/app.php
'providers' => [
    ...
    Kafkiansky\SmsRuChannel\SmsRuProvider::class,
],
```

Add configuration in `config/services.php`:

```php
// config/services.php

'sms_ru' => [
    'api_id' => env('SMS_RU_API_ID'),
    'login'  => env('SMS_RU_LOGIN', null),
    'password' => env('SMS_RU_PASSWORD', null),
    'partner_id' => env('SMS_RU_PARTNER', null),
    'test' => env('SMS_RU_TEST', 1),
    'json' => env('SMS_RU_JSON', 1),
    'from' => env('SMS_RU_FROM', null),
],
```

Read more about configuration on official [site](https://sms.ru/api/send).

### How to

#### First way

Create notification message:

```php
use Illuminate\Notifications\Notification;
use Kafkiansky\SmsRu\Message\SmsRuMessage;
use Kafkiansky\SmsRu\Message\To;
use Kafkiansky\SmsRuChannel\SmsRuChannel;

final class RegistrationComplete extends Notification
{
    public function via($notifiable)
    {
        return [SmsRuChannel::class];
    }

    public function toSmsRu($notifiable)
    {
        return new SmsRuMessage(new To($notifiable->phone, 'Congratulations, you have become part of our application'));
    }
}
```

#### Second way

Or create `routeNotificationForSmsRu` method in notifiable instance:

```php
use Illuminate\Notifications\Notifiable;

/**
 * @property string $phone
 */
class User
{
    use Notifiable;

    public function routeNotificationForSmsRu()
    {
        return $this->phone; // can be array of phone numbers
    }
}
```

In this case notification message should look like this:

```php
use Illuminate\Notifications\Notification;
use Kafkiansky\SmsRuChannel\SmsRuChannel;

final class RegistrationComplete extends Notification
{
    public function via($notifiable)
    {
        return [SmsRuChannel::class];
    }

    public function toSmsRu($notifiable)
    {
        return 'Congratulations, you have become part of our application';
    }
}
```

## Testing

``` bash
$ composer test
```

## License

The MIT License (MIT). See [License File](LICENSE.md) for more information.