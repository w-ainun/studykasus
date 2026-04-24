<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Menampilkan semua menu
     */
    public function index()
    {
        $menus = Menu::all();

        return response()->json([
            'message' => 'Daftar menu',
            'data' => $menus
        ]);
    }

    /**
     * Menambahkan menu baru
     * 
     * PERBAIKAN:
     * 1. Menambahkan validasi input agar data yang masuk terjamin benar
     * 2. Memanggil $menu->save() agar data benar-benar tersimpan ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $menu = new Menu();
        $menu->nama = $request->nama;
        $menu->harga = $request->harga;
        $menu->save();

        return response()->json([
            'message' => 'Menu berhasil ditambahkan!',
            'data' => $menu
        ], 201);
    }

    /**
     * Menghapus menu
     * 
     * PERBAIKAN:
     * 1. Menggunakan find() (bukan findOrFail()) untuk menghindari exception otomatis
     * 2. Menambahkan pengecekan manual jika menu tidak ditemukan
     * 3. Mengembalikan response JSON 404 yang user-friendly, bukan error 500 dengan stack trace
     */
    public function destroy($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'message' => 'Menu tidak ditemukan!'
            ], 404);
        }

        $menu->delete();

        return response()->json([
            'message' => 'Menu berhasil dihapus!'
        ]);
    }
}
