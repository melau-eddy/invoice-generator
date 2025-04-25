@extends('layouts.app')
@can('manage_role')
@section('title') Audit Log @endsection
@section('body')
    @if (session('status'))
        <div class="alert alert-success">{{session('status')}}</div>
    @endif
    @if (session('error_msg'))
        <div class="alert alert-success">{{session('msg')}}</div>
    @endif
    @foreach($audits as $audit)
    @if ($audit->old_values !== [])
        @if ($audit->event==="updated")
        On {{$audit->created_at}}: {{$audit->user->name}} {{$audit->event}} from this record.
        @if(isset($audit->new_values['name']))
            Name from {{$audit->old_values['name']}} to
            {{$audit->new_values['name']}}
        @endif
        @if(isset($audit->new_values['email']))
            Name from {{$audit->old_values['email']}} to
            {{$audit->new_values['email']}}
        @endif
        @else
            On {{$audit->created_at}}: {{$audit->user->name}} {{$audit->event}} from this record.
            Deleted name is {{$audit->old_values['name']}}
            and deleted email is
            {{$audit->old_values['email']}}
        @endif
    @endif<br>
    @endforeach

@endsection
@endcan
