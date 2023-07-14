<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'sim_number' => 'required|string',
        ]);

        // Buat pengguna baru
        $user = User::create($validatedData);

        // Berikan respon atau lakukan tindakan lain sesuai kebutuhan
        return response()->json(['message' => 'Registrasi berhasil', 'user' => $user]);
    }
}
