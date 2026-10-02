<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Habit;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $namaBulan = Carbon::now()->translatedFormat('F Y');
        $jumlahHari = Carbon::now()->daysInMonth;
        
        $todosHarian = Todo::where('tipe', 'harian')->latest()->get();
        $habits = Habit::latest()->get();

        return view('dashboard', compact('namaBulan', 'jumlahHari', 'todosHarian', 'habits'));
    }

    // --- API TO-DO HARIAN ---
    public function storeTodo(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255'
        ]);

        $todo = Todo::create([
            'judul' => $request->judul,
            'tipe' => 'harian',
            'is_selesai' => false
        ]);

        return response()->json(['status' => 'success', 'data' => $todo]);
    }

    public function updateTodo(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);

        if ($request->has('judul')) {
            $todo->judul = $request->judul;
        }

        if ($request->has('is_selesai')) {
            $todo->is_selesai = $request->is_selesai;
        }

        $todo->save();

        return response()->json(['status' => 'success', 'data' => $todo]);
    }

    public function destroyTodo($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return response()->json(['status' => 'success']);
    }

    // --- API HABIT ---
    public function storeHabit(Request $request)
    {
        $request->validate([
            'nama_kebiasaan' => 'required|string|max:255'
        ]);

        $habit = Habit::create([
            'nama_kebiasaan' => $request->nama_kebiasaan
        ]);

        return response()->json(['status' => 'success', 'data' => $habit]);
    }
}