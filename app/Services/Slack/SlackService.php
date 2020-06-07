<?php
/**
 * Copyright 2020 Ben Create Co., Ltd <h.kano@ben-crate.co.jp>
 *
 * User: kanohirokazu
 * Date: 2020-06-06
 * Time: 11:05
 *
 * This source code or any portion thereof must not be
 * reproduced or used in any manner whatsoever.
 */

namespace App\Services\Slack;

use Illuminate\Notifications\Notifiable;
use App\Notifications\SlackNotification;

class SlackService
{
    use Notifiable;

    /**
     * @param string $message
     */
    public function send($message)
    {
        $this->notify(new SlackNotification($message));
    }

    /**
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return config('slack.web_hook_url');
    }
}
