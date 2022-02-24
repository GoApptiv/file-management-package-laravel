<?php

namespace GoApptiv\FileManagement\Repositories\MySql\FileManagement;

use GoApptiv\FileManagement\Exception\DataFieldsMissing;
use GoApptiv\FileManagement\Models\FileManagement\FileManagementLog;
use GoApptiv\FileManagement\Models\FileManagement\FileManagementLogData;
use GoApptiv\FileManagement\Repositories\FileManagement\FileManagementLogRepositoryInterface;
use GoApptiv\FileManagement\Repositories\MySql\MySqlBaseRepository;
use GoApptiv\FileManagement\Services\Utils;
use Illuminate\Support\Collection;

class FileManagementLogRepository extends MySqlBaseRepository implements FileManagementLogRepositoryInterface
{

    /**
     * Creates a new record
     *
     * @param FileManagementLogData $data
     * @return FileManagementLog
     */
    public function store($data)
    {
        $processedData = collect($this->formFields($data));

        if (!Utils::containsAll($processedData, ['reference_number', 'template_code', 'file_name', 'file_type', 'file_size_in_bytes'])) {
            throw new DataFieldsMissing();
        }
 
        $model = new FileManagementLog($processedData->toArray());

        $model->save();

        return $model->refresh();
    }

    /**
     * Updates the status and upload URL by id
     *
     * @param int $id
     * @param string $status
     * @param string $uuid
     * @return int
     */
    public function updateStatusAndUuidById($id, $status, $uuid)
    {
        return FileManagementLog::where('id', $id)->update([
            "status" => $status,
            "uuid" => $uuid
        ]);
    }

    /**
     * Updates the status by uuid
     *
     * @param string $uuid
     * @param string $status
     * @return int
     */
    public function updateStatusByUuid($uuid, $status)
    {
        return FileManagementLog::where('uuid', $uuid)->update([
            "status" => $status
        ]);
    }

    /**
     * Updates the status and errors by id
     *
     * @param int $id
     * @param string $errors
     * @return int
     */
    public function updateStatusAndErrorsById($id, $status, $errors)
    {
        return FileManagementLog::where('id', $id)->update([
            "status" => $status,
            "errors" => $errors
        ]);
    }

    /**
     * Updates the status and errors by uuid
     *
     * @param string $uuid
     * @param string $errors
     * @return int
     */
    public function updateStatusAndErrorsByUuid($uuid, $status, $errors)
    {
        return FileManagementLog::where('uuid', $uuid)->update([
            "status" => $status,
            "errors" => $errors
        ]);
    }

 
    /**
     *
     * Get Fields
     *
     * @param FileManagementLogData $data
     * @return Collection
     */
    public function formFields($data)
    {
        $fields = collect([]);

        if ($data->getReferenceNumber() !== null) {
            $fields->put('reference_number', $data->getReferenceNumber());
        }

        if ($data->getTemplateCode() !== null) {
            $fields->put('template_code', $data->getTemplateCode());
        }

        if ($data->getFileName() !== null) {
            $fields->put('file_name', $data->getFileName());
        }

        if ($data->getFileType() !== null) {
            $fields->put('file_type', $data->getFileType());
        }

        if ($data->getFileSizeInBytes() !== null) {
            $fields->put('file_size_in_bytes', $data->getFileSizeInBytes());
        }

        if ($data->getUuid() !== null) {
            $fields->put('uuid', $data->getUuid());
        }

        if ($data->getErrors() !== null) {
            $fields->put('errors', $data->getErrors());
        }
        
        if ($data->getStatus() !== null) {
            $fields->put('status', $data->getStatus());
        }

        return $fields;
    }
}
