<?php

namespace LaraChimp\MangoRepo\Exceptions;

use Exception;

class InvalidModelException extends \RuntimeException
{
    /**
     * Exception Message.
     *
     * @var string
     */
    protected $message = 'Specified model target for the repository is not an Eloquent Model instance.';

    /**
     * InvalidModelException constructor.
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
