<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id('id');
            $table->string('name')->nullable();
            $table->string('location')->nullable();
            $table->string('address')->nullable();
            $table->date('date')->nullable();
            $table->string('file')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->nullable()->comment('status may be active,onhold and cancelled');
            $table->string('contact')->nullable()->comment('usually the contact number of company');         
            // these values will be will not be taken from the client
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('user_type')->nullable()->default('company');
            $table->enum('user_status', ['active', 'inactive'])->default('active')->nullable()->comment('status may be active or inactive');
            
        
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
