@extends('admin.layout.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading has-buttons clearfix">
                        <h1 class="panel-title pull-left">Manage Users</h1>
                        <div class="btn-group pull-right">
                            <a href="{{ url('/admin/users/create') }}" class="btn btn-primary btn-sm">New</a>
                        </div>
                    </div>

                    <div class="panel-body">

                        @include('partials._flash')

                        <table class="table table-hover js-table-users">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ date('Y-m-d', strtotime($user->created_at)) }}</td>
                                        <td>{{ date('Y-m-d', strtotime($user->updated_at)) }}</td>
                                        <td class="js-table-actions">
                                            <a href="{{ url("/admin/users/{$user->id}/edit" ) }}" class="btn btn-info btn-sm">Edit</a>
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