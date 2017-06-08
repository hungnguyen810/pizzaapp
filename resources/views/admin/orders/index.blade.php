@extends('admin.layout.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading has-buttons clearfix">
                        <h1 class="panel-title pull-left">Manage Orders</h1>
                    </div>

                    <div class="panel-body">

                        @include('partials._flash')

                        <table class="table table-hover js-table-users">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Pizza Name</th>
                                    <th>Pizza Option Name</th>
                                    <th>Total Price</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->pizza->name }}</td>
                                        <td>{{ $order->pizza_option->name }}</td>
                                        <td>{{ $order->total_price }}</td>
                                        <td>{{ $order->address }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ date('Y-m-d', strtotime($order->created_at)) }}</td>
                                        <td>{{ date('Y-m-d', strtotime($order->updated_at)) }}</td>
                                        <td class="js-table-actions">
                                            <a href="{{ url("/admin/orders/{$order->id}/edit" ) }}" class="btn btn-info btn-sm">Edit</a>
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