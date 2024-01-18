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
        Schema::create('resignations', function (Blueprint $table) {
            $table->id('id');
            $table->string('emirates_id')->nullable();
            $table->string('guard_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('branch')->nullable();
            $table->string('resignation_date')->nullable();
            $table->string('reason')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('resignations');
    }
};
