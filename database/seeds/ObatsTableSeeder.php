<?php

use Illuminate\Database\Seeder;

class ObatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('obats')->truncate();
        
        $data =[
            ['id'=> 1, 'id_obat' => 'konimexsanbe', 'nama_obat' => 'Konimex', 'keterangan' => 'Obat sakit kepala', 'perusahaan' => 'SANBE', 'jenis'=>'TABLET', 'kategori' => 'Obat', 'status' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 2, 'id_obat' => 'sanmolsanbe', 'nama_obat' => 'Sanmol', 'keterangan' => 'Obat penurun panas', 'perusahaan' => 'SANBE', 'jenis'=>'TABLET', 'kategori' => 'Obat', 'status' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 3, 'id_obat' => 'decolgensanbe', 'nama_obat' => 'Decolgen', 'keterangan' => 'Obat flu', 'perusahaan' => 'SANBE', 'jenis'=>'TABLET', 'kategori' => 'Obat', 'status' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 4, 'id_obat' => 'konidinsanbe', 'nama_obat' => 'Konidin', 'keterangan' => 'Obat batuk cair', 'perusahaan' => 'SANBE', 'jenis'=>'SIRUP', 'kategori' => 'Obat', 'status' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime]
        ];
        DB::table('obats')->insert($data);
    }
}
