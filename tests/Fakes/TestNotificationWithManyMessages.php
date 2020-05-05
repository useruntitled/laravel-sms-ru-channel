<?php

declare(strict_types=1);

namespace Kafkiansky\SmsRuChannel\Tests\Fakes;

use Illuminate\Notifications\Notification;
use Kafkiansky\SmsRu\Message\Multi;
use Kafkiansky\SmsRu\Message\SmsRuMessage;
use Kafkiansky\SmsRu\Message\To;

final class TestNotificationWithManyMessages extends Notification
{
    /**
     * @return SmsRuMessage
     */
    public function toSmsRu(): SmsRuMessage
    {
        return new SmsRuMessage(
            new Multi([
                new To('79990000000', 'Hello'),
                new To('79991111111','Bonjour')
            ])
        );
    }
}
