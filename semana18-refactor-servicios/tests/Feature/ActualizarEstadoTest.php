<?php

namespace Tests\Feature;

use App\Models\Comercio;
use App\Models\Transaccion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ActualizarEstadoTest extends TestCase
{
    use RefreshDatabase;

    private function transaccionDe(User $user, string $estado = 'Iniciada'): Transaccion
    {
        $comercio = Comercio::factory()->create(['user_id' => $user->id]);

        return Transaccion::factory()->create([
            'comercio_id' => $comercio->id,
            'estado'      => $estado,
        ]);
    }

    public function test_cambia_el_estado_y_registra_el_evento(): void
    {
        $user = User::factory()->create();
        $t = $this->transaccionDe($user);
        Sanctum::actingAs($user);

        $this->patchJson("/api/transacciones/{$t->id}", ['estado' => 'Completada'])
            ->assertOk()
            ->assertJsonPath('data.estado', 'Completada');

        $this->assertDatabaseHas('transacciones', ['id' => $t->id, 'estado' => 'Completada']);
        $this->assertDatabaseHas('eventos_transaccion', [
            'transaccion_id'  => $t->id,
            'estado_anterior' => 'Iniciada',
            'estado_nuevo'    => 'Completada',
        ]);
    }

    public function test_una_transaccion_cerrada_devuelve_422(): void
    {
        $user = User::factory()->create();
        $t = $this->transaccionDe($user, 'Completada');
        Sanctum::actingAs($user);

        $this->patchJson("/api/transacciones/{$t->id}", ['estado' => 'Fallida'])
            ->assertStatus(422)
            ->assertJsonPath('message', 'La transacción ya fue cerrada');

        $this->assertDatabaseHas('transacciones', ['id' => $t->id, 'estado' => 'Completada']);
    }

    public function test_una_transaccion_de_otro_usuario_devuelve_404(): void
    {
        $dueno = User::factory()->create();
        $t = $this->transaccionDe($dueno);
        Sanctum::actingAs(User::factory()->create());

        $this->patchJson("/api/transacciones/{$t->id}", ['estado' => 'Completada'])
            ->assertNotFound();
    }

    public function test_un_estado_invalido_devuelve_422(): void
    {
        $user = User::factory()->create();
        $t = $this->transaccionDe($user);
        Sanctum::actingAs($user);

        $this->patchJson("/api/transacciones/{$t->id}", ['estado' => 'Pagada'])
            ->assertStatus(422)
            ->assertJsonValidationErrors('estado');
    }
}