<?php

namespace App\Exceptions;

use Helper;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class RequestException extends Exception
{
    protected $message;
    protected $detailed_error;
    protected $code;
    protected $isLogin;

    public function __construct($message = "", $detailed_error = null , $code = null, $isLogin = false, Throwable $previous = null)
    {
        $this->message = $message;
        $this->detailed_error = $detailed_error;
        $this->code = $code;
        $this->isLogin = $isLogin;
        parent::__construct($message, $code, $previous);
    }

    public function render(Request $request): array
    {
        return Helper::createErrorResponse($this->message, $this->detailed_error, $this->code, $this->isLogin);
    }
}
