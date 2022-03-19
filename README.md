# GoApptiv FileManagement Package Laravel

This package will be used for managing files on cloud bucket.


# Installation
Add the following code in the composer to install this package into your Laravel Project

Add the package name in the composer require

```json
"goapptiv/file-management": "1.0.0"
```
```json
"repositories": [
    {
        "type": "git",
        "url": "https://github.com/GoApptiv/file-management-package-laravel"
    }
]
```

Add the following keys in your environment variables. Please contact the package manager for the following key values.

```env
FILE_MANAGEMENT_URL=
FILE_MGMT_TOKEN=
```

Create A New Schema in your database with name "file_management"

Add the following Database keys in your environment variables. Kindly use your database credentials and create a database name communication in your MySQL.

```env
FILE_MGMT_DB_HOST=127.0.0.1
FILE_MGMT_DB_PORT=port
FILE_MGMT_DB_DATABASE=file_management
FILE_MGMT_DB_USERNAME=user
FILE_MGMT_DB_PASSWORD=password
```

Create a new connection in config/database.php, You can create a new connection by copying the "mysql" format and change the environment variable to FILE_MGMT environment variables

For Example (Connection format might differ in your Laravel version)

```php
'file_management_mysql' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('FILE_MGMT_DB_HOST', '127.0.0.1'),
    'port' => env('FILE_MGMT_DB_PORT', '3306'),
    'database' => env('FILE_MGMT_DB_DATABASE', 'forge'),
    'username' => env('FILE_MGMT_DB_USERNAME', 'forge'),
    'password' => env('FILE_MGMT_DB_PASSWORD', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
    PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
]
```

Use the following commands to run the migrations in the SQL Database

```bash
php artisan vendor:publish --tag=file-management-migrations
php aritsan migrate
```

# Usage

## Get Upload URL

The Get Upload URL method will request **File Storage Service** for upload URL and hashId required for uploading the file. 

```php

use GoApptiv\FileManagement\Facades\FileManagement;
use GoApptiv\FileManagement\Models\FileManagement\File;

$file = new File(string $type, string $name, int $sizeInBytes)

FileManagement::getUploadUrl(string $templateCode, File $file);
```

### Parameters

|Name         |Type  |Description                                          |
|-------------|------|-----------------------------------------------------|
|$type        |string|Mime type of the file                                |
|$name        |string|Name of the file                                     |    
|$size        |int   |Size of the file                                     |
|$templateCode|string|Template code registered in **File Storage Service** |

***

## Confirm File Upload

The Confirm File Upload method will request **File Storage Service** to confirm the file upload to bucket.

```php
use GoApptiv\FileManagement\Facades\FileManagement;

FileManagement::confirmUpload(string $uuid);
```

### Parameters

|Name         |Type  |Description                                |
|-------------|------|-------------------------------------------|
|$uuid        |string|Univeral Unique Id received with upload URL|

***

## Get Read File URL

The Read File URL method will request **File Storage Service** for read URL.

```php
use GoApptiv\FileManagement\Facades\FileManagement;

FileManagement::getReadUrl(string $uuid);
```

### Parameters

|Name         |Type  |Description                                |
|-------------|------|-------------------------------------------|
|$uuid        |string|Univeral Unique Id received with upload URL|

***

## Get Read File URL in Bulk

The Read File URL method will request **File Storage Service** for read URL in bulk.

```php
use GoApptiv\FileManagement\Facades\FileManagement;

FileManagement::getBulkReadUrl(Collection $uuids);
```

### Parameters

|Name         |Type      |Description                                      |
|-------------|----------|-------------------------------------------------|
|$uuids       |Collection|Array of Univeral Unique Id's with key as `uuids`|

***

## Archive File

The Archive File method will request **File Storage Service** for archive file uploaded in bucket.

```php
use GoApptiv\FileManagement\Facades\FileManagement;

FileManagement::archive(string $uuid);
```

### Parameters

|Name         |Type      |Description                                |
|-------------|----------|-------------------------------------------|
|$uuid        |string    |Univeral Unique Id received with upload URL|
