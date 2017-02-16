@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Admin Panel</div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th>№</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Value</th>
                                <th>Selected</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Author</th>
                                <th>Theme</th>
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
                                <td>{{ $attackPlan->theme_id }}</td>
                                <td>{{ $attackPlan->created_at }}</td>
                                <td>{{ $attackPlan->updated_at }}</td>
                                @empty
                                <td>No plans</td>    
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th>№</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Selected</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Author</th>
                                <th>Created</th>
                                <th>Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attackThems as $attackThem)
                            <tr>
                                <td>{{ $attackThem->id }}</td>
                                <td>{{ $attackThem->name }}</td>
                                <td>{{ $attackThem->description }}</td>
                                <td>{{ $attackThem->selected }}</td>
                                <td>{{ $attackThem->level }}</td>
                                <td>{{ $attackThem->status }}</td>
                                <td>{{ $attackThem->author_id }}</td>
                                <td>{{ $attackThem->created_at }}</td>
                                <td>{{ $attackThem->updated_at }}</td>
                                @empty
                                <td>No thems</td>    
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
