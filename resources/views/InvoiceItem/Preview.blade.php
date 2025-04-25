@extends('layouts.app')
@section('CssSection')
    <link href="{{ asset('css/preview.css') }}" rel="stylesheet">
    <style>

    </style>

@endsection
@section('body')
    <div id="invoice">
        <div class="invoice overflow-auto">
            <div id="preview_table">
                <header>
                    <div class="row">
                        <div class="col" id="company_logo">
                            <img id="image_id" src="{{Storage::disk('uploads')->url($invoice->company->company_image)}}" style="width: 40px; height: 40px;">
                        </div>
                        <div class="col company-details">
                            <h2 id="name">{{$invoice->company->name}}</h2>
                            <div id="address">{{$invoice->company->location}}</div>
                            <div id="contact">{{$invoice->company->number}}</div>
                            <div id="email">{{$invoice->company->email}}</div>
                        </div>
                    </div>
                </header>
                <main>
                    <div class="row contacts">
                        <div class="col invoice-details">
                            <h1 id="invoice-id"></h1>
                            <div id="date">Date of Invoice:{{$invoice->updated_at}}</div>
                            <div id="duedate">Due Date:</div>
                        </div>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                        <tr>
                            <th class="text-left">SN</th>
                            <th class="text-left">Items</th>
                            <th class="text-right">Unit cost</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                        </thead>
                        <tbody id="preview">

                            <?php $index=1;?>
                            @foreach ($arr as $k=>$v)
                                @foreach ($v as $key=>$value)
                                    <tr>
                                        <td>{{$index}}</td>
                                        <td>{{$value['name']}}</td>

                                    <td>{{$value['cost']}}</td>
                                    <td>{{$value['quantity']}}</td>
                                    <td>{{$value['total']}}</td>
                        </tr>
                                @endforeach
                                <?php $index++;?>
                            @endforeach
                        </tbody>


                        <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">SUBTOTAL</td>
                            <td id="total">{{$invoice->total_cost}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">DISCOUNT</td>
                            <td colspan="2" id="discount">{{$invoice->discount}}%</td>
                            <td id="discounted_price">{{$discounted_cost}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">TAX</td>
                            <td colspan="2" id="tax">{{$invoice->tax}}</td>
                            <td id="tax_price">{{$invoice->final_cost}}</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">GRAND TOTAL</td>
                            <td id="grand_total"></td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="thanks">Thank you!</div>
                    <div class="notices">
                        <div>NOTICE:</div>
                        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                    </div>
                </main>
                <footer>
                    Invoice was created on a computer and is valid without the signature and seal.
                </footer>
            </div>
            <div></div>
        </div>
    </div>
@endsection
