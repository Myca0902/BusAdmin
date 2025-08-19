<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('forgot_password_requests', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->timestamp('requested_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forgot_password_requests');
    }
};
