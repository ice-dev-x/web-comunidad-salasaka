<?php

namespace Database\Seeders;
use App\Models\Historia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Historia::firstOrCreate([], [
            'contenido' => 'Aquí va la historia tradicional de la comunidad Salasaka…'
        ]);
    }
    
}
