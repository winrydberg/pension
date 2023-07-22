@extends('includes.master')

@section('styles')
 
@stop

@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h4 class="nk-block-title">Upload Request Files</h4>
                          <div class="nk-block-des text-soft">
                              <p>Select files  to upload as request files</p>
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
                                          <h6 class="title"> Request Files Upload</h6>
                                      </div>
                                      <div class="card-tools">
                                          <em class="card-hint icon ni ni-help" data-bs-toggle="tooltip" data-bs-placement="left" title="Revenue of this month"></em>
                                      </div>
                                  </div>

                                  <div class="card">
                                    <form action="#"  id="processedFilesForm" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="row g-gs">
                                           
                                        
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstname">Claim ID</label>
                                                        <input type="text" readonly value="{{$claimid}}" readonly class="form-control" id="claimid" name="claimid">
                                                    </div>
                                                </div>
                                      
                      
                                            <br />
                      
                                                <div class="col-md-12">
                                                  <div class="form-group">
                                                    <label for="firstname">Select Files</label>
                                                    <input id="input-id" name="claimfiles[]" multiple  type="file" required>   
                                                  </div>
                                                </div>
                                       
                                           
                                                
                                        
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-plus-circle"></i> <i id="loader" class="fa fa-spinner fa-spin"></i> Upload Request Files</button>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">

<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/plugins/buffer.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/plugins/filetype.min.js" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/fileinput.min.js"></script>
<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2();
    })

    $(document).ready(function() {
        // with plugin options
        $("#input-id").fileinput({'previewFileType': 'any', 'showUpload': false, 'maxFileCount': 0});
    });
</script>


<script>
  $(document).ready(function(){
     $('#loader').hide()
     $('#processedFilesForm').submit(function(event) {
      event.preventDefault();

      var formData = new FormData(this);

     
      
      Swal.fire({
        title: 'Request File(s) Upload',
        text: "You are about to upload request files for a claim. ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Continue'
        }).then((result) => {
        if (result.isConfirmed) {
            $('#loader').show()
            $.ajax({
                url: "{{url('/request-files')}}",
                method: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
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