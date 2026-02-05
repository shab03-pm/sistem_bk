Route::get('/test-waitlist', function () {
// Test 1: Total waitlist
$totalWaitlist = \App\Models\Alokasi::where('status', 'waitlist')->count();
echo "Total Waitlist: " . $totalWaitlist . "<br>";

// Test 2: Query sama dengan controller
$query = \App\Models\Siswa::leftJoin('alokasis', 'siswas.id', '=', 'alokasis.siswa_id')
->leftJoin('peminatans', 'alokasis.peminatan_id', '=', 'peminatans.id')
->select('siswas.*', 'alokasis.id as alokasi_id', 'alokasis.skor_saw', 'alokasis.status', 'peminatans.nama as
peminatan_nama');

// Filter status waitlist (whereNull)
$query->whereNull('alokasis.id');

$result = $query->orderBy('siswas.nis')->limit(10)->get();
echo "Query whereNull result count: " . $result->count() . "<br>";
foreach ($result as $r) {
echo "- NIS: {$r->nis}, Nama: {$r->nama}, Alokasi ID: {$r->alokasi_id}<br>";
}

// Test 3: Query dengan status = waitlist (untuk siswa yang punya alokasi)
$query2 = \App\Models\Siswa::leftJoin('alokasis', 'siswas.id', '=', 'alokasis.siswa_id')
->leftJoin('peminatans', 'alokasis.peminatan_id', '=', 'peminatans.id')
->select('siswas.*', 'alokasis.id as alokasi_id', 'alokasis.skor_saw', 'alokasis.status', 'peminatans.nama as
peminatan_nama');

// Filter status dengan NOT NULL dan status = waitlist
$query2->where(function($q) {
$q->whereNotNull('alokasis.id')
->where('alokasis.status', 'waitlist');
});

$result2 = $query2->orderBy('siswas.nis')->limit(10)->get();
echo "<br>Query dengan status='waitlist' result count: " . $result2->count() . "<br>";
foreach ($result2 as $r) {
echo "- NIS: {$r->nis}, Nama: {$r->nama}, Alokasi ID: {$r->alokasi_id}, Status: {$r->status}<br>";
}

dd("Debug selesai");
});