<?php

namespace GoApptiv\FileManagement\Services;

class Endpoints
{
    public static $GET_FILE_UPLOAD_URL = '/v1/files';
    public static $CONFIRM_FILE_UPLOAD = '/v1/files/confirm';
    public static $GET_FILE_READ_URL = '/v1/files/uuid/';
    public static $GET_BULK_FILE_READ_URL = '/v1/files/bulk/uuid';
    public static $ARCHIVE_FILES = '/v1/files/archive';
}
