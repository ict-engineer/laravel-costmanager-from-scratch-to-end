@extends('admin.provider.layout')

@section('providercss')
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
                <h3 style="display:inline;margin-left:0.5rem;"><i class="far fa-user nav-icon"></i></h3>
                @can('New Providers')
                    <a style="display:inline;float:right;margin-right:0.5rem;" href="{{ route('providers.create') }}" class="btn btn-primary">
                    <span class="svg-icon svg-icon-md svg-icon-white">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#ffffff" fill-rule="nonzero" opacity="0.3" />
                                <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#ffffff" fill-rule="nonzero" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>{{ __('messages.New') }} Provider</a>
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
                        <th>Company</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>User</th>
                        <th>Address</th>
                        <th>Country</th>
                        <!-- <th>Shop</th> -->
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($providers as $provider)
                        <tr>
                        @if($i != -1)
                            <td>{{ ++$i }}</td>
                        @endif
                        <td>{{ $provider->companyname }}</td>
                        <td>{{ $provider->name }}</td>
                        <td>{{ $provider->phone }}</td>
                        <td>{{ $provider->email }}</td>
                        <td>{{ $provider->addline1 }}</td>
                        <td>{{ $provider->country }}</td>
                        <!-- <td class="shopCol" id="provider_id_{{ $provider->id }}" style="text-align:center;">
                            @foreach ($provider->shops as $shop)
                            <div class="row" style="margin-bottom:3px;text-align:center;">
                            <div class="col-sm-12">
                                <a class="btn btn-success shop-button" data-item-id="{{ $provider->id }}" id="shop_id_{{ $shop->id }}" href="{{ route('shops.edit',$shop->id) }}" data-id="{{ $shop->id }}">{{ $shop->name }}</a>    
                                <a class="btn btn-secondary shop-material" data-item-id="{{ $provider->id }}" href="{{ route('materials.index', [$shop->id]) }}" data-id="{{ $shop->id }}">M</a>    
                                </div>
                            </div>
                            @endforeach
                            <a class="btn btn-light-success shop-new" style="margin:3px;" data-item-id="{{ $provider->id }}" href="{{ route('shops.create', [$provider->id]) }}">New</a>    
                        </td> -->
                        <td>
                            <a class="btn btn-info  " href="{{ route('providers.show',$provider->id) }}">View</a>
                            
                            @can('Edit Providers')
                                <a class="btn btn-success " href="{{ route('providers.edit',$provider->id) }}">Edit</a>
                            @endcan
                            @can('Delete Providers')
                                <button class="btn btn-danger  remove-provider" data-id="{{ $provider->id }}" data-action="{{ route('providers.destroy',$provider->id) }}">Delete</button>
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

<!-- <div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="shopForm" name="shopForm" class="form-horizontal">
                    <input type="hidden" name="provider_id" id="provider_id">
                    <input type="hidden" name="shop_id" id="shop_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Address Line1</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="addline1" name="addline1" placeholder="Enter Address Line1" value="" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Country</label>
                        <div class="col-sm-12">
                            <input id="country_selector" type="text" name="country"  class="form-control" value="Mexico (México)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">C.P.</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="cp" name="cp" placeholder="Enter Name" value="" required="">
                        </div>
                    </div>

                    <div style="display:flex;float:right;">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                     <button class="btn btn-danger" id="cancelBtn" style="margin-left:10px;margin-right:3em;" value="cancel">Cancel
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->
@endsection
@section('providerjs')
<!-- DataTables -->
<script src="{{ asset('bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/dataTable.js') }}"></script>

<script type="text/javascript">
  $("body").on("click",".remove-provider",function(){
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

<!-- <script type="text/javascript">
  $(function () {
    const genderOldValue = "{!! old( 'countryCode') !!}";
    if(genderOldValue !== '') {
        $('#countrycodeSel').val(genderOldValue);
    }
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    $('body').on('click', '.shop-new', function () {
        provider_id = $(this).attr("data-item-id");
        $('#ajaxModel').modal('show');
        $('#saveBtn').val("Create Shop");
        $('#shop_id').val('');
        $('#provider_id').val(provider_id);
        $('#shopForm').trigger("reset");
        $('#modelHeading').html("Create New Shop");
    });

    $('body').on('click', '.shop-button', function () {
        var shop_id = $(this).data('id');
        $.get("shops" +'/' + shop_id +'/edit', function (data) {
            $('#ajaxModel').modal('show');
            $('#modelHeading').html("Edit Customer");
            $('#saveBtn').val("Edit Shop");
            $('#provider_id').val(data.provider_id);
            $('#shop_id').val(data.id);
            $('#name').val(data.name);
            $('#addline1').val(data.addline1);
            $('#country_selector').val(data.country);
            $('#cp').val(data.cp);
        })
   });

   $('#cancelBtn').click(function (e) {
        e.preventDefault();
        $('#shopForm').trigger("reset");
        $('#ajaxModel').modal('hide');
   });
    $('#saveBtn').click(function (e) {
        $(this).html('Sending..');

        $.ajax({
          data: $('#shopForm').serialize(),
          url: "shops",
          type: "POST",
          dataType: 'json',
          success: function (data) {
            $.ajax({
                url: "providers",
            });            
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });

  });
</script> -->
@endsection