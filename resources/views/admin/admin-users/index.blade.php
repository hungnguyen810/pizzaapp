@extends('admin.layout.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading has-buttons">
                        <h1 class="panel-title">Manage Admin Users</h1>
                        <div class="btn-group">
                            <a href="{{ url('/admin/admin-users/create') }}" class="btn btn-primary btn-sm">New</a>
                        </div>
                    </div>

                    <div class="panel-body">

                        @include('partials._flash')

                        <table class="table table-striped">
                            <tr>
                                <td>ID</td>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Created at</td>
                            </tr>
                            @foreach ($adminUsers as $adminUser)
                                <tr>
                                    <td>{{ $adminUser->id }}</td>
                                    <td>{{ $adminUser->name }}</td>
                                    <td>{{ $adminUser->email }}</td>
                                    <td>{{ date('Y-m-d', strtotime($adminUser->created_at)) }}</td>
                                </tr>
                            @endforeach
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

    })
</script>
@endpush