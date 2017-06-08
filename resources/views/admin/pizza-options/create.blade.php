@extends('admin.layout.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">New Pizza Option</div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/pizza-options/') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Pizza Name</label>

                                <div class="col-md-6">
                                    {{
                                        Form::select(
                                            'pizza_id',
                                            $pizzas,
                                            '',
                                            [
                                                'class' => 'form-control',
                                                'id' => 'pizza_id'
                                            ]
                                        )
                                    }}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('slice') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Option Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                <label for="option_price" class="col-md-4 control-label">Option Price</label>

                                <div class="col-md-6">
                                    <input id="option_price" type="number" class="form-control" name="option_price" required>

                                    @if ($errors->has('option_price'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('option_price') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4 text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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