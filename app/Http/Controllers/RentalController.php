<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function rentCar(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Cek ketersediaan mobil
        $car = Car::findOrFail($validatedData['car_id']);

        if ($car->isRented($validatedData['start_date'], $validatedData['end_date'])) {
            return response()->json(['message' => 'Mobil tidak tersedia pada tanggal yang diminta']);
        }

        // Buat data peminjaman
        $rental = Rental::create([
            'car_id' => $validatedData['car_id'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
        ]);

        // Berikan respon atau lakukan tindakan lain sesuai kebutuhan
        return response()->json(['message' => 'Mobil berhasil disewa', 'rental' => $rental]);
    }

    public function returnCar(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'return_date' => 'required|date',
        ]);

        // Cek data peminjaman
        $rental = Rental::where('car_id', $validatedData['car_id'])
            ->whereNull('return_date')
            ->firstOrFail();

        // Update data pengembalian
        $rental->return_date = $validatedData['return_date'];
        $rental->save();

        // Hitung biaya sewa
        $rental->calculateRentalFee();

        // Berikan respon atau lakukan tindakan lain sesuai kebutuhan
        return response()->json(['message' => 'Mobil berhasil dikembalikan', 'rental' => $rental]);
    }
}
