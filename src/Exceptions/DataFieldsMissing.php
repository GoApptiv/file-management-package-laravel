<?php

namespace GoApptiv\FileManagement\Exception;

use Exception;

class DataFieldsMissing extends Exception
{
    protected $message = "Some fields are missing while creating record.";

    /**
     * Constructor with message
     *
     * @param $message
     * @return DataFieldsMissing
     */
    public static function withMessage($message)
    {
        $exception = new DataFieldsMissing();
        $exception->message = $message;
        return $exception;
    }
}
