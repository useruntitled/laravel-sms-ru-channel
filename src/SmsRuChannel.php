<?php

declare(strict_types=1);

namespace WebRegul\SmsRuChannel;

use Illuminate\Notifications\Notification;
use Kafkiansky\SmsRu\Message\SmsRuMessage;
use Kafkiansky\SmsRu\Message\To;
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

        if (! ($to = $notifiable->routeNotificationFor('SmsRu', $notification))) {
            return null;
        }

        if (\is_string($message)) {
            return $this->api->send(new SmsRuMessage(new To($to, $message)));
        }

        return null;
    }
}
