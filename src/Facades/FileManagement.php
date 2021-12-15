<?php

namespace GoApptiv\FileManagement\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @method static GoApptiv\FileManagement\Services\FileManagement\FileManagementService getUploadUrl(string $templateCode, Collection $file)
 * @method static GoApptiv\FileManagement\Services\FileManagement\FileManagementService confirmUpload(string $uuid)
 * @method static GoApptiv\FileManagement\Services\FileManagement\FileManagementService getReadUrl(string $uuid)
 * @method static GoApptiv\FileManagement\Services\FileManagement\FileManagementService getBulkReadUrl(Collection $uuids)
 * @method static GoApptiv\FileManagement\Services\FileManagement\FileManagementService archive(string $uuid)
 *
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
