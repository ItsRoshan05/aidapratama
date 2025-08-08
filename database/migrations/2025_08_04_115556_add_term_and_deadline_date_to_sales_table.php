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
        Schema::table('sales', function (Blueprint $table) {
            //
        $table->integer('term')->default(0); // dalam hari
        $table->date('deadline_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            //

        $table->dropColumn(['term', 'deadline_date']); // Menghapus kolom 'term' dan 'deadline_date'
        });
    }
};
