<?php

namespace GoApptiv\FileManagement\Models\FileManagement;

use GoApptiv\FileManagement\Models\BaseModel;

/**
 *
 * @property int $id
 * @property string $uuid
 * @property string $variant_type
 * @property string $status
 * @property string $errors
 *
 */
class FileManagementVariantLog extends BaseModel
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'file_management_variant_logs';

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
