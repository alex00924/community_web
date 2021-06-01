<?php

namespace App\Exceptions;

use Exception;
use App\Http\Controllers\Controller;  
use Illuminate\Http\Request;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($this->shouldReport($exception)) {
            $msg = "```". $exception->getMessage().'```'.PHP_EOL;
            $msg .= "*File* `".$exception->getFile()."`, *Line:* ".$exception->getLine().", *Code:* ".$exception->getCode().PHP_EOL;
            sc_report($msg);
        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {   
        if ($this->isHttpException($exception)) {
            switch ($exception->getStatusCode()) {
                case '404':
                    // return view(
                    //     $this->templatePath . '.notfound',
                    //     array(
                    //         'title' => trans('front.not_found'),
                    //         'description' => '',
                    //         'keyword' => sc_store('keyword'),
                    //         'msg' => trans('front.item_not_found'),
                    //     )
                    // );
                    return \Response::view("notfound", array(), 404);
                    break;
                default:
                    return $this->renderHttpException($exception);
                    break;
            }
        } else {
            return parent::render($request, $exception);
        }
    }
}
