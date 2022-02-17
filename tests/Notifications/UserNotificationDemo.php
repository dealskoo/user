<?php

namespace Dealskoo\User\Tests\Notifications;


use Dealskoo\User\Notifications\UserNotification;

class UserNotificationDemo extends UserNotification
{
    protected function title($notifiable)
    {
        return '';
    }

    protected function icon($notifiable)
    {
        return '';
    }

    protected function message($notifiable)
    {
        return '';
    }

    protected function data($notifiable)
    {
        return [];
    }

    protected function view($notifiable)
    {
        return 'user::nodata';
    }

}
