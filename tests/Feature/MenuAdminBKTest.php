<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Peminatan;
use App\Models\Kriteria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuAdminBKTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $guruBk;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test users
        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->guruBk = User::create([
            'name' => 'Guru BK Test',
            'email' => 'guru@test.com',
            'password' => bcrypt('password'),
            'role' => 'guru_bk',
        ]);

        // Create test data
        Peminatan::create([
            'nama' => 'IPA',
            'deskripsi' => 'Ilmu Pengetahuan Alam',
        ]);

        Kriteria::create([
            'peminatan_id' => 1,
            'nama' => 'Matematika',
            'kode' => 'C1',
            'mapel' => 'matematika',
            'bobot' => 0.25,
            'tipe' => 'benefit',
        ]);
    }

    /**
     * Test: Admin dapat mengakses menu Jalankan SAW
     */
    public function test_admin_can_access_jalankan_saw()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('guru.jalankan-saw.index'));

        $response->assertStatus(200);
        $response->assertViewIs('guru.jalankan-saw.index');
    }

    /**
     * Test: Guru BK dapat mengakses menu Jalankan SAW
     */
    public function test_guru_bk_can_access_jalankan_saw()
    {
        $response = $this->actingAs($this->guruBk)
            ->get(route('guru.jalankan-saw.index'));

        $response->assertStatus(200);
        $response->assertViewIs('guru.jalankan-saw.index');
    }

    /**
     * Test: Admin dapat mengakses menu Hasil Alokasi
     */
    public function test_admin_can_access_hasil_alokasi()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('guru.hasil-alokasi.index'));

        $response->assertStatus(200);
        $response->assertViewIs('guru.hasil-alokasi.index');
    }

    /**
     * Test: Guru BK dapat mengakses menu Hasil Alokasi
     */
    public function test_guru_bk_can_access_hasil_alokasi()
    {
        $response = $this->actingAs($this->guruBk)
            ->get(route('guru.hasil-alokasi.index'));

        $response->assertStatus(200);
        $response->assertViewIs('guru.hasil-alokasi.index');
    }

    /**
     * Test: Admin dapat mengakses menu Waiting List
     */
    public function test_admin_can_access_waitinglist()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('guru.waitinglist.index'));

        $response->assertStatus(200);
        $response->assertViewIs('guru.waitinglist.index');
    }

    /**
     * Test: Guru BK dapat mengakses menu Waiting List
     */
    public function test_guru_bk_can_access_waitinglist()
    {
        $response = $this->actingAs($this->guruBk)
            ->get(route('guru.waitinglist.index'));

        $response->assertStatus(200);
        $response->assertViewIs('guru.waitinglist.index');
    }

    /**
     * Test: Admin dapat mengakses menu Kriteria Bobot
     */
    public function test_admin_can_access_kriteria_bobot()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('guru.kriteria-bobot.index'));

        $response->assertStatus(200);
        $response->assertViewIs('guru.kriteria-bobot.index');
    }

    /**
     * Test: Guru BK dapat mengakses menu Kriteria Bobot
     */
    public function test_guru_bk_can_access_kriteria_bobot()
    {
        $response = $this->actingAs($this->guruBk)
            ->get(route('guru.kriteria-bobot.index'));

        $response->assertStatus(200);
        $response->assertViewIs('guru.kriteria-bobot.index');
    }

    /**
     * Test: Admin dapat mengakses export Hasil Alokasi
     */
    public function test_admin_can_export_hasil_alokasi()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('guru.hasil-alokasi.export'));

        $response->assertStatus(200);
    }

    /**
     * Test: Guru BK dapat mengakses export Hasil Alokasi
     */
    public function test_guru_bk_can_export_hasil_alokasi()
    {
        $response = $this->actingAs($this->guruBk)
            ->get(route('guru.hasil-alokasi.export'));

        $response->assertStatus(200);
    }

    /**
     * Test: Admin dapat mengakses export Waiting List
     */
    public function test_admin_can_export_waitinglist()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('guru.waitinglist.export'));

        $response->assertStatus(200);
    }

    /**
     * Test: Guru BK dapat mengakses export Waiting List
     */
    public function test_guru_bk_can_export_waitinglist()
    {
        $response = $this->actingAs($this->guruBk)
            ->get(route('guru.waitinglist.export'));

        $response->assertStatus(200);
    }

    /**
     * Test: Siswa tidak dapat mengakses menu Jalankan SAW
     */
    public function test_siswa_cannot_access_jalankan_saw()
    {
        $siswaUser = User::create([
            'name' => 'Siswa Test',
            'email' => 'siswa@test.com',
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);

        $response = $this->actingAs($siswaUser)
            ->get(route('guru.jalankan-saw.index'));

        $response->assertStatus(403);
    }

    /**
     * Test: Guest tidak dapat mengakses menu Jalankan SAW
     */
    public function test_guest_cannot_access_jalankan_saw()
    {
        $response = $this->get(route('guru.jalankan-saw.index'));

        $response->assertRedirect('/login');
    }
}
