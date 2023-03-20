<?php

declare(strict_types=1);

namespace WebRegul\SmsRuChannel\Tests\Fakes;

use Illuminate\Notifications\Notification;
use WebRegul\SmsRu\Message\SmsRuMessage;
use WebRegul\SmsRu\Message\To;

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
