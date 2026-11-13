<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $ana = User::create([
            'name'     => 'Ana López',
            'email'    => 'ana@taskboard.test',
            'password' => 'password123', // el cast 'hashed' la cifra
        ]);

        $carlos = User::create([
            'name'     => 'Carlos Pérez',
            'email'    => 'carlos@taskboard.test',
            'password' => 'password123',
        ]);

        // Comercio y transacciones de Ana
        $cafe = $ana->comercios()->create([
            'nombre_comercio'  => 'Café Amanecer',
            'rubro'            => 'Cafetería',
            'fecha_afiliacion' => now(),
        ]);
        $cafe->transacciones()->create([
            'monto' => 45.00, 'moneda' => 'USD', 'cliente_nombre' => 'María López',
            'metodo_pago' => 'Tarjeta', 'estado' => 'Iniciada',
        ]);
        $cafe->transacciones()->create([
            'monto' => 12.50, 'moneda' => 'USD', 'cliente_nombre' => 'Juan Pérez',
            'metodo_pago' => 'Tarjeta', 'estado' => 'Completada',
        ]);

        // Comercio y transacciones de Carlos
        $ferreteria = $carlos->comercios()->create([
            'nombre_comercio'  => 'Ferretería El Tornillo',
            'rubro'            => 'Ferretería',
            'fecha_afiliacion' => now(),
        ]);
        $ferreteria->transacciones()->create([
            'monto' => 30.00, 'moneda' => 'USD', 'cliente_nombre' => 'Sofía González',
            'metodo_pago' => 'Tarjeta', 'estado' => 'Iniciada',
        ]);
        $ferreteria->transacciones()->create([
            'monto' => 8.00, 'moneda' => 'USD', 'cliente_nombre' => 'Luis Martínez',
            'metodo_pago' => 'Tarjeta', 'estado' => 'Fallida',
        ]);
    }
}