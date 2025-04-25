@extends('layouts.app')
@section('CssSection')
    <link rel="stylesheet" type="text/css" href="{{asset('css/InvoiceForm.css')}}">
    @endsection
@section('body')
    <div class="contain">
        @if (session('status'))
            <div class="alert alert-success">{{session('status')}}</div>
        @endif
        @if(isset($invoice))
                <form method="post" action="{{route('invoice.update', $invoice->id)}}">
                    @csrf
                    @method('PUT')
                    <div id="invoice">
                        <form id="AddForm" name="addForm" method="post">
                            @csrf
                            <div id="item-container">
                                @foreach ($arr as $k=>$v)
                                    @foreach ($v as $key=>$value)
                                        <div>
                                        <input type="text" id="iName" class="iName" name="iName[]" onkeyup="abcd(Increment)"  placeholder="Item Name" value="{{$value['name']}}">
                                        <input type="number" id="cost" class="cost" name="cost[]" placeholder="Unit cost" value="{{$value['cost']}}">
                                        <input type="number" id="quantity" name="qty[]" onkeyup="itemValue(Increment)" placeholder="Quantity" value="{{$value['quantity']}}">
                                        <button type="button" id="bt" onclick="return this.parentNode.remove();">Delete</button><br>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                            <ul id="myUL"></ul>
                            <a id="add-new-item">Add new item</a>
                        </form><br>
                        <span id="SpanForm" class="error">@error('addForm'){{$message}}@enderror</span> <br>
                        <div id="items"></div>
                        <label for="cost">Cost without discount</label><br>

                        <input type="text" id="cost_wod" name="cost_wod" class="cost_wod" value="{{$invoice->total_cost}}" autocomplete="off"><br>
                        <span id="SpanCost" class="error">@error('cost_wod'){{$message}}@enderror</span> <br>

                        <label for="discount">Discount in %</label><br>
                        <input type="text" id="discount" name="discount" class="discountcost" size="50" value=10 ><br>
                        <span id="SpanDiscount" class="error">@error('discount'){{$message}}@enderror</span> <br>

                        <label for="tax">Tax %</label><br>
                        <input type="text" id="tax" name="tax" class="tax" size="50" value=5><br>
                        <span id="SpanTax" class="error">@error('tax'){{$message}}@enderror</span> <br>

                        <label for="dcost">Cost with discount and tax</label><br>
                        <input type="text" id="dcost" name="dcost" class="dcost" value="{{$invoice->final_cost}}" autocomplete="off"><br>
                        <span id="SpanDcost" class="error">@error('dcost'){{$message}}@enderror</span> <br>

                        <label for="advance">Advance payment</label><br>
                        <input type="text" id="advance" name="advance" class="advance" onkeypress="AdvanceValue()"
                               onkeyup="AdvanceValue()" value="{{$invoice->advance}}" autocomplete="off"><br>
                        <span id="SpanAdvance" class="error">@error('advance'){{$message}}@enderror</span> <br>

                        <label for="due">Due amount</label><br>
                        <input type="text" id="due" name="due" class="due" value="{{$invoice->due}}" autocomplete="off"><br>
                        <span id="SpanDue" class="error">@error('due'){{$message}}@enderror</span> <br>


                        <button type="submit" id="submit">Update</button>
                    </div>
                </form>
    </div>
    @else
        <form method="post" action="{{route('invoice.store')}}">
            @csrf
        <div id="invoice">
            <form id="AddForm" name="addForm" method="post">
                @csrf
                <div id="item-container">
                </div>
                <ul id="myUL"></ul>
                <a id="add-new-item">Add new item</a>
            </form><br>
            <span id="SpanForm" class="error">@error('addForm'){{$message}}@enderror</span> <br>
            <div id="items"></div>
            <label for="cost">Cost without discount</label><br>
            <input type="text" id="cost_wod" name="cost_wod" class="cost_wod" value="{{@old('cost_wod')}}" readonly><br>
            <span id="SpanCost" class="error">@error('cost_wod'){{$message}}@enderror</span> <br>

            <label for="discount">Discount in %</label><br>
            <input type="number" id="discount" name="discount" class="discountcost" size="50" value=10><br>
            <span id="SpanDiscount" class="error">@error('discount'){{$message}}@enderror</span> <br>

            <label for="tax">Tax %</label><br>
            <input type="number" id="tax" name="tax" class="tax" size="50" value=5><br>
            <span id="SpanTax" class="error">@error('tax'){{$message}}@enderror</span> <br>

            <label for="dcost">Cost with discount and tax</label><br>
            <input type="text" id="dcost" name="dcost" class="dcost" readonly value="{{@old('dcost')}}"><br>
            <span id="SpanDcost" class="error">@error('dcost'){{$message}}@enderror</span> <br>

            <label for="advance">Advance payment</label><br>
            <input type="text" id="advance" name="advance" class="advance" onkeypress="AdvanceValue()"
                   onkeyup="AdvanceValue()" value="0"><br>
            <span id="SpanAdvance" class="error">@error('advance'){{$message}}@enderror</span> <br>

            <label for="due">Due amount</label><br>
            <input type="text" id="due" name="due" class="due" value="{{@old('due')}}"><br>
            <span id="SpanDue" class="error">@error('due'){{$message}}@enderror</span> <br>


            <button type="submit" id="submit">Submit</button>
        </div>
        </form>
    </div>
    @endif
@section('JsSection')
    <script src="{{ asset('js/InvoiceForm.js') }}"></script>

@endsection
    @endsection

