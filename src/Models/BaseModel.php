<?php

namespace GoApptiv\FileManagement\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    
    /**
     * Connection name
     *
     * @var string
     */
    protected $connection = 'file_management_mysql';

    /**
     *
     * Gets the table name
     *
     * @return string
     */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
