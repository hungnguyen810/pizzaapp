@extends('admin.layout.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Pizza Information</h2>
                    </div>

                    <div class="panel-body">

                        @if (session('statusData'))
                            <div class="alert alert-success">
                                {{ session('statusData') }}
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="post" action="{{ url("/admin/pizzas/{$pizza->id}") }}">
                            {{ csrf_field() }}

                            {{ method_field('PATCH') }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ old('name') ? old('name') : $pizza->name }}"
                                           required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-4 text-center">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>

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