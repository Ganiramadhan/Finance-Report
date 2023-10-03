<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\PDF;







class ProductController extends Controller
{


    public function index()
    {



        $products = Product::paginate(10);
        return view('admin.product.index', compact('products'));
    }
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            $products = Product::orderBy('id', 'ASC');

            if (!empty($query)) {
                $products->where('nama', 'like', '%' . $query . '%');
            }

            $products = $products->paginate(10);

            if ($products->isEmpty()) {
                $output .= '<tr>';
                $output .= '<td class="text-center" colspan="6">Produk tidak ditemukan.</td>';
                $output .= '</tr>';
            } else {
                foreach ($products as $product) {
                    $output .= '<tr>';
                    $output .= '<td class="align-middle">' . $product->id . '</td>';
                    $output .= '<td class="align-middle">' . $product->nama . '</td>';
                    $output .= '<td class="align-middle">' . 'Rp ' . number_format($product->hrg_beli, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">' . $product->qty . '</td>';
                    $output .= '<td class="align-middle">' . 'Rp ' . number_format($product->total, 0, ',', '.') . '</td>';

                    $output .= '<td class="align-middle">' . 'Rp ' . number_format($product->hrg_jual, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">' . $product->satuan . '</td>';

                    $output .= '<td class="align-middle">';
                    $output .= '<div class="btn-group" role="group" aria-label="Basic example">';
                    $output .= '<a href="' . route('product.show', $product->id) . '" type="button" class="btn btn-secondary">';
                    $output .= '<i class="fas fa-info-circle"></i>';
                    $output .= '</a>';
                    $output .= '<a href="' . route('product.edit', $product->id) . '" type="button" class="btn btn-success">';
                    $output .= '<i class="fas fa-edit"></i>';
                    $output .= '</a>';
                    $output .= '<form action="' . route('product.destroy', $product->id) . '" method="POST" class="btn btn-danger p-0" onsubmit="return confirm(\'Anda yakin ingin menghapus data ini ?\')">';
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

            return response()->json(['data' => $output, 'pagination' => $products->links()->toHtml()]);
        }
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_satuan = Satuan::all();

        return view('/admin/product.create', compact('data_satuan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'nama' => [
                'required',
                'max:255', // Sesuaikan dengan panjang maksimum nama produk di database
                Rule::unique('products')
            ],
            // ... tambahkan aturan validasi lainnya sesuai kebutuhan Anda
        ], [
            'nama.unique' => 'Nama produk sudah tersedia.',
        ]);
        Product::create($request->all());

        return redirect()->route('product.index')->with('success', 'Data Product Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data_satuan = Satuan::all();
        $product = Product::findOrFail($id);
        return view('admin/product.show', compact('product', 'data_satuan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $data_satuan = Satuan::all();
        $product = Product::findOrFail($id);



        return view('admin/product.edit', compact('product', 'data_satuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'nama' => [
                'required',
                'max:255',
                Rule::unique('products')->ignore($id), // $id is the ID of the current product being edited
            ],
            // Add other validation rules as needed
        ], [
            'nama.unique' => 'Nama produk sudah tersedia.',
        ]);




        $product = Product::findOrFail($id);
        $product->update($request->all());


        return redirect()->route('product.index')->with('success', "Data Berhasil diupdate");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Data Product Berhasil dihapus');
    }
}
