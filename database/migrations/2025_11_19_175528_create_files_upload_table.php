<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files_upload', function (Blueprint $table) {
            $table->id();
            $table->string('file_path', 255);
            $table->string('table_name', 100)->nullable();
            $table->string('field_name', 50)->nullable();
            $table->enum('field_status', [0, 1])->default(0);
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files_upload');
    }
};
