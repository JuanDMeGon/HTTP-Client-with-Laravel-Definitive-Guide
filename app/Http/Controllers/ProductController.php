<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show the details of a product.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showProduct($title, $id)
    {
        $product = $this->marketService->getProduct($id);

        return view('products.show')
            ->with([
                'product' => $product,
            ]);
    }
}
