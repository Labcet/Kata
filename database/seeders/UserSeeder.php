<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Ernesto Zhildeer',
            'email' => 'gti-echura@cajalosandes.pe',
            'password' => Hash::make('gti-echura2022'),
            'rol' => 'administrador'
        ]);

        DB::table('users')->insert([
            'name' => 'Jhon Ever Maron Puma',
            'email' => 'gti-jmaron@cajalosandes.pe',
            'password' => Hash::make('gti-jmaron2022'),
            'rol' => 'gestor_incidencias'
        ]);

        DB::table('users')->insert([
            'name' => 'Jesus Antony Arratia Cama',
            'email' => 'gti-jarratia@cajalosandes.pe',
            'password' => Hash::make('gti-jarratia2022'),
            'rol' => 'gestor_incidencias'
        ]);

        DB::table('users')->insert([
            'name' => 'Luane Nicole Salas Choque',
            'email' => 'lsalasc@cajalosandes.pe',
            'password' => Hash::make('lsalasc2022'),
            'rol' => 'gestor_incidencias'
        ]);

        DB::table('users')->insert([
            'name' => 'Lucy Yulisa Sanchez Cueva',
            'email' => 'isanchez@cajalosandes.pe',
            'password' => Hash::make('isanchez2022'),
            'rol' => 'ejecutor_pruebas'
        ]);

        DB::table('users')->insert([
            'name' => 'Ronald Alexander Ramirez Rodriguez',
            'email' => 'rramirezro@cajalosandes.pe',
            'password' => Hash::make('rramirezro2022'),
            'rol' => 'ejecutor_pruebas'
        ]);

        DB::table('users')->insert([
            'name' => 'Deyvis Ramos Quispe',
            'email' => 'dramosq@cajalosandes.pe',
            'password' => Hash::make('dramosq2022'),
            'rol' => 'ejecutor_pruebas'
        ]);


    }
}
