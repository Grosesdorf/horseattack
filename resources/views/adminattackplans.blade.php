@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Admin Panel</div>
                <div class="panel-body">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Value</th>
                                <th>Selected</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Author</th>
                                <th>Created</th>
                                <th>Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attackPlans as $attackPlan)
                            <tr>
                                <td>{{ $attackPlan->id }}</td>
                                <td>{{ $attackPlan->name }}</td>
                                <td>{{ $attackPlan->description }}</td>
                                <td>{{ $attackPlan->value }}</td>
                                <td>{{ $attackPlan->selected }}</td>
                                <td>{{ $attackPlan->level }}</td>
                                <td>{{ $attackPlan->status }}</td>
                                <td>{{ $attackPlan->author_id }}</td>
                                <td>{{ $attackPlan->created_at }}</td>
                                <td>{{ $attackPlan->updated_at }}</td>
                                @empty
                                <td>Нет планов</td>    
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
