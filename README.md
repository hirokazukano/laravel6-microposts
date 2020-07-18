# Laravel6 microposts

## 追加機能
- [コード補完機能](#コード補完機能)
- [EditorConfigを使用](#EditorConfigを使用)
- [Controller、Model、ViewにPHPDoc記入](#ControllerModelViewにPHPDoc記入)
- [flushメッセージ表示](#flushメッセージ表示)
- [エラーSlack通知機能(2種類)](#エラーSlack通知機能(2種類))
  - [実際にSlackに通知させる方法](#実際にSlackに通知させる方法)
- [testコード追加](#testコード追加)
- [circeciでテスト、HerokuへデプロイするCI、CD環境](#circeciでテストHerokuへデプロイするCICD環境)
  - [CIで使用するツール](#CIで使用するツール)
- [多言語切り替え機能](#多言語切り替え機能)
- [SEO対策](#SEO対策)
- [Laravel Mix導入](#Laravel Mix導入)


## コード補完機能
- [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)使用
- `composer require --dev barryvdh/laravel-ide-helper`でインストール
___
  
### EditorConfigを使用
- [EditorConfig](https://editorconfig.org/)を使ってレイアウトを統一(改行コードやタブの空白数など)
- .editorconfigで設定
___

### Controller、Model、ViewにPHPDoc記入
- 各ファイルにPHPDocを記入
___

### flushメッセージ表示
以下actionにflushメッセージ表示
- MicropostsController
  - store(),destroy()
- UserFollowController
  - store(), destroy()  
- 表示部分はresources/views/commons/messages.blade.php      
___

### エラーSlack通知機能(2種類)
- app/Exceptions/Handler.php sendSlack()で通知
1. 自作Slackファサード機能版の呼び出し方法  
`\Slack::send('メッセージ');`
2. guzzleで簡単に送信する方法  
app/Exceptions/Handler.phpのsendSlackByGuzzle()を実行
___

### 実際にSlackに通知させる方法
- [laravel/slack-notification-channel](https://github.com/laravel/slack-notification-channel)インストール
  - `composer require laravel/slack-notification-channel`
- .envに以下を追記(値は任意のもの)
  - SLACK_USERNAME=TestUser
  - SLACK_ICON=:fire:
  - SLACK_CHANNEL=test-microposts
  - SLACK_WEB_HOOK_URL=url
___
    
### testコード追加 
以下にtestコードを追加

- tests/Feature/
- tests/Unit/ 
- 実行は`vendor/bin/phpunit`
___

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
___

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
___

### 多言語切り替え機能
- [Laravel 5 And His F*cking non-persistent App SetLocale](https://mydnic.be/post/laravel-5-and-his-fcking-non-persistent-app-setlocale)を参考に実装
- 英語、日本語の切り替えが可能でTOPページの「Welcome to the Microposts」、navbar1番右の「言語切り替え」のみ切り替え実装済み
- デフォルトは日本語
___

### SEO対策
- title、descriptionタグをbladeから動的に設定できるようにする
- SignUp、Loginページのみ実装
---

### Laravel Mix導入
- node js、npmのインストールが必要
- `npm install`後、開発時は`npm run watch`、デプロイ時は`npm run prod`を実行
- webpack.mix.jsにcss、jsのコンパイル、ビルド処理、browserSyncの実行を追加
- 生成されたpublic/css/index.min.css、public/js/index.min.jsを本番、開発環境で読み込みを切り替えるようにviews/layouts/app.blade.phpを変更
- .git/pre-commitに以下を記載する事でcommit直前に`npm run prod`が実行され、本番環境用のcss、jsファイルがcommitに含まれる
```
npm run prod
git add public/css/*.min.css
git add public/js/*.min.js
```
