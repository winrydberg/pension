@extends('includes.master')


@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h3 class="nk-block-title page-title">Banks</h3>
                          <div class="nk-block-des text-soft">
                              <p>On this page, you can add new banks into the platform, view all banks and payments submitted to them for processing.</p>
                          </div>
                      </div><!-- .nk-block-head-content -->
                     
                  </div><!-- .nk-block-between -->
              </div><!-- .nk-block-head -->
              <div class="nk-block">
                  <div class="row g-gs">
                      <div class="col-md-6 col-xxl-5">
                          <div class="card card-bordered">
                              <div class="card-inner">
                                  <div class="card-title-group align-start pb-3 g-2">
                                      <div class="card-title">
                                          <h6 class="title">Add Bank</h6>
                                      </div>
                                      <div class="card-tools">
                                          <em class="card-hint icon ni ni-help" data-bs-toggle="tooltip" data-bs-placement="left" title="Revenue of this month"></em>
                                      </div>
                                  </div>

                                  <div class="card-content">
                                    <form action="#" id="newState" class="form-validate is-alter">
                                        {{csrf_field()}}
                                        <div class="row g-gs">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="fva-message"> Name</label>
                                                    <div class="form-control-wrap">
                                                        <input class="form-control" id="name" name="name"/>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-plus-circle"></i> <i id="loader" class="fa fa-spinner fa-spin"></i> <span>Add Bank</span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                  </div>
                                 
                              </div>
                          </div><!-- .card -->
                      </div><!-- .col -->


                      <div class="col-md-6 col-xxl-5">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group align-start pb-3 g-2">
                                    <div class="card-title">
                                        <h6 class="title">All Banks</h6>
                                    </div>
                                    <div class="card-tools">
                                        <em class="card-hint icon ni ni-help" data-bs-toggle="tooltip" data-bs-placement="left" title="Revenue of this month"></em>
                                    </div>
                                </div>

                                <div class="card">
                                    <table class="table">
                                        <thead class="table-light">
                                          <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Total Pending Payments</th>
                                            <th scope="col">Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($banks as $key => $bank)
                                                <tr>
                                                    <td>{{$bank->name}}</td>
                                                    <td>
                                                        <span class="badge bg-danger">{{$bank->employees_count}}</span>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-success btn-round"><em class="icon ni ni-user"></em> <span>View Payments</span></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                          
                                        </tbody>
                                      </table>
                                </div>
                               
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->
                  </div><!-- .row -->
              </div><!-- .nk-block -->
          </div>
      </div>
  </div>
</div>
@stop

@section('scripts')

<!-- Select2 -->
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2();
    })
</script>

<script>

    var cloneclount =0;

    $(document).ready(function(){
       $('#loader').hide()
       $('#newState').submit(function(event) {
        event.preventDefault();
  
        Swal.fire({
          title: 'Add a New Bank',
          text: "You are about to add new bank. Are you sure?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Continue'
          }).then((result) => {
          if (result.isConfirmed) {
              $('#loader').show()
              $.ajax({
                  url: "{{url('/new-bank')}}",
                  method: "POST",
                  data: $('#newState').serialize(),
                  success: function(response){
                      if(response.status == 'success'){
                        $('#loader').hide()
                         Swal.fire(
                          'Success!!!',
                           response.message,
                          'success'
                        ).then(() => {
                            window.location.reload();
                        })
                      }else{
                        $('#loader').hide()
                         Swal.fire(
                          'Error!!!',
                           response.message,
                          'error'
                        )
                      }
                  },
                  error: function(error){
                    $('#loader').hide()
                     Swal.fire(
                      'Error!!!',
                      'Oops, unable to add bank. Please try again',
                      'error'
                     ) 
                  }
              })
          }
          })
       })
    })
</script>
@stop