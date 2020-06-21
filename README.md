# Laravel6 microposts

## 追加機能

### コード補完機能
- [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)使用
- `composer require --dev barryvdh/laravel-ide-helper`でインストール
  
### [EditorConfig](https://editorconfig.org/)を使ってレイアウトを統一(改行コードやタブの空白数など)
- .editorconfigで設定

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

### circeciでテスト、HerokuへデプロイするCI、CD環境
- Herokuへ初回デプロイが完了していることが条件
- .circleci/config.yml 58行目の`HEROKU_APP`を自分のアプリ名に変更
- circleciでプロジェクトを作成し、以下の環境変数設定が必要
  - HEROKU_API_KEY
    - [Manage Account](https://dashboard.heroku.com/account)のAPI Keyの値を入力  
  - HEROKU_LOGIN
    - loginメールアドレスを入力
- Chat NotificationsにSlackのWebhook URLを記入するとCI結果を通知可能
- 設定が正しいと`git push origin master`でcircleciが起動しtest実行、成功時のみHerokuへデプロイ
- Heroku以外にデプロイする場合は[deployphp/deployer](https://github.com/deployphp/deployer)を使うと簡単でオススメ

### CIで使用するツール

- 以下のCI実行時の成果物は./build/*に格納される
- circleciで実行した場合はcircleciの「Artifacts」タブに格納されるので各リンクをクリックして確認可能
- 以下のツールは全て使わなければいけないという事ではなく、必要な物だけを選んで使うようにする

- [Phing](https://www.phing.info/)
  - ビルドツールで以下の各ツールの実行をbuild.xmlにまとめて記載しコマンド一発で実行可能にする
  - `build/tools/phing-2.16.3.phar -verbose`

- [phpunit](https://phpunit.readthedocs.io/ja/latest/)
  - テストとガバレッジ自動生成
  - 単独実行 `vendor/bin/phpunit --coverage-html ./build/phpunit`
  - ./build/phpunit/index.htmlで成果物を確認可能

- [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
  - コーディング規約をチェックをしてくれる
  - 単独実行 `build/tools/phpcs.phar app/ --standard=PSR2 --report=xml --report-file=./build/logs/phpcs.xml`
  - ./build/logs/phpcs.xmlで成果物を確認可能
  
- [PHPMD](https://phpmd.org/)
  - PHP Mess Ditector 使われていない変数やコードの潜在的なバグになりそうな箇所や実装上の問題を検出してくれる
  - 単独実行 `build/tools/phpmd.phar app/ html codesize,design,naming,unusedcode --reportfile ./build/logs/phpmd.html`
  - ./build/logs/phpmd.htmlで成果物を確認可能

- [PHPCPD](https://github.com/sebastianbergmann/phpcpd)
  - PHP Copy/Paste Detector 重複コードを見つけてくれる
  - 単独実行 `build/tools/phpcpd-5.0.2.phar app/ --log-pmd=./build/logs/phpcpd.xml`
  - ./build/logs/phpcpd.xmlで成果物を確認可能

- [PHPLOC](https://github.com/sebastianbergmann/phploc)
  - プロジェクトのファイルサイズ、構成などの分析
  - 単独実行 `build/tools/phploc-6.0.2.phar app/ --log-xml ./build/logs/phploc.xml`
  - ./build/logs/phploc.xmlで成果物を確認可能

- [phpDocumentor](https://www.phpdoc.org/) 
  - ドキュメントの自動生成
  - 単独実行 `build/tools/phpDocumentor.phar -d app/ -t build/doc` 
  - ./build/doc/index.htmlで成果物を確認可能

### 多言語切り替え機能
- [Laravel 5 And His F*cking non-persistent App SetLocale](https://mydnic.be/post/laravel-5-and-his-fcking-non-persistent-app-setlocale)を参考に実装
- 英語、日本語の切り替えが可能でTOPページの「Welcome to the Microposts」、navbar1番右の「言語切り替え」のみ切り替え実装済み
- デフォルトは日本語
