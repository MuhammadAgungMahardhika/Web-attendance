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
        Schema::table('outsource_company', function (Blueprint $table) {
            $table->foreign('main_company_id', 'fk_outsource_company_main_company')
                ->references('id')
                ->on('main_company')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outsource_company', function (Blueprint $table) {
            $table->dropForeign('fk_outsource_company_main_company');
        });
    }
};
