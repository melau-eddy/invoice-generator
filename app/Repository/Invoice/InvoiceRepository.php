<?php

namespace App\Repository\Invoice;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Items;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;

/**
 * Class User Repository
 */
class InvoiceRepository extends Repository
{

    /**
     * Retrieves the model name
     *
     * abstract method
     *
     * @return string
     */
    public function getModel(): string
    {
        return Invoice::class;
    }

    /**
     * Retrieves all the details from invoice model
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Invoice::with('invoice_items', 'company')->where('company_id', Auth::user()->company_id)->get();
    }

    /**
     * Stores the data in items table
     *
     * @param $data
     * @param $x
     */
    public function store_items($data, $x)
    {
        Items::create([
            "name" => $data->iName[$x],
            "cost" => $data->cost[$x]
        ]);
    }

    /**
     * Stores the data in invoice_items table
     *
     * @param $invoice_id
     * @param $request
     * @param $x
     */
    public function store_invoice_item($invoice_id, $request, $x)
    {
        InvoiceItem::create([
            "item_id" => Items::select('id')->where('name', $request->iName[$x])->first()->id,
            "invoice_id" => $invoice_id,
            "quantity" => $request->qty[$x],
        ]);
    }

    public function getFirstItem($id)
    {
        return Items::where('id', $id)->first();
    }
}
