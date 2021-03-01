<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('disc_profiles')->insert([
            ['name' => 'Mediador', 'uuid' => md5(microtime())],
            ['name' => 'Planejador Carismático', 'uuid' => md5(microtime())],
            ['name' => 'Com desvio central', 'uuid' => md5(microtime())],
            ['name' => 'Com desvio para baixo', 'uuid' => md5(microtime())],
            ['name' => 'Com desvio para cima', 'uuid' => md5(microtime())],
            ['name' => 'Com desvio para cima ', 'uuid' => md5(microtime())],
            ['name' => 'Realizador', 'uuid' => md5(microtime())],
            ['name' => 'Mentor', 'uuid' => md5(microtime())],
            ['name' => 'Formador', 'uuid' => md5(microtime())],
            ['name' => 'Pioneiro', 'uuid' => md5(microtime())],
            ['name' => 'Ás', 'uuid' => md5(microtime())],
            ['name' => 'Encantador', 'uuid' => md5(microtime())],
            ['name' => 'Observador', 'uuid' => md5(microtime())],
            ['name' => 'Persistente', 'uuid' => md5(microtime())],
            ['name' => 'Pragmático', 'uuid' => md5(microtime())],
            ['name' => 'Detalhista', 'uuid' => md5(microtime())],
            ['name' => 'Comunicativo', 'uuid' => md5(microtime())],
            ['name' => 'Habilidoso', 'uuid' => md5(microtime())],
            ['name' => 'Persuasivo', 'uuid' => md5(microtime())],
        ]);
    }
}
