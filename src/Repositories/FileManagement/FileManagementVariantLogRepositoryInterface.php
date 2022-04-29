<?php

namespace GoApptiv\FileManagement\Repositories\FileManagement;

use GoApptiv\FileManagement\Repositories\BaseRepositoryInterface;
use GoApptiv\FileManagement\Models\FileManagement\Dto\FileManagementVariantLogData;

interface FileManagementVariantLogRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Creates a new record
     *
     * @param FileManagementVariantLogData $data
     * @return FileManagementVariantLog
     */
    public function store($data);

    /**
     * Updates the status by uuid
     *
     * @param string $uuid
     * @param string $status
     *
     * @return int
     */
    public function updateStatusByUuid($uuid, $status);

    /**
     * Updates the status and errors by uuid
     *
     * @param string $uuid
     * @param string $errors
     * @param string $url
     *
     * @return int
     */
    public function updateStatusAndErrorsByUuid($uuid, $status, $errors);

    /**
     * Update and status by UUID
     *
     * @param string $uuid
     * @param int $variantId
     *
     * @return int
     *
     */
    public function updateVariantIdByUuid($uuid, $variantId);
}
