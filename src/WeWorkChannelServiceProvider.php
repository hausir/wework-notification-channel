<?php

namespace NotificationChannels\WeWork;

use EasyWeChat\Work\Application as WeWork;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;

class WeWorkChannelServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('wework', function ($app) {
                return new WeWorkChannel(
                    new WeWork($app['config']['services.wework'])
                );
            });
        });
    }
}
