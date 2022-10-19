<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequerimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('requerimientos')->insert([
            'codigo' => 'RQ221',
            'nombre' => 'requerimiento Kata',
            'observacion' => ''
        ]);
    }
}
