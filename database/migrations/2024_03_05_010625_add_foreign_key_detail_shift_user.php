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
        Schema::table('detail_shift_user', function (Blueprint $table) {
            $table->foreign('user_id', 'fk_detail_shift_user__user')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('shift_id', 'fk_detail_shift_user__shift')
                ->references('id')
                ->on('shift')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_shift_user', function (Blueprint $table) {
            $table->dropForeign('fk_detail_shift_user__user');
            $table->dropForeign('fk_detail_shift_user__shift');
        });
    }
};
