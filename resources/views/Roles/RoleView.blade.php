@extends('layouts.app')
@can('manage_role')
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
    <a href="{{route('role.create')}}">Add New Role</a>

    <table class="table table-hover">
        <thead>
        <tr>
            <th class="text-center">SN</th>
            <th class="text-center">Roles</th>
            <th class="text-center">Permissions</th>
            <th class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $index = 1;?>
        @foreach($result as $role)
            <tr>
                <td>{{$index}}</td>
                <td>{{$role->name}}</td>
                <td>@foreach($role->permissions as $rp)
                        @if ($rp['pivot']['role_id']===$role->id)
                            {{$rp['name']}}
                            <br>
                        @endif
                    @endforeach</td>
                <td><a class="fa fa-edit" href="{{route('role.edit', $role->id)}}"></a>/
                    <form action="{{url('role/'.$role->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="fa fa-trash"></button>
                    </form>
                </td>
            </tr>

            <?php $index++;?>
        @endforeach
        </tbody>
    </table>

@endsection
@endcan
