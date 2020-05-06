<?php

declare(strict_types=1);

namespace Kafkiansky\SmsRuChannel\Tests\Fakes;

use Illuminate\Notifications\Notification;
use Kafkiansky\SmsRu\Message\SmsRuMessage;
use Kafkiansky\SmsRu\Message\To;

class TestNotificationWithSingleMessage extends Notification
{
    /**
     * @return SmsRuMessage
     */
    public function toSmsRu(): SmsRuMessage
    {
        return new SmsRuMessage(
            new To('79990000000', 'Hello')
        );
    }
}
