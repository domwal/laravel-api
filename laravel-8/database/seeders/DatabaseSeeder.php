<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	// limpar as tabelas antes de inserir
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	DB::table('marcas')->truncate();
    	DB::table('users')->truncate();
    	DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    	// marcas
        $marcas = array_unique(['Eletrolux', 'Brastemp']);
        $dados = [];
        foreach ($marcas as $nome) {
            $dados[] = [
                'nome' => $nome,
                'slug' => $this->slugify($nome, [], '-'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // insert marcas
        \DB::table('marcas')->insert(
            $dados
        );

        // users
        \App\Models\User::factory(1)->create();
    }

    private function slugify($string, $replace = array(), $delimiter = '-')
    {
        // https://github.com/phalcon/incubator/blob/master/Library/Phalcon/Utils/Slug.php
        if (!extension_loaded('iconv')) {
            throw new Exception('iconv module not loaded');
        }
        // Save the old locale and set the new locale to UTF-8
        $oldLocale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'en_US.UTF-8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        if (!empty($replace)) {
            $clean = str_replace((array) $replace, ' ', $clean);
        }
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower($clean);
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = trim($clean, $delimiter);
        // Revert back to the old locale
        setlocale(LC_ALL, $oldLocale);
        return $clean;
    }
}
