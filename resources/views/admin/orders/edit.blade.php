@extends('admin.layout.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Order Information</h2>
                    </div>

                    <div class="panel-body">

                        @if (session('statusData'))
                            <div class="alert alert-success">
                                {{ session('statusData') }}
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="post" action="{{ url("/admin/orders/{$orders->id}") }}">
                            {{ csrf_field() }}

                            {{ method_field('PATCH') }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Status</label>

                                <div class="col-md-6">
                                    {{
                                        Form::select(
                                            'status',
                                            [
                                                'place_order' => 'Place Order',
                                                'pay_success' => 'Pay Success',
                                                'shipment' => 'Shipment',
                                                'complete' => 'Order Complete'
                                            ],
                                            $orders->status,
                                            [
                                                'class' => 'form-control',
                                                'id' => 'status'
                                            ]
                                        )
                                    }}

                                    @if ($errors->has('status'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('status') }}</strong>
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