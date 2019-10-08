<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('no');
            $table->string('no_invoice', 19);
            $table->string('id', 20);
            $table->integer('qty');
            $table->integer('harga');
            $table->integer('ttl_harga');
            $table->string('status', 10);
            $table->date('tgl_transaksi');
            $table->string('no_rekap', 16);
            $table->string('jenis', 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
