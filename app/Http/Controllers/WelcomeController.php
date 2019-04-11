<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showWelcomePage()
    {
        $products = $this->marketService->getProducts();

        return view('welcome')
            ->with([
                'products' => $products,
            ]);
    }
}
