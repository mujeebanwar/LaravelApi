<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class CategoryProductsController extends ApiController
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        //
        $products = $category->products;
        return $this->showAll($products);
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     * Show all Seller against Category
     */

    public function showCategories(Category $category)
    {
        //
        $sellers = $category->products()
            ->with('seller')
            ->get()
            ->pluck('seller')
            ->unique()
            ->values();

        return $this->showAll($sellers);
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     * Return All Transactions of categories
     *
     */
    /*
     * WhereHas Confirm that product have at least one transaction
     */
    public function showTransactions(Category $category)
    {
        //
        $transactions = $category->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse();

        return $this->showAll($transactions);
    }

    public function showBuyers(Category $category)
    {
        //
        $buyers = $category->products()
            ->whereHas('transactions')
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyer')
            ->unique('id')
            ->values();


        return $this->showAll($buyers);
    }


}
