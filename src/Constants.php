<?php

namespace GoApptiv\FileManagement;

class Constants
{
    public static $APPLICATION_JSON = 'application/json';

    // status
    public static $REQUESTED = 'requested';
    public static $GENERATED = 'generated';
    public static $CONFIRMED = 'confirmed';
    public static $FAILED = 'failed';
    public static $DELETED = 'deleted';

    // method types
    public static $GET_METHOD = 'GET';
    public static $POST_METHOD = 'POST';
    public static $PUT_METHOD = 'PUT';

    public static $STATUS = [];

    public static function init()
    {

        // status
        self::$STATUS = [
            self::$REQUESTED,
            self::$GENERATED,
            self::$CONFIRMED,
            self::$FAILED,
            self::$DELETED
        ];
    }
}

Constants::init();
