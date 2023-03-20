<?php

declare(strict_types=1);

namespace WebRegul\SmsRuChannel\Tests\Fakes;

use Illuminate\Notifications\Notifiable;

class FakeNotifiable
{
    use Notifiable;

    public function routeNotificationForSmsRu()
    {
        return '79990000000';
    }
}
