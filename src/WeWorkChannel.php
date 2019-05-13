<?php

namespace NotificationChannels\WeWork;

use EasyWeChat\Work\Application as WeWork;
use Illuminate\Notifications\Notification;

class WeWorkChannel
{
    /**
     * The Wechat Work instance.
     *
     * @var WeWork
     */
    protected $weWork;

    /**
     * Create a new Nexmo channel instance.
     *
     * @param WeWork $weWork
     */
    public function __construct(WeWork $weWork)
    {
        $this->weWork = $weWork;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     * @return \Nexmo\Message\Message
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    public function send($notifiable, Notification $notification)
    {
        if (method_exists($notification, 'toWeWork')) {
            $message = $notification->toWeWork($notifiable);
        } else {
            $data = $notification->toMail($notifiable)->data();
            $message = array_reduce(array_keys($data), function ($carry, $key) use ($data) {
                return $carry . sprintf("%s: %s\n", $key, implode((array)$data[$key]));
            }, '');
        }

        return $this->weWork->messenger->send($message);
    }
}
