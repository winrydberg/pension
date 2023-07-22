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
                          <h4 class="nk-block-title ">Review Issue - {{$issue->issue_ticket}}</h4>
                          <div class="nk-block-des text-soft">
                              <p>Upload file(s) to resolve the issue. </p>
                          </div>
                      </div><!-- .nk-block-head-content -->
                     
                  </div><!-- .nk-block-between -->
              </div><!-- .nk-block-head -->
              <div class="nk-block">
                  <div class="row g-gs">
                      <div class="col-md-8">
                          <div class="card card-bordered h-100">
                              <div class="card-inner">
                                  <div class="card-title-group align-start pb-3 g-2">
                                      <div class="card-title">
                                          <h6 class="title">Upload Resolved Issue File(s)</h6>
                                      </div>
                                    </div>

                                  <div class="card">
                                    <form action="#"  id="processedFilesForm" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="row g-gs">
                                           
                                        
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstname">Issue Ticket</label>
                                                        <input type="text" readonly value="{{$issue->issue_ticket}}" readonly class="form-control" id="ticket" name="ticket">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fva-message">Message</label>
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control form-control-sm" rows="2" id="resolve_message" name="resolve_message" placeholder="Enter a resolution message" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                      
                      
                                            <br />
                      
                                                <div class="col-md-12">
                                                  <div class="form-group">
                                                    <label for="firstname">Select Files</label>
                                                    <input id="input-id" name="claimfiles[]" multiple  type="file">   
                                                  </div>
                                                </div>
                                       
                                            {{-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="fva-full-name">Company</label>
                                                    <div class="form-control-wrap">
                                                        <select class="form-control select2" id="schemes" name="company_id" required  data-placeholder="Select a company"  style="width: 100%;">
                                                            <option label="" value="">Select an option</option>
                                                            @foreach ($companies as $c)
                                                              <option value="{{$c->id}}">{{$c->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            
                                            {{-- <div class="col-md-6">
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
                                            </div> --}}
                                                
                                        
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-plus-circle"></i> <i id="loader" class="fa fa-spinner fa-spin"></i> Resolve Issue</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                  </div>
                                 
                              </div>
                          </div><!-- .card -->
                      </div><!-- .col -->

                      <div class="col-md-4">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="card-title-group align-start pb-3 g-2">
                                    <div class="card-title">
                                        <h6 class="title">Issue Summary</h6>
                                    </div>
                                </div>

                                <div class="card">
                                    @if(isset($issue))
                                    <hr />

                                    <p><strong>Issue Message: </strong> {{$issue->message}}</p>
                                    
                                    <hr/>
                                        <?php 
                                            $file = $issue->claim_file;
                                            $filename = '';
                                            if($file != null){
                                              $fileParts = explode("/",$file->filename);
                                              $filename = $fileParts[count($fileParts) - 1];
                        
                                            }
                                        ?>
                                       <p><strong>Affected File</strong></p>
                                       <span>
                                            @if($file != null)
                                                @if(in_array(strtolower($file->extension), ['png', 'jpg', 'jpeg']))
                                                    <img src="{{asset('dist/img/filestypes/image.png')}}" style="width: 40px;"/>
                                                @elseif (strtolower($file->extension) =='pdf')
                                                    <img src="{{asset('dist/img/filestypes/pdf.png')}}" style="width: 40px;"/>
                                                @elseif (in_array(strtolower($file->extension), ['xls', 'xlsx']))
                                                    <img src="{{asset('dist/img/filestypes/sheets.png')}}" style="width: 40px;"/>
                                                @elseif (in_array(strtolower($file->extension), ['doc', 'docx']))
                                                    <img src="{{asset('dist/img/filestypes/word.png')}}" style="width: 40px;"/>
                                                @else
                                                    <img src="{{asset('dist/img/filestypes/file.png')}}" style="width: 40px;"/>
                                                @endif
                                            @else 
                                                 <img src="{{asset('dist/img/filestypes/file.png')}}" style="width: 40px;"/>
                                            @endif
                                            <span> {{$filename}}</span>
                                       </span>
                              @endif
                                </div>
                            </div>
                        </div>
                      </div>

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
        title: 'Issue Resolution',
        text: "You are about to resolved an issue raised on claim file. Are you sure?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Continue'
        }).then((result) => {
        if (result.isConfirmed) {
            $('#loader').show()
            $.ajax({
                url: "{{url('/issue-review')}}",
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