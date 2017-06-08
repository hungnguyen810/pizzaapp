@extends('admin.layout.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading has-buttons">
                        <h2 class="panel-title">
                            User information
                        </h2>
                        <div class="btn-group">
                            <a href="{{ url("/admin/users/{$user->id}/edit" ) }}" class="btn btn-primary btn-sm">Edit</a>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table table-striped table-no-margin">
                                <tr>
                                    <td><strong>Name</strong></td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created At</strong></td>
                                    <td>{{ date('Y-m-d', strtotime($user->created_at)) }}</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            User Permissions
                        </h2>
                    </div>

                    <div class="panel-body">

                        @include('admin.user_permissions._permissions', [
                            'permissions' => $permissions,
                            'user' => $user
                        ])

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