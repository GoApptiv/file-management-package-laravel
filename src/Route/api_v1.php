<?php

use GoApptiv\FileManagement\src\Con;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use GoApptiv\FileManagement\Controller\FileVariantController;

Route::prefix('api/goapptiv-file-management')->group(function () {
    Route::post('variant-callback', [FileVariantController::class, 'updateVariantDetails']);
});
