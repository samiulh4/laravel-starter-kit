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
        Schema::create('users_gender', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->enum('gender_code', ['M', 'F', 'N'])->unique()->comment('N for not applicable');
            $table->enum('is_active', [0, 1])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_gender');
    }
};
