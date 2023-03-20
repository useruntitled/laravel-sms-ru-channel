<?php

declare(strict_types=1);

namespace WebRegul\SmsRuChannel\Tests\Fakes;

use Illuminate\Notifications\Notification;
use WebRegul\SmsRu\Message\Multi;
use WebRegul\SmsRu\Message\SmsRuMessage;
use WebRegul\SmsRu\Message\To;

class TestNotificationWithManyMessages extends Notification
{
    /**
     * @return SmsRuMessage
     */
    public function toSmsRu(): SmsRuMessage
    {
        return new SmsRuMessage(
            new Multi([
                new To('79990000000', 'Hello'),
                new To('79991111111', 'Bonjour'),
            ])
        );
    }
}
