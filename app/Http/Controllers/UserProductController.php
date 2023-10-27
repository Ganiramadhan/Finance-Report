<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class UserProductController extends Controller
{

    public function index()
    {



        $products = Product::paginate(10);
        return view('user.product.index', compact('products'));
    }
    public function search_user(Request $request)
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
                    $output .= '<td class="align-middle">' . 'Rp ' . number_format($product->harga_jual, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">' . $product->satuan . '</td>';
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
