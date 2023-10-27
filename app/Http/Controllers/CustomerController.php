<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{

    public function cetak_pdf()
    {
        $data_customer = Customer::all();
        $pdf = PDF::loadView('admin.customer.cetak_pdf', ['data_customer' => $data_customer]); // Menggunakan compact() untuk mengirim data ke view
        return $pdf->download('customer_pdf.pdf'); // Mengubah nama file PDF yang akan diunduh
    }

    public function index()
    {
        $customers = Customer::paginate(10);
        return view('admin.customer.index', compact('customers'));
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            $customers = Customer::orderBy('id', 'ASC');

            if (!empty($query)) {
                $customers->where('nama', 'like', '%' . $query . '%');
            }

            $customers = $customers->paginate(10); // Ubah jumlah item per halaman sesuai kebutuhan Anda

            if ($customers->isEmpty()) {
                $output .= '<tr>';
                $output .= '<td class="text-center" colspan="9">Customer tidak ditemukan.</td>';
                $output .= '</tr>';
            } else {
                foreach ($customers as $customer) {
                    $output .= '<tr>';
                    $output .= '<td class="align-middle">' . $customer->id . '</td>';
                    $output .= '<td class="align-middle">' . $customer->nama . '</td>';
                    $output .= '<td class="align-middle">' . 'Rp ' . number_format($customer->saldo_awal_piutang, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">' . $customer->no_telepon . '</td>';
                    $output .= '<td class="align-middle">' . $customer->alamat . '</td>';
                    $output .= '<td class="align-middle">';
                    $output .= '<div class="btn-group" role="group">';
                    $output .= '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    $output .= '<i class="fas fa-cog"></i>';
                    $output .= '</button>';
                    $output .= '<div class="dropdown-menu">';
                    $output .= '<a class="dropdown-item" href="' . route('customer.show', $customer->id) . '">';
                    $output .= '<i class="fas fa-info-circle"></i> Detail';
                    $output .= '</a>';
                    $output .= '<a class="dropdown-item" href="' . route('customer.edit', $customer->id) . '">';
                    $output .= '<i class="fas fa-edit"></i> Edit';
                    $output .= '</a>';
                    $output .= '<form action="' . route('customer.destroy', $customer->id) . '" method="POST">';
                    $output .= csrf_field();
                    $output .= method_field('DELETE');
                    $output .= '<button type="submit" class="dropdown-item" onclick="return confirm(\'Anda yakin ingin menghapus data ini ?\')">';
                    $output .= '<i class="fas fa-trash"></i> Hapus';
                    $output .= '</button>';
                    $output .= '</form>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</td>';

                    $output .= '</tr>';
                }
            }


            return response()->json(['data' => $output, 'pagination' => $customers->links()->toHtml()]);
        }
    }

    public function create()
    {
        return view('/admin.customer.create');
    }


    public function store(Request $request)
    {
        Customer::create($request->all());
        return redirect()->route('customer.index')->with('success', 'Data Berhasil ditambahkan.');
    }


    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('/admin/customer.show', compact('customer'));
    }


    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('/admin/customer.edit', compact('customer'));
    }


    public function update(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('customer.index')->with('success', 'Data Berhasil diupdate');
    }


    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Data Customer Berhasil dihapus');
    }
}
