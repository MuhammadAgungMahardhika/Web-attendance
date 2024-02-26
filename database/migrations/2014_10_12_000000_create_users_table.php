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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('role_id', false, true);
            $table->bigInteger('main_company_id', false, true)->nullable();
            $table->bigInteger('outsource_company_id', false, true)->nullable();
            $table->string('name');
            $table->string('phone_number', 15)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('departmen')->nullable();
            $table->string('password');
            $table->enum('status', ['active', 'inactive']);
            $table->geometry('location')->nullable();
            $table->rememberToken();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
