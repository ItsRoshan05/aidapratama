<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('nohp', 20);
            $table->string('email',30);
            $table->string('alamat', 255);
            $table->string('jenis_kelamin', 10);
            $table->enum('tipe_bank', ['Bank', 'E-Wallet'])->nullable();
            $table->string('nama_bank', 50)->nullable();
            $table->string('no_rekening', 50)->nullable();
            $table->string('atas_nama', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
