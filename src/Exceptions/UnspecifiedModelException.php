<?php

namespace LaraChimp\MangoRepo\Exceptions;

use Exception;

class UnspecifiedModelException extends \RuntimeException
{
    /**
     * Exception Message.
     *
     * @var string
     */
    protected $message = 'No Eloquent Model could referenced. Specify the Eloquent Model for this repository using the "@EloquentModel" annotation on the class.';

    /**
     * UnspecifiedModelException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Exception|null $previous
     */
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
