@extends('layouts.app')
@section('CssSection')
    <link href="{{ asset('css/UserLayout.css') }}" rel="stylesheet">
@endsection
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
    @if (session('status'))
        <div class="alert alert-success">{{session('status')}}</div>
    @endif
    <div class="container">
        <h1 class="title text-center">Personal Information</h1>
        <div class="row">
            <div class="col-12">
                <div class="media mb-4">
                    <img class="rounded-circle account-img" src="{{Storage::disk('uploads')->url($profile->profile_pic)}}" style="width: 200px;">

                    <div class="media-body mb-4">
                        <h2 class="account-heading">{{$profile->name}}</h2>
                        <p class="text-secondary">{{$profile->email}}</p>
                    </div>
                </div>
                <form method ="POST" enctype="multipart/form-data" action="{{route('updateProfile', \Illuminate\Support\Facades\Auth::user()->id)}}">
                    @csrf
                    @method('PATCH')
                    <label for="name">Name: </label>
                    <input type="text" name="name" id="name" placeholder="Name" value="{{$profile->name}}"/><br>
                    <span id="Spannumber" class="error">@error('name'){{$message}}@enderror</span> <br>

                    <label id="icon" for="number">Phone Number: </label>
                    <input type="number" name="number" id="number" placeholder="Phone Number" value="{{$profile->phone_number}}"/><br>
                    <span id="Spannumber" class="error">@error('phone_number'){{$message}}@enderror</span> <br>
                       <label for="gender">Gender:</label>

                    <select name="gender" id="gender">

                        @if(isset($profile->gender))
                            <option value="{{$profile->gender->id??""}}">{{$profile->gender->name??""}}</option>
                        @foreach($gender as $g)
                            @if($g->id!==$profile->gender->id)
                                <option value="{{$g->id}}">{{$g->name}}</option>
                            @endif
                        @endforeach
                        @else
                            @foreach($gender as $g)
                                <option value="{{$g->id}}">{{$g->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    <label for="status">Status:</label>

                    <select name="status" id="status">

                        @if(isset($profile->status))
                            <option value="{{$profile->status->id??""}}">{{$profile->status->name??""}}</option>
                        @foreach($status as $s)
                            @if($s->id!==$profile->status->id)
                                <option value="{{$s->id}}">{{$s->name}}</option>
                            @endif
                        @endforeach
                        @else
                            @foreach($status as $s)
                                <option value="{{$s->id}}">{{$s->name}}</option>
                            @endforeach
                        @endif
                    </select><br>
                    <label for="file_image">Upload Cover Image: </label>
                    <input type="file" name="file_image" class="form-control" value="{{$profile->filename}}">
                    <span id="Spanfile" class="error">@error('filename'){{$message}}@enderror</span> <br>





                    <button class="updatebutton" type="submit">Update</button>

                </form>
            </div>
        </div>
    </div>
@endsection
