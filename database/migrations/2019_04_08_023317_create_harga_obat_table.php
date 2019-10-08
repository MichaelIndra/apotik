<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHargaObatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_obats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('obat_id',20);
            $table->integer('harga');
            $table->string('kategori',7);
            $table->date('tgl_awal');
            $table->date('tgl_akhir')->nullable();
            $table->timestamps();
            $table->foreign('obat_id')->references('obat_id')->on('obats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('harga_obats');
    }
}
