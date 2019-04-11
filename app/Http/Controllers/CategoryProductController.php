<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    /**
     * Show the details of a product.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showProducts($title, $id)
    {
        $products = $this->marketService->getCategoryProduct($id);

        return view('categories.products.show')
            ->with([
                'products' => $products,
            ]);
    }
}
