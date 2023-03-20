<?php

declare(strict_types=1);

namespace WebRegul\SmsRuChannel;

use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use WebRegul\SmsRu\SmsRuApi;
use WebRegul\SmsRu\SmsRuConfig;

final class SmsRuProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->singleton(SmsRuApi::class, static function (Application $application) {
            return new SmsRuApi(
                new SmsRuConfig($application->make('config')['services.sms_ru']),
                new Client()
            );
        });
    }

    public function provides()
    {
        return [
            SmsRuApi::class,
        ];
    }
}
