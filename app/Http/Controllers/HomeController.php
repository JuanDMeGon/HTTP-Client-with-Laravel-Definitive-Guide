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
    public function showPurchases(Request $request)
    {
        $purchases = $this->marketService->getPurchases($request->user()->service_id);

        return view('purchases')
            ->with([
                'purchases' => $purchases,
            ]);
    }

    /**
     * Obtain and show the list of published products
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showProducts(Request $request)
    {
        $publications = $this->marketService->getPublications($request->user()->service_id);

        return view('publications')
            ->with([
                'publications' => $publications,
            ]);
    }
}
