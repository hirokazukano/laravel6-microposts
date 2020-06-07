<?php

namespace App\Exceptions;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        // logが保存される
        parent::report($exception);

        $this->sendSlack($exception);
    }

    /**
     * 必要なエラーのみ通知
     * validationExceptionなどはIlluminate\Foundation\Exceptions\Handler.php $internalDontReportで定義済み
     *
     * @param Exception $exception
     */
    public function sendSlack(Exception $exception)
    {
        if ($this->shouldReport($exception)) {
            $message = implode("\n", [
                $exception->getFile(),
                $exception->getLine(),
                $exception->getMessage(),
            ]);

            \Slack::send($message);
            //$this->sendSlackByGuzzle($message);
        }
    }

    /**
     * @param $message
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendSlackByGuzzle($message)
    {
        $client = new Client();
        $client->request('POST', config('slack.web_hook_url'), [
            'json' => [
                'username' => 'TestUser',
                'channel' => config('slack.channel'),
                'text' => $message,
            ],
        ]);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}
