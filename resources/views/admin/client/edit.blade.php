@extends('admin.client.layout')

@section('clientcss')
<!-- select -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/select2/css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- flag -->
<link rel="stylesheet" href="{{ asset('bower_components/flag-icon-css/css/flag-icon.min.css') }}">
<!-- check box -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection
@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
    <!-- jquery validation -->
    <div class="card card-primary">
        <div class="card-header">
            <h1 class="card-title">Edit client</h1>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" id="quickForm" action="{{ route('clients.update',$client->id) }}" method="POST" style="font-size:18px;padding:20px;">
            @csrf
            @method('PUT')
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Personal Information</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="exampleInputName1">Name</label>
                        <div class="col-sm-8">
                        <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Name" value="{{ old( 'name', $client->name) }}">
                        
                        </div>
                    </div>          
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="exampleInputPhone1">Phone Number</label>
                        <div class="col-sm-8">
                          <div style="display:flex;">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                              </div>
                              @include('admin.components.phoneprefix')
                              <input type="text" name="phone" class="form-control  @error('phone') is-invalid @enderror" id="exampleInputPhone1" data-inputmask='"mask": "(999) 999-9999"'  value="{{ old( 'phonetmp', $client->phone) }}" data-mask>
                              @if( $errors->has( 'phone' ) )
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first( 'phone' ) }}</strong>
                            </span>
                            @endif
                            </div>
                            
                          </div>
                           
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="exampleInputEmail1">Email address</label>
                        <div class="col-sm-8">
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="exampleInputEmail1"
                            name="email"
                            placeholder="Email Address"
                            required
                            value="{{ old( 'email', $client->email) }}"
                        />
                        @if( $errors->has( 'email' ) )
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first( 'email' ) }}</strong>
                            </span>
                        @endif
                        </div>
                        
                    </div>
                    <div>
                    <div class="icheck-success d-inline">
                        <input type="checkbox" id="resetcheck" name="resetpassword" style="vertical-align: middle;"><label for="resetcheck">   Reset Password</label>
                    </div>
                    </div>
                    <div style="margin-left:3rem;">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="exampleInputPassword3">Password</label>
                        <div class="col-sm-8">
                        <input type="password" name="new_password" disabled class="form-control" id="exampleInputPassword3" placeholder="Password" value="{{ old( 'new_password') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="exampleInputPassword2">Confirm Password</label>
                        <div class="col-sm-8">
                        <input type="password" name="confirm_password" disabled class="form-control  @error('confirm_password') is-invalid @enderror" id="exampleInputPassword2" placeholder="Confirm Password" value="{{ old( 'confirm_password') }}">
                        @if( $errors->has( 'confirm_password' ) )
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first( 'confirm_password' ) }}</strong>
                        </span>
                        @endif
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Company Information</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="exampleInputCompany1">Company Name</label>
                        <div class="col-sm-8">
                        <input type="text" name="companyname" class="form-control @error('companyname') is-invalid @enderror" id="exampleInputCompany1" placeholder="Company" value="{{ old( 'companyname', $client->companyname) }}">
                        @if( $errors->has( 'companyname' ) )
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first( 'companyname' ) }}</strong>
                            </span>
                        @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="exampleInputAddline1">Address Line</label>
                        <div class="col-sm-8">
                        <input type="text" name="addline1" class="form-control" id="exampleInputAddline1" placeholder="Address Line1" value="{{ old( 'addline1', $client->addline1) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="country_selector">Country</label>
                        <div class="col-sm-8">
                            @include('admin.components.country')
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="exampleInputCp1">C.P.</label>
                        <div class="col-sm-8">
                        <input type="text" name="cp" class="form-control" id="exampleInputCp1" placeholder="C.P." value="{{ old( 'cp', $client->cp) }}">
                        </div>
                    </div>       
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="numberofemployees">Number of Employees</label>
                        <div class="col-sm-8">
                          <select name="numberofemployees" id="numberofemployees" style="width:100%;">
                              <option value="1-5">1-5</option>
                              <option value="6-20">6-20</option>
                              <option value="21-50">21-50</option>
                              <option value="More than 50">More than 50</option>
                          </select>
                        </div>
                    </div>         
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label" for="service">Select what most describe your businesses:</label>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                          <select name="service[]" multiple="multiple" id="service" style="width:100%;" class="form-control @error('service') is-invalid @enderror">
                          </select>
                          @if( $errors->has( 'service' ) )
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first( 'service' ) }}</strong>
                            </span>
                          @endif
                        </div>
                    </div>         
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label" for="payment">Select the plan what is best for you:</label>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                          <select name="payment" id="payment" style="width:100%;">
                          </select>
                        </div>
                    </div>                               
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="/clients" class="btn btn-secondary float-right" style="margin-left:10px;">Cancel</a>
                <button type="submit" class="btn btn-primary float-right">Update</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
    </div>
    <!--/.col (left) -->
    <!-- right column -->
    <div class="col-md-6">

    </div>
    <!--/.col (right) -->
</div>
<!-- /.row -->
@endsection

@section('clientjs')
@include('admin.client.js')
<script>
 $(document).on('click', '#resetcheck', function () {
  var target = $(this).data('target');    
  if ($(this).is(':checked'))  
  {
      document.getElementById("exampleInputPassword3").disabled = false;
      document.getElementById("exampleInputPassword2").disabled = false;
  }
  else
  {
      document.getElementById("exampleInputPassword3").disabled = true;
      document.getElementById("exampleInputPassword2").disabled = true;
  }
});
</script>
<!-- update service and payment list -->
<script>

  // $('#service').



  updatelist(0);
  function getLanguage()
  {
    var country = $('#country_selector').val();
    if(country == "Spain" || country == "Mexico")
      return 1;
    if(country == "France")
      return 2;
    if(country == "Italy")
      return 3;
    if(country == "Russia")
      return 4;
    if(country == "Germany")
      return 5;

    return 0;
  }
  function updatelist(flag)
  {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    var language = getLanguage();
    $.ajax({
        type: 'GET',
        url: "{{URL::to('servicepaymentlist')}}",
        data: {language:language, country:$('#country_selector').val()},
        dataType: 'json',
        success: function (data) {
          var ele;
          $('#service').empty();
          $('#payment').empty();
          for(ele of data['services'])
            $('#service').append(new Option(ele, ele));
          for(ele of data['payments'])
            $('#payment').append(new Option(ele, ele));
          if(flag == 0){
            const paymentValue = "{!! $client->payment !!}";
            if(paymentValue !== '') {
              $('#payment').val(paymentValue).change();
            }
            const paymentOldValue = "{!! old( 'payment') !!}";
            if(paymentOldValue !== '') {
              $('#payment').val(paymentOldValue).change();
            }
            const serviceValue = <?php echo json_encode($client->service); ?>;
            $("#service").val(serviceValue).trigger("update");
          }
        },
        error: function (data) {
            console.log(data);
        }
    });
  }
  $('#country_selector').on('change', function() {
    updatelist(1);
  });
  </script>
@endsection