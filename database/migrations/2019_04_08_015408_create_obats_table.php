<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('obat_id',20)->unique();;
            $table->string('nama_obat');
            $table->string('keterangan', 50);
            $table->string('perusahaan');
            $table->string('jenis')->nullable();
            $table->string('kategori')->nullable();
            $table->integer('penggunaan')->default(0);
            $table->boolean('status');
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
        Schema::dropIfExists('obats');
    }
}
