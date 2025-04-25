@extends('layouts.app')
@canany(['create_user', 'update_user'])
@section('CssSection')
    <link href="{{ asset('css/UserLayout.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/UserCreation.css')}}">
    <script type="text/javascript" src="{{asset('js/UserCreate.js')}}"></script>
@endsection
@section('title') User @endsection
@section('body')
    @if (session('error_msg'))
        <div class="alert alert-success">{{session('msg')}}</div>
    @endif
    <div class="testbox">
        @if (isset($user_id))
            <h1>Edit User Details</h1>
            <form action="{{url('user/'.$user_id->id)}}" method="post">
                @csrf
                @method('PUT')
                <label id="icon" for="name"><i class="icon-user"></i></label>
                <input type="text" name="name" id="name" placeholder="Name" required value="{{$user_id->name}}"/><br>
                <label id="icon" for="email"><i class="icon-envelope "></i></label>
                <input type="text" name="email" id="email" placeholder="Email" required value="{{$user_id->email}}"/><br>
                <label id="icon" for="password"><i class="icon-shield"></i></label>
                <input type="password" name="password" id="password" placeholder="Password" style="margin-top: 0;"
                       required value="{{\Illuminate\Support\Facades\Auth::user()->password}}"/><br>
                @foreach ($roles as $role)
                    <input type="checkbox" name="roles[]" value="{{$role->id}}"
                    @if(in_array($role->id, $selected_roles))
                        {{"checked"}}
                        @else
                        {{""}}
                        @endif> {{$role->name}} <br>
                @endforeach

                <button type="submit">Submit</button>
            </form>
        @else
            <h1>User Creation</h1>
            <form action="{{route('user.store')}}" method="post">
                @csrf

                <label id="icon" for="name"><i class="icon-user"></i></label>
                <input type="text" name="name" id="name" placeholder="Name" value="{{@old('name')}}"/><br>
                <span id="Spanname" class="error">@error('name'){{$message}}@enderror</span> <br>
                <label id="icon" for="email"><i class="icon-envelope "></i></label>
                <input type="text" name="email" id="email" placeholder="Email" value="{{@old('email')}}"/><br>
                <span id="Spanemail" class="error">@error('email'){{$message}}@enderror</span> <br>
                <label id="icon" for="password"><i class="icon-shield"></i></label>
                <input id="password" type="password" placeholder="Password" name="password" autocomplete="new-password">
                <span id="Spanpassword" class="error">@error('password'){{$message}}@enderror</span> <br>
                <label id="icon" for="confirm_password"><i class="icon-shield"></i></label>
                <input id="password-confirm" type="password" placeholder="Confirm Password" name="password_confirmation"
                       autocomplete="new-password">
                <span id="SpanConfirmpassword" class="error">@error('confirm_password'){{$message}}@enderror</span> <br>
                <label for="company">Company:</label>

                <select name="company" id="company">
                @foreach($companies as $company)
                    <option value="{{$company->id}}">{{$company->name}}</option>
                @endforeach
                </select><br>
                @foreach ($roles as $role)
                    <input type="checkbox" name="roles[]" value="{{$role->name}}"> {{$role->name}} <br>
                @endforeach


                <button type="submit">Submit</button>
            </form>
        @endif
    </div>
@endsection
@endcanany
