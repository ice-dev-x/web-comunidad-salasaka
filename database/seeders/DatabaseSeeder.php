<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void

    {   // Primero las categorías base
        $this->call(CategoriaSeeder::class);

        // Historia por defecto
        $this->call(HistoriaSeeder::class);   // NUEVA LÍNEA
        
        // Usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
