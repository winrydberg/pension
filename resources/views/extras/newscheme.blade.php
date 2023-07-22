@extends('includes.master')


@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h3 class="nk-block-title page-title">New Scheme</h3>
                          <div class="nk-block-des text-soft">
                              <p>Enter information to add new scheme</p>
                          </div>
                      </div><!-- .nk-block-head-content -->
                     
                  </div><!-- .nk-block-between -->
              </div><!-- .nk-block-head -->
              <div class="nk-block">
                  <div class="row g-gs">
                      <div class="col-xxl-5">
                          <div class="card card-bordered h-100">
                              <div class="card-inner">
                                  <div class="card-title-group align-start pb-3 g-2">
                                      <div class="card-title">
                                          <h6 class="title">Add New Scheme</h6>
                                      </div>
                                      <div class="card-tools">
                                          <em class="card-hint icon ni ni-help" data-bs-toggle="tooltip" data-bs-placement="left" title="Revenue of this month"></em>
                                      </div>
                                  </div>

                                  <div class="">
                                    <form action="#" id="newScheme">
                                        {{csrf_field()}}
                                        <div class="row g-gs">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="fva-message">Scheme Name</label>
                                                    <div class="form-control-wrap">
                                                        <input class="form-control" id="name" required name="name"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="fva-full-name">Scheme Type</label>
                                                    <div class="form-control-wrap">
                                                        <select class="form-control select2" id="schemes" name="tiertype" required  data-placeholder="Select a scheme type"  style="width: 100%;">
                                                            <option label="" value="">Select an option</option>
                                                            <option label="" value="Tier 1">Tier 1</option>
                                                            <option label="" value="Tier 2">Tier 2</option>
                                                            <option label="" value="Tier 3">Tier 3</option>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                    
                                        
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-plus-circle"></i> <i id="loader" class="fa fa-spinner fa-spin"></i> Scheme</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
       $('#newScheme').submit(function(event) {
        event.preventDefault();
  
        Swal.fire({
          title: 'Add a New Scheme',
          text: "You are about to add new scheme",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Continue'
          }).then((result) => {
          if (result.isConfirmed) {
              $('#loader').show()
              $.ajax({
                  url: "{{url('/new-scheme')}}",
                  method: "POST",
                  data: $('#newScheme').serialize(),
                  success: function(response){
                      if(response.status == 'success'){
                        $('#loader').hide()
                         Swal.fire(
                          'Success!!!',
                           response.message,
                          'success'
                        )
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
                      'Oops, somehting went wrong. Please try again',
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