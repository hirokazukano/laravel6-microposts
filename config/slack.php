<?php
/**
 * Slack設定
 */

return [

    'user_name' =>  env('SLACK_USERNAME', 'エラー通知'),
    'icon' =>  env('SLACK_ICON', ':fire:'),
    'channel' =>  env('SLACK_CHANNEL', 'notice-error'),
    'web_hook_url' =>  env('SLACK_WEB_HOOK_URL', 'https://hooks.slack.com/services/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'),

];
