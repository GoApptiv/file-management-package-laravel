<?php

namespace GoApptiv\FileManagement\Repositories\MySql\FileManagement;

use GoApptiv\FileManagement\Exception\DataFieldsMissing;
use GoApptiv\FileManagement\Models\FileManagement\FileManagementVariantLog;
use GoApptiv\FileManagement\Models\FileManagement\Dto\FileManagementVariantLogData;
use GoApptiv\FileManagement\Repositories\FileManagement\FileManagementVariantLogRepositoryInterface;
use GoApptiv\FileManagement\Repositories\MySql\MySqlBaseRepository;
use GoApptiv\FileManagement\Services\Utils;
use Illuminate\Support\Collection;

class FileManagementVariantLogRepository extends MySqlBaseRepository implements FileManagementVariantLogRepositoryInterface
{
    /**
     * Creates a new record
     *
     * @param FileManagementVariantLogData $data
     * @return FileManagementVariantLog
     */
    public function store($data)
    {
        $processedData = collect($this->formFields($data));

        if (!Utils::containsAll($processedData, ['uuid', 'variant_type'])) {
            throw new DataFieldsMissing();
        }
 
        $model = new FileManagementVariantLog($processedData->toArray());

        $model->save();

        return $model->refresh();
    }

    /**
     * Updates the status by uuid
     *
     * @param string $uuid
     * @param string $status
     *
     * @return int
     */
    public function updateStatusByUuid($uuid, $status)
    {
        return FileManagementVariantLog::where('uuid', $uuid)->update([
            "status" => $status
        ]);
    }

    /**
     * Updates the status and errors by uuid
     *
     * @param string $uuid
     * @param string $errors
     *
     * @return int
     */
    public function updateStatusAndErrorsByUuid($uuid, $status, $errors)
    {
        return FileManagementVariantLog::where('uuid', $uuid)->update([
            "status" => $status,
            "errors" => $errors
        ]);
    }

    /**
     *
     * Get Fields
     *
     * @param FileManagementVariantLogData $data
     * @return Collection
     */
    public function formFields($data)
    {
        $fields = collect([]);

        if ($data->getUuid() !== null) {
            $fields->put('uuid', $data->getUuid());
        }

        if ($data->getVariantType() !== null) {
            $fields->put('variant_type', $data->getVariantType());
        }

        if ($data->getErrors() !== null) {
            $fields->put('errors', $data->getErrors());
        }
        
        if ($data->getStatus() !== null) {
            $fields->put('status', $data->getStatus());
        }

        return $fields;
    }

    /**
     * Update Variant Id by UUID
     *
     * @param string $uuid
     * @param int $variantId
     *
     * @return int
     *
     */
    public function updateVariantIdByUuid($uuid, $variantId)
    {
        return FileManagementVariantLog::where('uuid', $uuid)->update([
            "variant_id" => $variantId
        ]);
    }
}
