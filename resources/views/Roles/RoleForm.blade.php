@extends('layouts.app')
@can('manage_role')
@section('title') User @endsection
@section('body')
    @if (session('error_msg'))
        <div class="alert alert-success">{{session('msg')}}</div>
    @endif
    @if(isset($selectedperm))
        <div class="right_col" role="main">
            <h1 class="mt-3">Edit Role  <a href="{{route('role.index')}}" class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i> View Roles</a></h1>
            <div class="card mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('role.update', $role->id)}}" method="POST" class="bg-light p-3">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Role Name: </label>
                                <input type="text" name="name" class="form-control" value="{{$role->name}}" placeholder="Enter Role Name">
                                @error('name')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="permission">Permissions </label><br>
                                @foreach ($permissions as $permission)
                                    <input type="checkbox" name="permissions[]" value="{{$permission->id}}"
                                    @if(in_array($permission->id, $selectedperm))
                                        {{"checked"}}
                                        @else
                                        {{""}}
                                        @endif> {{$permission->name}} <br>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @else
    <div class="right_col" role="main">
        <h1 class="mt-3">Create Role  <a href="{{route('role.index')}}" class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i> View Roles</a></h1>
        <div class="card mt-3">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{route('role.store')}}" method="POST" class="bg-light p-3">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="name">Role Name: </label>
                            <input type="text" name="name" class="form-control" value="{{@old('name')}}" placeholder="Enter Role Name">
                            @error('name')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="permission">Permissions </label><br>

                            @foreach ($permissions as $permission)
                                <input type="checkbox" name="permissions[]" value="{{$permission->id}}"> {{$permission->name}} <br>
                            @endforeach
                        </div>


                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
@endcan
