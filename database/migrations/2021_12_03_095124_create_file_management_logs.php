<?php

use GoApptiv\FileManagement\Constants\Constants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileManagementLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_management_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_number')->unique();
            $table->string('template_code');
            $table->string('file_type');
            $table->string('file_name');
            $table->string('file_size');
            $table->string('upload_url')->nullable();
            $table->string('uuid')->nullable();
            $table->enum("status", Constants::$STATUS)->default(Constants::$REQUESTED);
            $table->longText('errors')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_management_logs');
    }
}
