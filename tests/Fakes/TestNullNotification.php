<?php

namespace Kafkiansky\SmsRuChannel\Tests\Fakes;

use Illuminate\Notifications\Notification;

class TestNullNotification extends Notification
{
    public function toSmsRu($notifiable)
    {
        return null;
    }
}
