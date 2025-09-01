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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name'); // Driver's full name
            $table->string('address'); // Driver's address
            $table->date('date_of_birth'); // Date of birth
            $table->string('email')->unique(); // Email (unique)
            $table->string('phone_number'); // Contact number
            $table->string('driver_id')->nullable(); // Internal driver ID
            $table->string('password'); // Hashed password
            $table->string('government_id')->nullable(); // Government ID number
            $table->string('gov_id_image')->nullable(); // Path for government ID image
            $table->string('license_front')->nullable(); // Path for license front image
            $table->string('license_back')->nullable(); // Path for license back image
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Verification status
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
