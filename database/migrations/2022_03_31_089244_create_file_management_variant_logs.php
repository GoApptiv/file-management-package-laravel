<?php

use GoApptiv\FileManagement\Constants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileManagementVariantLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('file_management_mysql')->create('file_management_variant_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('variant_type');
            $table->bigInteger('variant_id')->nullable()->unique();
            $table->enum("status", Constants::$STATUS)->default(Constants::$PENDING);
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
        Schema::connection('file_management_mysql')->dropIfExists('file_management_variant_logs');
    }
}
