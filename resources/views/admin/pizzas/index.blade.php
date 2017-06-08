@extends('admin.layout.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading has-buttons clearfix">
                        <h1 class="panel-title pull-left">Manage Pizzas</h1>
                        <div class="btn-group pull-right">
                            <a href="{{ url('/admin/pizzas/create') }}" class="btn btn-primary btn-sm">New</a>
                        </div>
                    </div>

                    <div class="panel-body">

                        @include('partials._flash')

                        <table class="table table-hover js-table-users">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Slice</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pizzas as $pizza)
                                    <tr>
                                        <td>{{ $pizza->id }}</td>
                                        <td>{{ $pizza->name }}</td>
                                        <td>{{ $pizza->slice }}</td>
                                        <td>{{ $pizza->type }}</td>
                                        <td>{{ $pizza->quantity }}</td>
                                        <td>{{ date('Y-m-d', strtotime($pizza->created_at)) }}</td>
                                        <td>{{ date('Y-m-d', strtotime($pizza->updated_at)) }}</td>
                                        <td class="js-table-actions">
                                            <a href="{{ url("/admin/pizzas/{$pizza->id}/edit" ) }}" class="btn btn-info btn-sm">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function () {

        $('.js-table-actions > a').on('click', function(e) {
            e.stopPropagation();
        });
    })
</script>
@endpush