@extends('admin.payment.layout')

@section('paymentcss')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="row" style="margin:10px;font-size:18px;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 style="display:inline;margin-left:0.5rem;"><i class="fab fa-amazon-pay nav-icon"></i></h3>
                @can('New Payments')
                    <a style="display:inline;float:right;margin-right:0.5rem;" class="btn btn-primary" href="{{ route('payments.create') }}"><i class="fab fa-amazon-pay"></i> {{ __('messages.New') }} Payment</a>
                @endcan
            </div>
                <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-hover" style="font-size:18px;vertical-align: middle;">
                    <thead>
                    <tr role="row" class="text-uppercase">
                        @if($i != -1)
                        <th>No</th>
                        @endif
                        <th>Country</th>
                        <th>Name</th>
                        <th>Number of Users</th>
                        <th>Price</th>
                        <th>Currency</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                        @if($i != -1)
                            <td>{{ ++$i }}</td>
                        @endif
                        <td>{{ $payment->country }}</td>
                        <td>{{ $payment->name }}</td>
                        <td>{{ $payment->numberofusers }}</td>
                        <td>{{ $payment->price }}</td>
                        <td>{{ $payment->currency }}</td>
                        <td>
                            @can('Edit Payments')
                                <a class="btn btn-info " href="{{ route('payments.edit',$payment->id) }}">Edit</a>
                            @endcan
                            @can('Delete Payments')
                                <button class="btn btn-danger  remove-payment" data-id="{{ $payment->id }}" data-action="{{ route('payments.destroy',$payment->id) }}">Delete</button>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@endsection
@section('paymentjs')
<!-- DataTables -->
<script src="{{ asset('bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/dataTable.js') }}"></script>

<script type="text/javascript">
  $("body").on("click",".remove-payment",function(){
    var current_object = $(this);
    swal({
        title: "{{ __('messages.Are you sure?') }}",
        text: "{{ __('messages.You will not be able to recover this info!') }}",
        type: "error",
        showCancelButton: true,
        dangerMode: true,
        cancelButtonClass: '#DD6B55',
        confirmButtonColor: '#dc3545',
        confirmButtonText: "{{ __('messages.Delete') }}" + '!',
        cancelButtonText: "{{ __('messages.Cancel') }}",
    },function (result) {
        if (result) {
            var action = current_object.attr('data-action');
            var token = jQuery('meta[name="csrf-token"]').attr('content');
            var id = current_object.attr('data-id');

            $('body').html("<form class='form-inline remove-form' method='post' action='"+action+"'></form>");
            $('body').find('.remove-form').append('<input name="_method" type="hidden" value="delete">');
            $('body').find('.remove-form').append('<input name="_token" type="hidden" value="'+token+'">');
            $('body').find('.remove-form').append('<input name="id" type="hidden" value="'+id+'">');
            $('body').find('.remove-form').submit();
        }
    });
});
</script>
@endsection