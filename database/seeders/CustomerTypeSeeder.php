<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

class CustomerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer_types')->insert([
            [
                'name'=> 'Administrativo',
                'slug' => Str::slug('Administrativo')
            ],
            [
                'name'=> 'Agilidade',
                'slug' => Str::slug('Agilidade')
            ],
            [
                'name'=> 'Comercial',
                'slug' => Str::slug('Comercial')
            ],
            [
                'name'=> 'Coaching',
                'slug' => Str::slug('Coaching')
            ],
            [
                'name'=> 'Em processo seletivo',
                'slug' => Str::slug('Em processo seletivo')
            ],
            [
                'name'=> 'Educação',
                'slug' => Str::slug('Educação')
            ],
            [
                'name'=> 'Estudante',
                'slug' => Str::slug('Estudante')
            ],
            [
                'name'=> 'Financeiro',
                'slug' => Str::slug('Financeiro')
            ],
            [
                'name'=> 'Jurídico',
                'slug' => Str::slug('Jurídico')
            ],
            [
                'name'=> 'Mentoria',
                'slug' => Str::slug('Mentoria')
            ],
            [
                'name'=> 'Projetos',
                'slug' => Str::slug('projetos')
            ],
            [
                'name'=> 'RH',
                'slug' => Str::slug('rh')
            ],
            [
                'name'=> 'TI',
                'slug' => Str::slug('ti')
            ],
            [
                'name'=> 'Treinamentos',
                'slug' => Str::slug('treinamentos')
            ],
            [
                'name'=> 'Outro',
                'slug' => Str::slug('outro')
            ],
        ]);
    }
}
