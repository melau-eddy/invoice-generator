<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Mail\TestMail;
use App\Service\InvoiceService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Class Invoice Controller
 */
class InvoiceController extends Controller
{


    /**
     * @param InvoiceService $invoiceService
     */
    public function __construct(protected InvoiceService $invoiceService)
    {
    }


    /**
     * Display a listing of the invoices.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            $invoice = $this->invoiceService->index();
            return view('InvoiceItem.InvoiceItemView', compact('invoice'));
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }


    /**
     * Show the form for creating a new invoice.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        try {
            return view('InvoiceItem.InvoiceItemForm');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param InvoiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(InvoiceRequest $request)
    {
        try {
            $this->invoiceService->store($request);
            $details=[
                'title'=>'title',
                'body'=>'body'
            ];
            Mail::to("sushmipalikhe97@gmail.com")->send(new TestMail($details));
            return redirect()->route('invoice.index')->with('status', 'Invoice Created Successfully');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }


    /**
     * Display the specified invoice.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        try {
            $result = $this->invoiceService->show($id);
            $invoice = $result[0];
            $arr = $result[1];
            $discounted_cost = $result[2];
            return view('InvoiceItem.Preview', compact('invoice', 'arr', 'discounted_cost'));
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }


    /**
     * Show the form for editing the specified invoice.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        try {
            if (auth()->user()->hasPermissionTo('update_invoice')) {
                $result = $this->invoiceService->edit($id);
                $arr = $result[0];
                $invoice = $result[1];
                return view('InvoiceItem.InvoiceItemForm', compact('invoice', 'arr'));
            }
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }


    /**
     * Update the specified invoice in storage.
     *
     * @param InvoiceRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(InvoiceRequest $request, $id)
    {
        try {
            $this->invoiceService->update($request, $id);
            return redirect()->route('invoice.index')->with('status', 'Invoice Updated Successfully');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }


    /**
     * Remove the specified invoice from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            if (auth()->user()->hasPermissionTo('delete_invoice')) {
                $this->invoiceService->delete($id);
                return redirect()->route('invoice.index')->with('status', 'Invoice Deleted Successfully');
            }
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }
}
