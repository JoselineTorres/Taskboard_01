<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CrearTransaccionTest extends TestCase
{
    use RefreshDatabase;

    public function test_cl02_monto_cero_responde_422(): void
    {
        $this->seed();
        Sanctum::actingAs(User::where('email', 'ana@taskboard.test')->first());

        $this->postJson('/api/transacciones', [
            'comercio_id'    => 1,
            'cliente_nombre' => 'Luis Mena',
            'monto'          => 0,
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors('monto');
    }

    // Reto: hoy falla (es el error E-01); mañana debe pasar sin tocar la prueba
    public function test_cl07_monto_sobre_el_maximo_responde_422(): void
    {
        $this->seed();
        Sanctum::actingAs(User::where('email', 'ana@taskboard.test')->first());

        $this->postJson('/api/transacciones', [
            'comercio_id'    => 1,
            'cliente_nombre' => 'Luis Mena',
            'monto'          => 100000000,
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors('monto');
    }
}