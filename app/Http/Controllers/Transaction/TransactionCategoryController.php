<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Traits\ApiResponser;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionCategoryController extends ApiController
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {
        //
        $categories = $transaction->product->categories;
        return $this->showAll($categories);
    }

    public function ShowSeller(Transaction $transaction)
    {
        $seller = $transaction->product->seller;

        return $this->showOne($seller);


    }


}
