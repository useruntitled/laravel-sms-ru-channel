<?php

namespace WebRegul\SmsRuChannel\Tests\Fakes;

use Illuminate\Notifications\Notification;

class TestNotificationWithStringMessage extends Notification
{
    public function toSmsRu($notifiable): string
    {
        return 'Hello';
    }
}
