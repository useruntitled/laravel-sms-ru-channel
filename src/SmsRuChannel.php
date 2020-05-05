<?php

declare(strict_types=1);

namespace Kafkiansky\SmsRuChannel;

use Illuminate\Notifications\Notification;
use Kafkiansky\SmsRu\Message\SmsRuMessage;
use Kafkiansky\SmsRu\SmsRuApi;

final class SmsRuChannel
{
    /**
     * @var SmsRuApi
     */
    private $api;

    public function __construct(SmsRuApi $api)
    {
        $this->api = $api;
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSmsRu($notifiable);

        if ($message instanceof SmsRuMessage) {
            return $this->api->send($message);
        }

        return null;
    }
}
