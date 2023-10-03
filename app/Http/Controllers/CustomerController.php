<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

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
                $output .= '<td class="text-center" colspan="6">Customer tidak ditemukan.</td>';
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
                    $output .= '<div class="btn-group" role="group" aria-label="Basic example">';
                    $output .= '<a href="' . route('customer.show', $customer->id) . '" type="button" class="btn btn-secondary">';
                    $output .= '<i class="fas fa-info-circle"></i>';
                    $output .= '</a>';
                    $output .= '<a href="' . route('customer.edit', $customer->id) . '" type="button" class="btn btn-success">';
                    $output .= '<i class="fas fa-edit"></i>';
                    $output .= '</a>';
                    $output .= '<form action="' . route('customer.destroy', $customer->id) . '" method="POST" class="btn btn-danger p-0" onsubmit="return confirm(\'Anda yakin ingin menghapus data ini ?\')">';
                    $output .= csrf_field();
                    $output .= method_field('DELETE');
                    $output .= '<button type="submit" class="btn btn-danger m-0">';
                    $output .= '<i class="fas fa-trash"></i>';
                    $output .= '</button>';
                    $output .= '</form>';
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
