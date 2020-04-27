<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class BuyerTransactionController extends ApiController
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        //
        $transaction = $buyer->transactions;
        return $this->showAll($transaction);
    }

    /**
     * Show All Products of buyer
     */

    public function ShowProducts(Buyer $buyer)
    {
        //
        $products = $buyer->transactions()->with('product')
                    ->get()->pluck('product');
        return $this->showAll($products);
    }

    /**
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     * Show All Seller with Buyer
     */
    public function ShowSellers(Buyer $buyer)
    {
        //
        $sellers = $buyer->transactions()->with('product.seller')
            ->get()
            ->pluck('product.seller')
            ->unique('id')
            ->values();
        return $this->showAll($sellers);
    }

    /**
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     * Show All Category of product that purchase Buyer
     */
    public function ShowCategories(Buyer $buyer)
    {
        //
//        $categories = $buyer->transactions()->with('product')->get();
        $categories = $buyer->transactions()->with('product.categories')
            ->get()
            ->pluck('product.categories')
            ->collapse()
            ->unique('id')
            ->values();

        return $this->showAll($categories);
    }



}
