<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use Hamcrest\Core\AllOf;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:255'],
            'kelas_asal' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Validasi File Raport - simplified
            'file_raport' => ['required', 'file', 'max:5120'],
            // Validasi Nilai (0-100)
            'nilai_matematika' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_fisika' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_kimia' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_biologi' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_tik' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_binggris' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_sosiologi' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_ekonomi' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_geografi' => ['required', 'numeric', 'min:0', 'max:100'],
        ], [
            'file_raport.required' => 'File raport harus diunggah',
            'file_raport.file' => 'File raport harus berupa file yang valid',
            'file_raport.mimes' => 'File raport harus berformat PDF, JPG, atau PNG',
            'file_raport.max' => 'Ukuran file raport tidak boleh lebih dari 5MB',
            'nilai_matematika.required' => 'Nilai Matematika harus diisi',
            'nilai_matematika.numeric' => 'Nilai Matematika harus berupa angka',
            'nilai_matematika.min' => 'Nilai Matematika tidak boleh kurang dari 0',
            'nilai_matematika.max' => 'Nilai Matematika tidak boleh lebih dari 100',
            'nilai_fisika.required' => 'Nilai Fisika harus diisi',
            'nilai_fisika.numeric' => 'Nilai Fisika harus berupa angka',
            'nilai_fisika.min' => 'Nilai Fisika tidak boleh kurang dari 0',
            'nilai_fisika.max' => 'Nilai Fisika tidak boleh lebih dari 100',
            'nilai_kimia.required' => 'Nilai Kimia harus diisi',
            'nilai_kimia.numeric' => 'Nilai Kimia harus berupa angka',
            'nilai_kimia.min' => 'Nilai Kimia tidak boleh kurang dari 0',
            'nilai_kimia.max' => 'Nilai Kimia tidak boleh lebih dari 100',
            'nilai_biologi.required' => 'Nilai Biologi harus diisi',
            'nilai_biologi.numeric' => 'Nilai Biologi harus berupa angka',
            'nilai_biologi.min' => 'Nilai Biologi tidak boleh kurang dari 0',
            'nilai_biologi.max' => 'Nilai Biologi tidak boleh lebih dari 100',
            'nilai_tik.required' => 'Nilai TIK harus diisi',
            'nilai_tik.numeric' => 'Nilai TIK harus berupa angka',
            'nilai_tik.min' => 'Nilai TIK tidak boleh kurang dari 0',
            'nilai_tik.max' => 'Nilai TIK tidak boleh lebih dari 100',
            'nilai_binggris.required' => 'Nilai Bahasa Inggris harus diisi',
            'nilai_binggris.numeric' => 'Nilai Bahasa Inggris harus berupa angka',
            'nilai_binggris.min' => 'Nilai Bahasa Inggris tidak boleh kurang dari 0',
            'nilai_binggris.max' => 'Nilai Bahasa Inggris tidak boleh lebih dari 100',
            'nilai_sosiologi.required' => 'Nilai Sosiologi harus diisi',
            'nilai_sosiologi.numeric' => 'Nilai Sosiologi harus berupa angka',
            'nilai_sosiologi.min' => 'Nilai Sosiologi tidak boleh kurang dari 0',
            'nilai_sosiologi.max' => 'Nilai Sosiologi tidak boleh lebih dari 100',
            'nilai_ekonomi.required' => 'Nilai Ekonomi harus diisi',
            'nilai_ekonomi.numeric' => 'Nilai Ekonomi harus berupa angka',
            'nilai_ekonomi.min' => 'Nilai Ekonomi tidak boleh kurang dari 0',
            'nilai_ekonomi.max' => 'Nilai Ekonomi tidak boleh lebih dari 100',
            'nilai_geografi.required' => 'Nilai Geografi harus diisi',
            'nilai_geografi.numeric' => 'Nilai Geografi harus berupa angka',
            'nilai_geografi.min' => 'Nilai Geografi tidak boleh kurang dari 0',
            'nilai_geografi.max' => 'Nilai Geografi tidak boleh lebih dari 100',
        ]);

        // Handle file upload
        $fileName = null;
        if ($request->hasFile('file_raport')) {
            $file = $request->file('file_raport');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/raport', $fileName);
        }

        // Simpan ke tabel users
        $user = User::create([
            'nis' => $request->nis,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        // Simpan ke tabel siswas dengan nilai dan file
        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'kelas_asal' => $request->kelas_asal,
            'nilai_matematika' => $request->nilai_matematika,
            'nilai_fisika' => $request->nilai_fisika,
            'nilai_kimia' => $request->nilai_kimia,
            'nilai_biologi' => $request->nilai_biologi,
            'nilai_tik' => $request->nilai_tik,
            'nilai_binggris' => $request->nilai_binggris,
            'nilai_sosiologi' => $request->nilai_sosiologi,
            'nilai_ekonomi' => $request->nilai_ekonomi,
            'nilai_geografi' => $request->nilai_geografi,
            'file_raport' => $fileName,
        ]);

        event(new Registered($user));

        // Logout any previously authenticated user
        Auth::logout();

        // Invalidate the old session
        $request->session()->invalidate();

        // Get the siswa that was just created (matching by email)
        $siswa = Siswa::where('email', $request->email)->first();

        // Login the new siswa user (not the User model)
        Auth::login($siswa);

        // Regenerate session for security
        $request->session()->regenerate();

        // Store the model type to help with ID collision resolution
        $request->session()->put('auth_model_type', 'siswa');

        // Redirect to input nilai (siswa dashboard)
        return redirect()->route('siswa.input-nilai-raport.index');
    }
}
