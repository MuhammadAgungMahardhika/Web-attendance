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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id', false, true);
            $table->time('checkin')->nullable();
            $table->time('checkout')->nullable();
            $table->date('date')->nullable();
            $table->enum("status", ["in", "out", "late"])->nullable();
            $table->enum("work_from", ["office", "home"])->nullable();
            $table->point("location")->nullable();
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
        Schema::dropIfExists('attendance');
    }
};
