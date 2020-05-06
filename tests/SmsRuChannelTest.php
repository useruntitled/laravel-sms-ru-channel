<?php

declare(strict_types=1);

namespace Kafkiansky\SmsRuChannel\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Kafkiansky\SmsRu\SmsRuApi;
use Kafkiansky\SmsRu\SmsRuConfig;
use Kafkiansky\SmsRuChannel\SmsRuChannel;
use Kafkiansky\SmsRuChannel\Tests\Fakes\FakeNotifiable;
use Kafkiansky\SmsRuChannel\Tests\Fakes\NullNotifiable;
use Kafkiansky\SmsRuChannel\Tests\Fakes\TestNotificationWithManyMessages;
use Kafkiansky\SmsRuChannel\Tests\Fakes\TestNotificationWithSingleMessage;
use Kafkiansky\SmsRuChannel\Tests\Fakes\TestNotificationWithStringMessage;
use Kafkiansky\SmsRuChannel\Tests\Fakes\TestNullNotification;
use PHPUnit\Framework\TestCase;

final class SmsRuChannelTest extends TestCase
{
    /**
     * @var MockHandler
     */
    private $mockHandler;

    /**
     * @var SmsRuApi
     */
    private $smsRuApi;

    /**
     * @var SmsRuChannel
     */
    private $channel;

    protected function setUp(): void
    {
        $this->mockHandler = new MockHandler();

        $httpClient = new Client([
            'handler' => $this->mockHandler,
        ]);

        $this->smsRuApi = new SmsRuApi(
            new SmsRuConfig([
                'api_id' => 'XXXX-XXXX-XXXX',
                'test'   => 1,
                'json'   => 1,
            ]),
            $httpClient
        );

        $this->channel = new SmsRuChannel($this->smsRuApi);
    }

    public function testThatSingleMessageCanBeSend()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__.'/fixtures/send_single_message.json')));

        $response = $this->channel->send(new FakeNotifiable(), new TestNotificationWithSingleMessage());

        $this->assertTrue($response->isOk());
        $this->assertEquals(100, $response->getStatusCode());
        $this->assertEquals('OK', $response->getStatus());
        $this->assertEquals(10, $response->getBalance());
    }

    public function testThatManyMessagesCanBeSend()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__.'/fixtures/send_many_messages.json')));

        $response = $this->channel->send(new FakeNotifiable(), new TestNotificationWithManyMessages());

        $this->assertTrue($response->isOk());
        $this->assertEquals(100, $response->getStatusCode());
        $this->assertEquals('OK', $response->getStatus());
        $this->assertEquals(10, $response->getBalance());
    }

    public function testThatStringMessagesCanBeSend()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__.'/fixtures/string_message.json')));

        $response = $this->channel->send(new FakeNotifiable(), new TestNotificationWithStringMessage());

        $this->assertTrue($response->isOk());
        $this->assertEquals(100, $response->getStatusCode());
        $this->assertEquals('OK', $response->getStatus());
        $this->assertEquals(10, $response->getBalance());
    }

    public function testThatNullNotifiableWithStringMessageCannotBeSend()
    {
        $response = $this->channel->send(new NullNotifiable(), new TestNotificationWithStringMessage());

        $this->assertNull($response);
    }

    public function testThatNotNullNotifiableWithEmptyMessageCannotBeSend()
    {
        $response = $this->channel->send(new FakeNotifiable(), new TestNullNotification());

        $this->assertNull($response);
    }
}
