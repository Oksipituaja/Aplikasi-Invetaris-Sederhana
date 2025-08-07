<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        // Simpan ke log atau database (optional)//
        Log::info('Pesan kontak masuk', $request->only('name', 'email', 'message'));

        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}