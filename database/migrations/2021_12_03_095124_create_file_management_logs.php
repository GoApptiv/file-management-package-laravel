<?php

use GoApptiv\FileManagement\Constants;
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
        Schema::connection('file_management_mysql')->create('file_management_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_number')->unique();
            $table->string('template_code');
            $table->string('file_type');
            $table->string('file_name');
            $table->bigInteger('file_size_in_bytes');
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
        Schema::connection('file_management_mysql')->dropIfExists('file_management_logs');
    }
}
