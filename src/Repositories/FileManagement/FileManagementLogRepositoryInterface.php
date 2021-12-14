<?php

namespace GoApptiv\FileManagement\Repositories\FileManagement;

use GoApptiv\FileManagement\Models\FileManagement\FileManagementLogData;
use GoApptiv\FileManagement\Repositories\BaseRepositoryInterface;

interface FileManagementLogRepositoryInterface extends BaseRepositoryInterface
{

    /**
     * Creates a new record
     *
     * @param FileManagementLogData $data
     * @return FileManagementLog
     */
    public function store(FileManagementLogData $data);

    /**
     * Updates the status and upload URL by id
     *
     * @param int $id
     * @param string $status
     * @return int
     */
    public function updateStatusAndUuidById(int $id, string $status, string $uuid);

    /**
     * Updates the status and errors by id
     *
     * @param int $id
     * @param string $errors
     * @param string $url
     * @return int
     */
    public function updateStatusAndErrorsById(int $id, string $status, string $errors);


    /**
     * Updates the status and errors by uuid
     *
     * @param string $uuid
     * @param string $errors
     * @param string $url
     * @return int
     */
    public function updateStatusAndErrorsByUuid(string $uuid, string $status, string $errors);

    /**
     * Updates the status by uuid
     *
     * @param string $uuid
     * @param string $status
     * @return int
     */
    public function updateStatusByUuid(string $uuid, string $status);
}
