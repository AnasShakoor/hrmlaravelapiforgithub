<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guards', function (Blueprint $table) {
            $table->id('id');
            $table->string('name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('company')->nullable();
            $table->string('country')->nullable();
            $table->string('photo')->nullable();
            $table->string('passport')->nullable();
            $table->string('emirates_id_number')->nullable();
            $table->string('emirates_id_photo')->nullable();
            $table->string('resume')->nullable();
            $table->string('acount_holder_name')->nullable();
            $table->string('acount_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('location')->nullable();
            $table->string('tax_payer_id')->nullable();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->date('date')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guards');
    }
};
