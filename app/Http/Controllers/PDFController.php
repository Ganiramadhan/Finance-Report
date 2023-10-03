<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generatePDF()
    {
        // Ambil data yang akan Anda tampilkan di PDF
        $data = [
            'title' => 'Contoh PDF dengan DomPDF',
            'content' => 'Ini adalah isi dari PDF.'
        ];

        // Buat instance objek PDF
        $pdf = PDF::loadView('admin.product.pdf', $data);

        // Simpan PDF ke file atau tampilkan dalam browser
        return $pdf->download('contoh.pdf');
        // Untuk menampilkan PDF di browser, gunakan $pdf->stream() alih-alih $pdf->download()
    }
}
