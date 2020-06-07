<?php
/**
 * Copyright 2020 Ben Create Co., Ltd <h.kano@ben-crate.co.jp>
 *
 * User: kanohirokazu
 * Date: 2020-06-06
 * Time: 11:07
 *
 * This source code or any portion thereof must not be
 * reproduced or used in any manner whatsoever.
 */

namespace App\Services\Slack;

use Illuminate\Support\Facades\Facade;

class SlackFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'slack';
    }
}
