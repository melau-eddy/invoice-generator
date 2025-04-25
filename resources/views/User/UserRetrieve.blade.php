@extends('layouts.app')
@if (session('status'))
    <div class="alert alert-success">{{session('status')}}</div>
@endif
@can('access_user')
@section('CssSection')
    <link href="{{ asset('css/UserLayout.css') }}" rel="stylesheet">

@endsection
@section('title') User @endsection
@section('body')
    @if (session('status'))
        <div class="alert alert-success">{{session('status')}}</div>
    @endif
    @if (session('error_msg'))
        <div class="alert alert-success">{{session('msg')}}</div>
    @endif
    <a href="{{route('user.create')}}">Add New User</a>
    <nav aria-label="...">
        <ul class="pagination">
            @for ($i=1; $i<=$total; $i++)
                <li class="page-item"><a class="page-link" id="{{$i}}" onclick="make_active({{$i}})" href="{{request()->fullUrlWithQuery(['page'=>$i])}}">{{$i}}</a></li>
            @endfor

        </ul>
    </nav>

    <form class="d-flex" action="{{route('Users')}}" method="GET">
        <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    <input type="hidden" id="order" name="order">
    <input type="hidden" id="id" name="id">
    <table class="table table-hover">
        <thead>
        <tr>
            @if (!request()->has('sort') and !request()->has('order'))
                <th scope="col" class="column_sort" id="sn">
                    <a href="{{request()->fullUrlWithQuery(['sort'=>'desc', 'order'=>'id'])}}">SN</a></th>
                <th scope="col" class="column_sort" id="name"><a
                        href="{{request()->fullUrlWithQuery(['sort'=>'desc', 'order'=>'name'])}}">
                        Name</a></th>
                <th scope="col" class="column_sort" id="email">
                    <a href="{{request()->fullUrlWithQuery(['sort'=>'desc', 'order'=>'email'])}}">Email</a></th>
            @elseif (request()->has('sort') and request()->has('order'))
                @php
                    if (request()->get('sort')=='desc'){
        $sort='asc';
    }
    else{
        $sort='desc';
    }
                @endphp
                <th scope="col" class="column_sort" id="sn">
                    <a href="{{request()->fullUrlWithQuery(['sort'=>$sort, 'order'=>'id'])}}">SN</a></th>
                <th scope="col" class="column_sort" id="name"><a
                        href="{{request()->fullUrlWithQuery(['sort'=>$sort, 'order'=>'name'])}}">
                        Name</a></th>
                <th scope="col" class="column_sort" id="email">
                    <a href="{{request()->fullUrlWithQuery(['sort'=>$sort, 'order'=>'email'])}}">Email</a></th>

            @endif
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody id="CompanyTable">

        @if (isset($result))
            <?php $index = 1?>
            {{--        @dd($search->name);--}}
            @foreach($result as $user)

                <tr>
                    <td>{{$index}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td><a class="fa fa-edit" href="{{route('user.edit', $user->id)}}"></a></td>
                    <td>
                        <form action="{{url('user/'.$user->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="fa fa-trash"></button>
                        </form>
                    </td>
                </tr>

                <?php $index++;?>
            @endforeach<br>
        </tbody>
    </table>
    @else
        <?php $index = 1;?>
        {{ $users -> links()}}
        @foreach($users as $user)

            <tr>
                <td>{{$index}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td><a class="fa fa-edit" href="{{route('user.edit', $user->id)}}"></a></td>
                <td>
                    <form action="{{url('user/'.$user->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="fa fa-trash"></button>
                    </form>
                </td>
            </tr>
            <?php $index++;?>
        @endforeach<br>
        </tbody>
    @endif
@section('JsSection')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/UserRetrieve.js') }}"></script>
@endsection
@endsection
@endcan
