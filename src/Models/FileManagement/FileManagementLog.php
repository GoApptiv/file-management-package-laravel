<?php

namespace GoApptiv\FileManagement\Models\FileManagement;

use GoApptiv\FileManagement\Models\BaseModel;

/**
 *
 * @property int $id
 * @property string $reference_number
 * @property string $template_code
 * @property string $file_type
 * @property string $file_name
 * @property int $file_size_in_bytes
 * @property string $uuid
 * @property string $status
 * @property string $errors
 *
 */
class FileManagementLog extends BaseModel
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'file_management_logs';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Hidden attributes
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
}
