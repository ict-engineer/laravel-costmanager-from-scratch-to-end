@extends('admin.material.layout')

@section('materialcss')
<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
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
                <h3 style="display:inline;margin-left:0.5rem;"> <i class="far fa-heart nav-icon"></i></h3>
                @can('New Materials')
                    <a style="display:inline;float:right;margin-right:0.5rem;" href="{{ route('materials.create') }}" class="btn btn-primary">
                    <i class="far fa-heart"></i> {{ __('messages.New') }} Material</a>
                @endcan
            </div>
                <!-- /.card-header -->
            <div class="card-body">
                <form class="form" method="GET">
                    <div class="form-group row">
                        <div class="col-md-4 col-sm-12" style="display:flex;justify-content:center;"><h4>{{ $materials->total() }}  Materials</h4></div>
                        <div class="col-md-3 col-sm-12" style="display:flex;">
                            <label class="col-form-label" style="margin-right:1rem;" for="providerlist">Provider</label>
                            <select class="form-control select2" name="providerlist" style="width:100%;" id="providerlist"></select>
                        </div>
                        <div class="col-md-3 col-sm-12" style="display:flex;">
                            <label class="col-form-label" style="margin-right:1rem;margin-left:1.6rem;"  >Shop</label>
                            <select class="form-control select2" name="shoplist"  style="width:100%;" id="shoplist"></select>
                        </div>
                        <div class="col-md-2 col-sm-12" style="display:flex;justify-content:center;">
                            <button type="submit" class="btn btn-info">Show</button>
                        </div>
                    </div>
                </form>
                <table id="materialTable" class="table table-bordered table-hover" style="font-size:18px;vertical-align: middle;">
                    <thead>
                    <tr role="row" class="text-uppercase">
                        @if($i != -1)
                        <th>No</th>
                        @endif
                        <th>Provider</th>
                        <th>Shop Name</th>
                        <th>Description</th>
                        <th>Brand</th>
                        <th>Sku</th>
                        <th>Part No.</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        
                    @foreach ($materials as $material)
                        <tr>
                        @if($i != -1)
                            <td>{{ ++$i }}</td>
                        @endif
                        <td>{{ $material->providerlist }}</td>
                        <td>{{ $material->shoplist }}</td>
                        <td>{{ $material->description }}</td>
                        <td>{{ $material->brand }}</td>
                        <td>{{ $material->sku }}</td>
                        <td>{{ $material->partno }}</td>
                        <td>{{ $material->price }} {{ $material->currency }}</td>
                        <td>
                            <img src="{{ $material->image }}"  alt="Image" width="150" height="150">
                        </td>
                        <td>
                            @can('Edit Materials')
                                <a class="btn btn-success" href="{{ route('materials.edit',$material->id) }}">Edit</a>
                            @endcan
                            @can('Delete Materials')
                                <button class="btn btn-danger remove-material" data-id="{{ $material->id }}" data-action="{{ route('materials.destroy',$material->id) }}">Delete</button>
                                
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div style="display:flex;justify-content:center;">
                    {{ $materials->appends($filter)->links() }}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@endsection
@section('materialjs')
<!-- DataTables -->
<script src="{{ asset('bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/dataTable.js') }}"></script>

<script type="text/javascript">
  $("body").on("click",".remove-material",function(){
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

<!-- <script src="{{ asset('js/image-input.js') }}"></script> -->
<script src="{{ asset('bower_components/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
  var table = $('#materialTable').DataTable({
        "responsive": true,
        "autoWidth": false,
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "info": false,
    });
  $('.select2').select2({
    dropdownAutoWidth : true
  });
  var providers = {!! $providers !!};
  var provider;
  $('#providerlist').append(new Option('All', 'All'));
  for(provider of providers)
    $('#providerlist').append(new Option(provider, provider));
    
    
    // Event listener to the two range filtering inputs to redraw on input
    // $('#shoplist').change( function() {
    //     table.draw();
    // } );
    // $('#providerlist').change( function() {
    //     table.draw();
    // } );
  updateshoplist();
    $providervalue = "{!! $filter['providerlist'] ?? '' !!}";
    if($providervalue != '')
    {
        $('#providerlist').val($providervalue).change();
    }
  
  function updateshoplist()
  {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'GET',
        url: "{{URL::to('shoplist')}}",
        data: {email:$('#providerlist').val()},
        dataType: 'json',
        success: function (data) {
          var shop;
          $('#shoplist').empty();
          $('#shoplist').append(new Option('All', 'All'));
          for(shop of data)
            $('#shoplist').append(new Option(shop, shop));

            
            $shopvalue = "{!! $filter['shoplist'] ?? '' !!}";
            if($shopvalue != '')
            {
                $('#shoplist').val($shopvalue).change();
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
  }
  $('#providerlist').on('change', function() {
    updateshoplist();
  });
//   $.fn.dataTable.ext.search.push(
//     function( settings, data, dataIndex ) {
//         var provider = $('#providerlist').val();
//         var shopname = $('#shoplist').val();
        
//         var i = {!! $i !!};
//         if ( i != -1 && shopname == data[2] && provider == data[1])
//         {
//             return true;
//         }
//         if ( i == -1 && shopname == data[1] && provider == data[0])
//         {
//             return true;
//         }
//         return false;
//     });

</script>

@endsection