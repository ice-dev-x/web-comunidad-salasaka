<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nombres = ['Cultura', 'Eventos', 'Anuncios', 'Educación', 'Deportes'];

        foreach ($nombres as $nombre) {
            Categoria::updateOrCreate(['nombre' => $nombre]);
            
    }
}
}
