<?php

use Illuminate\Database\Seeder;

class HargaObatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('harga_obats')->truncate();
        $data =[
            ['id'=>1, 'id_obat'=>'konimexsanbe', 'harga'=>10000, 'tgl_awal'=>new DateTime, 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=>2, 'id_obat'=>'IBUPKIMITABLOBAT', 'harga'=>5000, 'tgl_awal'=>new DateTime, 'created_at' => new DateTime, 'updated_at' => new DateTime]
        ];
        DB::table('harga_obats')->insert($data);
    }
}
