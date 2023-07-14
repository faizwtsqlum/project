<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function addCar(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'license_plate' => 'required|string',
            'rental_rate' => 'required|numeric',
        ]);

        // Tambahkan mobil baru
        $car = Car::create($validatedData);

        // Berikan respon atau lakukan tindakan lain sesuai kebutuhan
        return response()->json(['message' => 'Mobil berhasil ditambahkan', 'car' => $car]);
    }

    public function searchCars(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'availability' => 'nullable|boolean',
        ]);

        // Query mobil berdasarkan kriteria pencarian
        $cars = Car::query();

        if ($validatedData['brand']) {
            $cars->where('brand', $validatedData['brand']);
        }

        if ($validatedData['model']) {
            $cars->where('model', $validatedData['model']);
        }

        if ($validatedData['availability']) {
            $cars->whereDoesntHave('rentals', function ($query) {
                $query->whereDate('end_date', '>=', now());
            });
        }

        $result = $cars->get();

        // Berikan respon atau lakukan tindakan lain sesuai kebutuhan
        return response()->json(['message' => 'Mobil berhasil ditemukan', 'cars' => $result]);
    }

    public function getAllCars()
    {
        // Ambil semua mobil yang tersedia untuk disewa
        $cars = Car::all();

        // Berikan respon atau lakukan tindakan lain sesuai kebutuhan
        return response()->json(['message' => 'Daftar semua mobil yang tersedia untuk disewa', 'cars' => $cars]);
    }
}

