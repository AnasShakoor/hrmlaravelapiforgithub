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
        Schema::create('guard_duties', function (Blueprint $table) {
            $table->id('id');
            $table->string('emirates_id')->nullable();
            $table->string('guard')->nullable();
            $table->string('company')->nullable();
            $table->string('time_policy')->nullable();
            $table->string('date_joining')->nullable();
            $table->string('duty_start_time')->nullable();
            $table->string('key')->nullable();
            $table->string('wireless')->nullable();
            $table->string('uniform')->nullable();
            $table->string('shoes')->nullable();
            $table->string('weapan')->nullable();
            $table->string('others')->nullable();
            $table->string('file')->nullable();
            $table->string('notes')->nullable();
            $table->foreignId('guard_id')->unique()->constrained('guards')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guard_duties');
    }
};
