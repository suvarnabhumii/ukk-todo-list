<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_register_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_users_can_authenticate(): void
    {
        $user = User::factory()->create([
            'username' => 'siswa123',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'username' => 'siswa123',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    public function test_user_can_create_task(): void
    {
        $user = User::factory()->create([
            'username' => 'budi',
        ]);

        $response = $this->actingAs($user)->post('/tasks', [
            'judul' => 'Tugas Matematika',
            'deskripsi' => 'Kerjakan halaman 50',
            'kategori' => 'Sekolah',
            'prioritas' => 'Tinggi',
            'deadline' => now()->addDays(2)->format('Y-m-d'),
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('tasks', [
            'judul' => 'Tugas Matematika',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_update_task_status(): void
    {
        $user = User::factory()->create(['username' => 'andi']);
        $task = Task::create([
            'user_id' => $user->id,
            'judul' => 'Tugas Kimia',
            'kategori' => 'Sekolah',
            'prioritas' => 'Sedang',
            'status' => 'Belum Selesai',
        ]);

        $response = $this->actingAs($user)->patch("/tasks/{$task->id}/status", [
            'status' => 'Selesai',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'Selesai',
        ]);
    }

    public function test_dashboard_renders_tasks_table(): void
    {
        $user = User::factory()->create(['username' => 'citra']);
        Task::create([
            'user_id' => $user->id,
            'judul' => 'Tugas Fisika',
            'kategori' => 'Sekolah',
            'prioritas' => 'Sedang',
            'status' => 'Belum Selesai',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('table-tasks');
        $response->assertSee('Tugas Fisika');
    }
}

