@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Admin Panel</div>
                <div class="panel-body">
                    {{ $message }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
