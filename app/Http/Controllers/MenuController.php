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
     * BUG: Data tidak pernah tersimpan ke database!
     * Raka lupa memanggil $menu->save() setelah mengisi atribut.
     * Response tetap mengembalikan "sukses", sehingga Bu Sari mengira
     * data sudah masuk, padahal belum tersimpan sama sekali.
     */
    public function store(Request $request)
    {
        $menu = new Menu();
        $menu->nama = $request->nama;
        $menu->harga = $request->harga;

        // Raka lupa memanggil $menu->save() di sini!

        return response()->json([
            'message' => 'Menu berhasil ditambahkan!',
            'data' => $menu
        ], 201);
    }

    /**
     * Menghapus menu
     * 
     * BUG: Tidak ada penanganan error jika menu tidak ditemukan!
     * Raka menggunakan findOrFail() tanpa try-catch, sehingga ketika
     * Bu Sari mencoba menghapus menu yang sudah tidak ada (misal 'Es Teh'),
     * aplikasi menampilkan error 500 dengan stack trace panjang berwarna merah.
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return response()->json([
            'message' => 'Menu berhasil dihapus!'
        ]);
    }
}
