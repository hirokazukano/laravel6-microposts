# Laravel6 microposts

## 追加機能

### コード補完機能
- [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)使用
- `composer require --dev barryvdh/laravel-ide-helper`でインストール
  
### Controller、Model、ViewにPHPDoc記入

### 以下actionにflushメッセージ表示
- MicropostsController
  - store(),destroy()
- UserFollowController
  - store(), destroy()  
- 表示部分はresources/views/commons/messages.blade.php      

### エラーSlack通知機能(2種類)
- app/Exceptions/Handler.php sendSlack()で通知
1. 自作Slackファサード機能版の呼び出し方法  
`\Slack::send('メッセージ');`
2. guzzleで簡単に送信する方法  
app/Exceptions/Handler.phpのsendSlackByGuzzle()を実行

### 実際にSlackに通知させる方法
- [laravel/slack-notification-channel](https://github.com/laravel/slack-notification-channel)インストール
  - `composer require laravel/slack-notification-channel`
- .envに以下を追記(値は任意のもの)
  - SLACK_USERNAME=TestUser
  - SLACK_ICON=:fire:
  - SLACK_CHANNEL=test-microposts
  - SLACK_WEB_HOOK_URL=url
    
### testコードを以下に追加 
- tests/Feature/
- tests/Unit/ 
- 実行は`vendor/bin/phpunit`

### circeciでtest、Herokuへデプロイするci環境
- Herokuへ初回デプロイが完了していることが条件
- .circleci/config.yml 56行目の`HEROKU_APP`を自分のアプリ名に変更
- circleciでプロジェクトを作成し、以下の環境変数設定が必要
  - HEROKU_API_KEY
    - [Manage Account](https://dashboard.heroku.com/account)のAPI Keyの値を入力  
  - HEROKU_LOGIN
    - loginメールアドレスを入力
- Chat NotificationsにSlackのWebhook URLを記入するとci結果を通知可能
- 設定が正しいと`git push origin master`でcircleciが起動しtest実行、成功時のみHerokuへデプロイ

### 多言語切り替え機能
- [Laravel 5 And His F*cking non-persistent App SetLocale](https://mydnic.be/post/laravel-5-and-his-fcking-non-persistent-app-setlocale)を参考に実装
- 英語、日本語の切り替えが可能でTOPページの「Welcome to the Microposts」、navbar1番右の「言語切り替え」のみ切り替え実装済み
- デフォルトは日本語
