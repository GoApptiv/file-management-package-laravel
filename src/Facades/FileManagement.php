<?php

namespace GoApptiv\FileManagement\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @method static GoApptiv\FileManagement\Services\FileManagement\FileManagementService test()
 */
class FileManagement extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'goapptiv-file-management';
    }
}
