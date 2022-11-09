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
            'rol' => 'administrador'
        ]);

        DB::table('users')->insert([
            'name' => 'Jesus Antony Arratia Cama',
            'email' => 'gti-jarratia@cajalosandes.pe',
            'password' => Hash::make('gti-jarratia2022'),
            'rol' => 'administrador'
        ]);

        DB::table('users')->insert([
            'name' => 'Luane Nicole Salas Choque',
            'email' => 'lsalasc@cajalosandes.pe',
            'password' => Hash::make('lsalasc2022'),
            'rol' => 'admnistrador'
        ]);

        DB::table('users')->insert([
            'name' => 'CallCenter01',
            'email' => 'callcenter01@cajalosandes.pe',
            'password' => Hash::make('callcenter012022'),
            'rol' => 'ejecutor_pruebas'
        ]);

        DB::table('users')->insert([
            'name' => 'Operaciones01',
            'email' => 'operaciones01@cajalosandes.pe',
            'password' => Hash::make('operaciones012022'),
            'rol' => 'ejecutor_pruebas'
        ]);

        DB::table('users')->insert([
            'name' => 'Usuario1',
            'email' => 'usuario1@cajalosandes.pe',
            'password' => Hash::make('usuario12022'),
            'rol' => 'ejecutor_pruebas'
        ]);

        DB::table('users')->insert([
            'name' => 'Usuario2',
            'email' => 'usuario2@cajalosandes.pe',
            'password' => Hash::make('usuario22022'),
            'rol' => 'ejecutor_pruebas'
        ]);

        DB::table('users')->insert([
            'name' => 'Usuario3',
            'email' => 'usuario3@cajalosandes.pe',
            'password' => Hash::make('usuario32022'),
            'rol' => 'ejecutor_pruebas'
        ]);

        DB::table('users')->insert([
            'name' => 'Usuario4',
            'email' => 'usuario4@cajalosandes.pe',
            'password' => Hash::make('usuario42022'),
            'rol' => 'ejecutor_pruebas'
        ]);
    }
}
