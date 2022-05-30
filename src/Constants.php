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
    public static $SUCCESS = 'success';
    public static $PENDING = 'pending';

    // method types
    public static $GET_METHOD = 'GET';
    public static $POST_METHOD = 'POST';
    public static $PUT_METHOD = 'PUT';

    // plugin codes
    public static $VISION_API_PLUGIN_CODE = 'GOOGLE_VISION';

    public static $STATUS = [];
    public static $PLUGIN_CODES = [];

    public static function init()
    {

        // status
        self::$STATUS = [
            self::$REQUESTED,
            self::$GENERATED,
            self::$CONFIRMED,
            self::$FAILED,
            self::$DELETED,
            self::$SUCCESS,
            self::$PENDING
        ];

        self::$PLUGIN_CODES = [
            self::$VISION_API_PLUGIN_CODE
        ];
    }
}

Constants::init();
