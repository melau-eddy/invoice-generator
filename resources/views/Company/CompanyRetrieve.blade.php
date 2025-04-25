@extends('layouts.app')
@can('access_company')
@section('CssSection')
    <link href="{{ asset('css/UserLayout.css') }}" rel="stylesheet">
@endsection
@section('title') Company @endsection
@section('body')
    @if (session('status'))
        <div class="alert alert-success">{{session('status')}}</div>
    @endif
    @if (session('error_msg'))
        <div class="alert alert-success">{{session('msg')}}</div>
    @endif
    @if(isset($companies))
        <a href="{{route('company.create')}}">Add New Company</a>
        <nav aria-label="...">
            <ul class="pagination">
                @for ($i=1; $i<=$total; $i++)
                    <li class="page-item"><a class="page-link" id="{{$i}}" onclick="make_active({{$i}})"
                                             href="{{request()->fullUrlWithQuery(['page'=>$i])}}">{{$i}}</a></li>
                @endfor

            </ul>
        </nav>

        <form class="d-flex" action="{{route('company.index')}}" method="GET">
            <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
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
                <th scope="col">View</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody id="CompanyTable">


            <?php $index = 1?>
            @foreach($companies as $company)

                <tr>
                    <td>{{$index}}</td>
                    <td>{{$company->name}}</td>
                    <td>{{$company->email}}</td>
                    <td><a class="fa fa-eye" href="{{route('company.show', $company->id)}}"></a></td>
                    <td><a class="fa fa-edit" href="{{route('company.edit', $company->id)}}"></a></td>
                    <td>
                        <form action="{{route('company.destroy', $company->id)}}" method="POST">
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
        </tbody>
    @else
        Company Name: {{$company->name}} <br>
        Company Email: {{$company->email}} <br>
        Location: {{$company->location}} <br>
        Contact Number: {{$company->number}}
    @endif
@section('JsSection')
    <script src="{{ asset('js/UserRetrieve.js') }}"></script>
@endsection
@endsection
@endcan
