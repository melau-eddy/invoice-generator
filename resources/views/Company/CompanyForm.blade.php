@extends('layouts.app')
@canany(['create_user', 'update_user'])
@section('CssSection')
    <link rel="stylesheet" type="text/css" href="{{asset('css/company.css')}}">
@endsection
@section('title') Company @endsection
@section('body')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('error_msg'))
        <div class="alert alert-success">{{session('msg')}}</div>
    @endif
    <div class="testbox">
        @if (isset($company))
            <h1>Edit Company Details</h1>
            <form action="{{route('company.update', $company->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <label for="company_name">Company Name</label><br>
                <input type="text" id="company_name" name="company_name" class="company_name" size="50"
                       value="{{$company->name}}"><br>
                <span id="SpanCname" class="error"></span> <br>

                <label for="Address">Address</label><br>
                <input type="text" id="Address" name="address" class="address" size="50" value="{{$company->location}}"><br>
                <span id="SpanAddress" class="error"></span> <br>

                <label for="Email">Email</label><br>
                <input type="text" id="Email" name="email" class="email" size="50" value="{{$company->email}}"><br>
                <span id="SpanEmail" class="error"></span> <br>

                <label for="Contact">Contact num</label><br>
                <input type="text" id="Contact" name="phone" class="phone" size="50" value="{{$company->number}}"><br>
                <span id="SpanContact" class="error"></span><br>

                <label for="logo">Company Logo</label><br>
                <input type="file" name="logo" id="logo">
                <div id="msg" role="alert" style="color: darkred;">
                </div>
                <img src="{{Storage::disk('uploads')->url($company->company_image)}}" height="200">
                <span id="spanImage" class="error"></span><br>
                <button class="btn btn-outline-info" type="submit" id="submit">Submit</button>
            </form>
        @else
            <h1>Create New</h1>
            <form id="addPostForm" action="{{route('company.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="company_name">Company Name</label><br>
                <input type="text" id="company_name" name="company_name" class="company_name" size="50"
                       value="{{@old('company_name')}}"><br>
                <span id="SpanCname" class="error"></span> <br>

                <label for="Address">Address</label><br>
                <input type="text" id="Address" name="address" class="address" size="50"
                       value="{{@old('address')}}"><br>
                <span id="SpanAddress" class="error"></span> <br>

                <label for="Email">Email</label><br>
                <input type="text" id="Email" name="email" class="email" size="50" value="{{@old('email')}}"><br>
                <span id="SpanEmail" class="error"></span> <br>

                <label for="Contact">Contact num</label><br>
                <input type="text" id="Contact" name="phone" class="phone" size="50" value="{{@old('phone')}}"><br>
                <span id="SpanContact" class="error"></span><br>

                <label for="logo">Company Logo</label><br>
                <input type="file" name="logo" id="logo">
                <div id="msg" role="alert" style="color: darkred;">
                </div>
                <img src="" height="200">
                <span id="spanImage" class="error"></span>
                <button class="btn btn-outline-info" type="submit" id="submit">Submit</button>
            </form>

    </div>
    @endif
@endsection
@endcanany
