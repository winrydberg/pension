@extends('includes.master')


@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h4 class="nk-block-title ">New Claim</h4>
                          <div class="nk-block-des text-soft">
                              <p>Enter information to add new claim</p>
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
                                          <h6 class="title">Add New Claim</h6>
                                      </div>
                                      <div class="card-tools">
                                          <em class="card-hint icon ni ni-help" data-bs-toggle="tooltip" data-bs-placement="left" title="Revenue of this month"></em>
                                      </div>
                                  </div>

                                  <div class="card">
                                    <form action="#" id="newClaimForm">
                                        {{csrf_field()}}
                                        <div class="row g-gs">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="fva-message">Description</label>
                                                    <div class="form-control-wrap">
                                                        <textarea class="form-control form-control-sm" rows="2" id="description" name="description" placeholder="Enter a description" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="fva-full-name">Company</label>
                                                    <div class="form-control-wrap">
                                                        <select class="form-control select2" id="company" name="company_id" required  data-placeholder="Select a company"  style="width: 100%;">
                                                            <option label="" value="">Select an option</option>
                                                            @foreach ($companies as $c)
                                                              <option value="{{$c->id}}">{{$c->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="fva-full-name">Scheme</label>
                                                    <div class="form-control-wrap">
                                                        <select class="form-control select2" id="schemes" name="scheme_id" required  data-placeholder="Select a scheme"  style="width: 100%;">
                                                            <option label="" value="">Select an option</option>
                                                            @foreach ($schemes as $c)
                                                              <option value="{{$c->id}}">{{$c->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                                
                                        
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-plus-circle"></i> <i id="loader" class="fa fa-spinner fa-spin"></i> Save Claim</button>
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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- xlsx js -->
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
 --}}


<script>
  $(document).ready(function(){
     $('#loader').hide()
     $('#newClaimForm').submit(function(event) {
      event.preventDefault();

     
      
      Swal.fire({
        title: 'Add a New Claim',
        text: "You are about to file a new claim",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Continue'
        }).then((result) => {
        if (result.isConfirmed) {
            $('#loader').show()
            $.ajax({
                url: "{{url('/new-claim')}}",
                method: "POST",
                data: $('#newClaimForm').serialize(),
                success: function(response){
                    if(response.status == 'success'){
                      $('#loader').hide()
                       var onBtnClicked = (btnId) => {
                          Swal.close();
                          if (btnId != "cancel") Swal.fire("you choosed: " + btnId);
                        };
                        Swal.fire({
                            allowOutsideClick: false,
                            title: 'Success',
                            // text: response.message,
                            icon: 'success',
                            showCancelButton: false,
                            html: response.message+`<div>
                                  <a href="${response.request_url}"  style="margin-top: 10px" role="button" tabindex="0" class="btn btn-primary btn-sm btn-round" onclick="onBtnClicked('request files')">Upload Request Documents</a>
                                  <a href="${response.processed_url}" style="margin-top: 10px" role="button" tabindex="0" class="btn btn-success btn-sm btn-round" onclick="onBtnClicked('processed files'")>Upload Processed Documents</a>
                                  <a href="${response.home_url}" style="margin-top: 15px" role="button" tabindex="0" class="btn bg-purple btn-sm btn-round" onclick="onBtnClicked('processed files'")>Go Dashboard</a>
                                </div>`,
                            showCancelButton: false,
                            showConfirmButton: false
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
                    'Oops, unable to add claim. Please try again',
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