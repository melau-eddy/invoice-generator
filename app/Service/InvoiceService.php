<?php

namespace App\Service;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Items;
use App\Repository\Invoice\InvoiceRepository;
use Illuminate\Support\Facades\Auth;

/**
 * class Invoice Service
 */
class InvoiceService
{

    /**
     * @var $userRepository
     */
    protected $invoiceRepository;

    /**
     * InvoiceService constructor.
     *
     * @param InvoiceRepository $invoiceRepository
     */
    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     *  Displays the list of invoices
     *
     * @return array
     */

    public function index()
    {
        if (Auth::user()->name === "admin") {
            return Invoice::with('invoice_items', 'company')->get();
        } else {
            return $this->invoiceRepository->index();
        }
    }


    /**
     * Stores the invoice details
     *
     * @param $request
     */
    public function store($request)
    {
        $company_id = Auth::user()->company_id;
        $items = Items::all();
        $total_item = count($request->iName);
        $arr = [];
        foreach ($items as $k => $v) {
            array_push($arr, $v->name);
        }
        for ($x = 0; $x < $total_item; $x++) {
            $abc = $request->iName[$x];
            if (!in_array($abc, $arr)) {
                Items::create([
                    "name" => $request->iName[$x],
                    "cost" => $request->cost[$x]
                ]);
            }
        }
        $invoice = $this->invoiceRepository->store([
            "discount" => $request->discount,
            "tax" => $request->tax,
            "company_id" => $company_id,
            "total_cost" => $request->cost_wod,
            "advance" => $request->advance,
            "final_cost" => $request->dcost,
            "due" => $request->due
        ]);
        $invoice_id = $invoice->id;
        for ($x = 0; $x < $total_item; $x++) {
            $this->invoiceRepository->store_invoice_item($invoice_id, $request, $x);
        }
    }

    /**
     * Show the invoice details of specific id
     *
     * @param $id
     * @return array
     */
    public function show($id)
    {
        $invoice = Invoice::with('invoice_items', 'company')->where('id', $id)->first();
        $invoice_items = $invoice->invoice_items;
        $arr = [];
        foreach ($invoice_items as $invoice_item) {
            $item_list = [];
            $item = $this->invoiceRepository->getFirstItem($invoice_item->item_id);
            array_push($item_list, [
                "name" => $item->name,
                "cost" => $item->cost,
                "quantity" => $invoice_item->quantity,
                "total" => $item->cost * $invoice_item->quantity]);
            array_push($arr, $item_list);
        }
        $discounted_cost = (1 - ($invoice->discount) / 100) * $invoice->total_cost;
        return [$invoice, $arr, $discounted_cost];
    }

    /**
     * Edit the invoice detail of specific id
     *
     * @param $id
     * @return array
     */
    public function edit($id)
    {
        $invoice = Invoice::with('invoice_items', 'company')->where('id', $id)->first();
        $invoice_items = $invoice->invoice_items;
        $arr = [];
        foreach ($invoice_items as $invoice_item) {
            $item_list = [];
            $item = $this->invoiceRepository->getFirstItem($invoice_item->item_id);
            array_push($item_list, [
                "name" => $item->name,
                "cost" => $item->cost,
                "quantity" => $invoice_item->quantity,
                "total" => $item->cost * $invoice_item->quantity]);
            array_push($arr, $item_list);
        }
        return [$arr, $invoice];
    }

    /**
     * Updates the invoice details of specific id
     *
     * @param $request
     * @param $id
     */
    public function update($request, $id)
    {
        $items = Items::all();
        $total_item = count($request->iName);
        $arr = [];
        foreach ($items as $k => $v) {
            array_push($arr, $v->name);
        }
        for ($x = 0; $x < $total_item; $x++) {
            $abc = $request->iName[$x];
            if (!in_array($abc, $arr)) {
                Items::create([
                    "name" => $request->iName[$x],
                    "cost" => $request->cost[$x]
                ]);
            }
        }
        Invoice::where('id', $id)->update([
            "discount" => $request->discount,
            "tax" => $request->tax,
            "total_cost" => $request->cost_wod,
            "advance" => $request->advance,
            "final_cost" => $request->dcost,
            "due" => $request->due
        ]);
        InvoiceItem::where('invoice_id', $id)->delete();
        for ($x = 0; $x < $total_item; $x++) {
            InvoiceItem::create([
                "item_id" => Items::select('id')->where('name', $request->iName[$x])->first()->id,
                "invoice_id" => $id,
                "quantity" => $request->qty[$x],
            ]);
        }
    }

    /**
     * Deletes the invoice details of specific id
     *
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->invoiceRepository->delete($id);
    }
}
