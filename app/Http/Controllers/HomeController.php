<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MarketService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MarketService $marketService)
    {
        $this->middleware('auth');

        parent::__construct($marketService);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Obtain and show the list of purchases
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showPurchases()
    {

    }

    /**
     * Obtain and show the list of published products
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showProducts()
    {

    }
}
