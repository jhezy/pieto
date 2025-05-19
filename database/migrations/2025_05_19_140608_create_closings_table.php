<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClosingsTable extends Migration
{
    public function up()
    {
        Schema::create('closings', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique(); // hanya satu closing per tanggal
            $table->integer('jumlah_transaksi');
            $table->decimal('total_pendapatan', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('closings');
    }
}
