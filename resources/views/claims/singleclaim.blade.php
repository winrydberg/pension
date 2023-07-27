@extends('includes.master')


@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h4 class="nk-block-title">Claim Details - {{$claim->claimid}}</h4>
                          <div class="nk-block-des text-soft">
                              <p>Find more details about claim with ID {{$claim->claimid}}, including activities, issues on each issues of the claim, etc.</p>
                          </div>
                      </div><!-- .nk-block-head-content -->
                     
                  </div><!-- .nk-block-between -->
              </div><!-- .nk-block-head -->
              <div class="nk-block nk-block-lg">

                @if(Session::has('error'))
                <p class="alert alert-danger">{{Session::get('error')}}</p>
                @endif

                <div class="row">
                    <div class="col-md-5">
                        <div class="card card-bordered">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Claim Activities</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th scope="col">Claim ID</th>
                                        <td>{{$claim->claimid}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Description</th>
                                        <td>{{$claim->description}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Company</th>
                                        <td>{{$claim->company?->name}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Scheme</th>
                                        <td>{{$claim->scheme?->name}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Claim Status</th>
                                        <td>     
                                            <span class="{{$claim->claim_state != null ? $claim->claim_state?->cssclass: 'badge bg-outline-primary'}}">{{$claim->claim_state?->name}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Created At</th>
                                        <td>{{date('d-m-Y H:iA', strtotime($claim->created_at))}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Amount(GHC)</th>
                                        <td>{{$claim->claim_amount}}</td>
                                    </tr>
                                    @if($claim->audited) 
                                    <tr>
                                        <th scope="col">Audited By</th>
                                        <td>{{$claim->audited_by}}</td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <th scope="col">Total Employee</th>
                                        <td>{{$employeeCount}}</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->

                        <div class="card card-bordered ">
                           
                            <div class="card-inner">
                                <a href="{{url('/download/'.$claim->id.'/'.$claim->claimid)}}" class="btn btn-round btn-block btn-md btn-primary" style="margin-top: 5px; margin-bottom: 5px;"><em class="icon ni ni-download"></em><span>Download Claim Files</span></a>
                                <a href="{{url('/customers?claimid='.$claim->id)}}" class="btn btn-round btn-md btn-block btn-success" style="margin-top: 5px; margin-bottom: 5px;"><em class="icon ni ni-user"></em><span>Employees</span></a>
                                <a href="{{url('request-files?claimid='.$claim->claimid)}}" class="btn btn-round btn-md btn-block btn-info" style="margin-top: 5px; margin-bottom: 5px;"><em class="icon ni ni-setting"></em><span>Upload Request / Additional Files</span> </a>
                                @if(Auth::user()->hasRole('claim-entry') && $claim->claim_state_id < 2 )
                                    <a href="{{url('processed-files?claimid='.$claim->claimid)}}" class="btn btn-round btn-md btn-block btn-warning" style="margin-top: 5px; margin-bottom: 5px;"><em class="icon ni ni-setting"></em><span>Upload Processed Files</span> </a>
                                @endif

                                @role('audit')
                                    @if($claim->claim_state_id == 2)
                                    <a href="{{url('audit?claimid='.$claim->claimid)}}" class="btn btn-round btn-md btn-block btn-dark" style="margin-top: 5px; margin-bottom: 5px;"><em class="icon ni ni-setting"></em><span>Audit Claim</span> </a>
                                    @endif
                                @endrole

                                @role('accounting')
                                    @if($claim->claim_state_id == 4 || $claim->claim_state_id == 5  )
                                        <button onclick="receiveClaim({{$claim->id}})" class="btn btn-md btn-round btn-block btn-secondary" style="margin-top: 5px; margin-bottom: 5px;"><em class="icon ni ni-card"></em> <span>Receive Claim</span></button>
                                    @endif

                                    @if($claim->claim_state_id == 6)
                                        <button onclick="transferedToBank({{$claim->id}})" class="btn btn-md btn-block btn-round btn-danger" style="margin-top: 5px; margin-bottom: 5px;"><em class="icon ni ni-menu"></em> <span>Transfered To Bank</span></button>
                                    @endif
                                @endrole
                                @role('system-admin')
                                    <button onclick="deleteClaim({{$claim->id}})" class="btn btn-md btn-block btn-round btn-danger" style="margin-top: 5px; margin-bottom: 5px;"><em class="icon ni ni-trash"></em> <span>Delete Claim</span></button>
                                @endrole

                                
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->

                    <div class="col-lg-7">

                        <div class="card card-bordered">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Claim Files</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <table class="datatable-init-export nowrap table">
                                    <thead>
                                      <tr>
                                        <th scope="col">File Type</th>
                                        <th scope="col">File Name</th>
                                        <th scope="col">Has Issue</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($claim->claim_files as $file)
                                            <tr>
                                                <td>
                                                    @if(in_array(strtolower($file->extension), ['png', 'jpg', 'jpeg']))
                                                        <img src="{{asset('dist/img/filestypes/image.png')}}" style="width: 30px;"/>
                                                    @elseif (strtolower($file->extension) =='pdf')
                                                        <img src="{{asset('dist/img/filestypes/pdf.png')}}" style="width: 30px;"/>
                                                    @elseif (in_array(strtolower($file->extension), ['xls', 'xlsx']))
                                                        <img src="{{asset('dist/img/filestypes/sheets.png')}}" style="width: 30px;"/>
                                                    @elseif (in_array(strtolower($file->extension), ['doc', 'docx']))
                                                        <img src="{{asset('dist/img/filestypes/word.png')}}" style="width: 30px;"/>
                                                    @else
                                                        <img src="{{asset('dist/img/filestypes/file.png')}}" style="width: 30px;"/>
                                                    @endif
                                                </td>
                                                <td>
                                                    <?php
                                                        $dirarray = explode('/', $file->filename);
                                                        $filename = $dirarray[count($dirarray)-1];
                                                        echo $filename;
                                                    ?>
                                                </td>
                                                <?php
                                                    // $showIssuebtn = true;
                                                    $hasIssue = false;
                                                    $fileIssues = $file->issues;
                                                    foreach ($fileIssues as $iss) {
                                                        if($iss->resolved ==false){
                                                            $hasIssue = true;
                                                            break;
                                                        }else{
                                                            $hasIssue = false;
                                                        }
                                                    }
                                                ?>
                                                <td>
                                                    @if($hasIssue==false)
                                                        <p>No</p>
                                                    @else
                                                        <p>Yes</p>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if($hasIssue==false)
                                                        <button onclick="showFileIssueModal('{{$file->id}}', '{{$filename}}')" {{$claim->claim_state_id >= 6 ?'disabled="disabled"': ''}} class="btn btn-sm btn-round btn-warning"><i class="fa fa-info-circle"></i> Report Issue</button>
                                                    @endif
                                                    
                                                    @if($hasIssue == true)
                                                        <a href="{{url('/issue-review?ticket='.$file->unresolved_issue()?->issue_ticket)}}" class="btn btn-sm btn-round btn-primary"><em class="icon ni ni-info"></em> <span>Resolve Issue</span></a>
                                                    @else
                                                    @endif
                                                    {{-- {{$claim->claim_state_id >= 2 ?'disabled="disabled"': ''}} --}}
                                                    <button onclick="deleteClaimFile('{{$file->id}}')" {{$claim->claim_state_id >= 2 ?'disabled="disabled"': ''}}  class="btn btn-round btn-danger btn-sm"><i class="fa fa-trash"></i> Delete File</button>
                                                </td>
                                            </tr>
                                      @endforeach
                                      
                                    </tbody>
                                  </table>
                            </div>
                        </div><!-- .card -->


                        
                    </div><!-- .col -->
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-7">
                        <div class="card card-bordered ">
                            <div class="card-inner">
                                <div class="card-title-group align-start pb-3 g-2">
                                    <div class="card-title">
                                        <h6 class="title">Claim Issues</h6>
                                        <p>Issues reported on claim will appear here.</p>
                                    </div>
                                    <div class="card-tools">
                                        <em class="card-hint icon ni ni-help" data-bs-toggle="tooltip" data-bs-placement="left" title="Revenue of this month"></em>
                                    </div>
                                </div>
                                <div class="card">
                                  <table class="datatable-init-export nowrap table" data-export-title="Export">
                                      <thead>
                                          <tr>
                                              <th>Claim ID</th>
                                              <th>Issue Raised</th>
                                              <th>Affected File</th>
                                              <th>Issue State</th>
                                              <th>Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach($pendingIssues as $issue)
                                          <tr>
                                              <td>{{$issue->claim?->claimid}}</td>
                                              <td>{{$issue->message}}</td>
                                              <?php
                                                      $file = $issue->claim_file?->filename;
                                                      $filename = 'N/A';
                                                      if($filename != null){
                                                          $dirarray = explode('/', $file);
                                                          $filename = $dirarray[count($dirarray)-1];
                                                          
                                                      }
                                                      
                                              ?>
                                              <td>{{$filename}}</td>
                                              <td>
                                                @if($issue->resolved)
                                                    <span class="badge bg-outline-primary">Resolved</span>
                                                    {{-- <p>{{$issue->resolve_message}}</p> --}}
                                                @else
                                                    <span class="badge bg-outline-primary">Not Resolved</span>
                                                @endif
                                              </td>
                                                 
                                              <td>
                                                  <a href="{{url('issue-review?ticket='.$issue->issue_ticket)}}" class="btn btn-round btn-sm btn-info">Review</a>
                                              </td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                                </div>
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->
    
                    <div class="col-md-5">
                        <div class="card card-bordered">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Claim Activities</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner">
                                
                                    <div class="timeline">
                                        <h6 class="timeline-head">oooo</h6>
                                        <ul class="timeline-list">
                                            @foreach ($activities as $activity)
                                            <li class="timeline-item">
                                                <div class="timeline-status bg-primary is-outline"></div>
                                                <div class="timeline-date">{{date('j F, Y', strtotime($activity->created_at))}} <em class="icon ni ni-alarm-alt"></em></div>
                                                <div class="timeline-data">
                                                    <h6 class="timeline-title">{{$activity->description}}</h6>
                                                    <div class="timeline-des">
                                                        <p>BY - <span class="badge rounded-pill bg-primary">{{$activity->causer->firstname.' '.$activity->causer->lastname }}</span></p>
                                                        <span class="time">{{date('H:i A', strtotime($activity->created_at))}}</span>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->
                </div>
              </div>
          </div>
      </div>
  </div>
</div>


<div class="modal fade" tabindex="-1" id="fileIssue">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Report An Issue on Claim File</h5>
            </div>
            <div class="modal-body">
                <form id="fileIssueForm" action="POST">
                    {{csrf_field()}}
                    
                            <div class="form-group" hidden>
                                <label> ID</label>
                                <input class="form-control" readonly name="id" id="id" />
                            </div>
        
                            <div class="form-group">
                                <label>File Name</label>
                                <input class="form-control" readonly name="filename" id="filename" />
                            </div>
        
                            <div class="form-group">
                                <label>Message</label>
                                <textarea class="form-control" rows="5" required id="messagefile"></textarea>
                                <small>Enter a short description of issue on claim file.</small>
                            </div>
                        
                        <button type="submit" class="btn btn-primary">Submit Issue</button>
        
                </form>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text">Report an issue on a claim file</span>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="issue-modal">
    <div class="modal-dialog issue-modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Issue Details</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="issuemessage"></p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
</div>
@stop

@section('scripts')

<!-- Select2 -->
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/libs/datatable-btns.js?ver=3.2.0')}}"></script>
<script>

    var id=0;
    var filename = ''

    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2();
    })


    function showFileIssueModal(id, filename){
        id=id;
        filename = filename;
        $('#filename').val(filename);
        $('#id').val(id);
        $('#fileIssue').modal('show');
    }

    function showIssueModal(message){
        $('#issuemessage').html(message);
        $('#issue-modal').modal('show');
    }
</script>

<script>
function receiveClaim (claimid) {
    Swal.fire({
        title: 'Receive Claim Now?',
        text: "Are your sure? Action cannot be undone!!!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Mark as Received!'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{url('/receive-claim')}}",
                method: "POST",
                data: {claimid: claimid, _token: "{{Session::token()}}"},
                success: function(response){
                    if(response.status == 'success'){
                        Swal.fire(
                        'Success',
                         response.message,
                        'success'
                        ).then(()=> {
                            window.location.reload()
                        })
                    }else{
                       Swal.fire(
                        'Error!!!',
                         response.message,
                        'error'
                        )
                    }
                },
                error: function(error){
                   Swal.fire(
                    'Error!!!',
                    'Oops, unable to receive claim. please try again',
                    'error'
                   ) 
                }
            })
        }
        })
}




function deleteClaimFile (fileid) {
    Swal.fire({
        title: 'Deleting Claim File',
        text: "Are your sure? Action cannot be undone!!!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{url('/delete-single-claim-file')}}",
                method: "POST",
                data: {id: fileid, _token: "{{Session::token()}}"},
                success: function(response){
                    if(response.status == 'success'){
                        Swal.fire(
                        'Success',
                         response.message,
                        'success'
                        ).then(()=> {
                            window.location.reload()
                        })
                    }else{
                       Swal.fire(
                        'Error!!!',
                         response.message,
                        'error'
                        )
                    }
                },
                error: function(error){
                   Swal.fire(
                    'Error!!!',
                    'Oops, unable to delete file. Please try again later',
                    'error'
                   ) 
                }
            })
        }
        })
}


function transferedToBank (claimid) {
    Swal.fire({
        title: 'Transfered To bank',
        text: "Are your sure? Action cannot be undone!!!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Payment Transfered To Bank'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{url('/transfer-to-bank')}}",
                method: "POST",
                data: {claimid: claimid, _token: "{{Session::token()}}"},
                success: function(response){
                    if(response.status == 'success'){
                        Swal.fire(
                        'Success',
                         response.message,
                        'success'
                        ).then(()=> {
                            window.location.reload()
                        })
                    }else{
                       Swal.fire(
                        'Error!!!',
                         response.message,
                        'error'
                        )
                    }
                },
                error: function(error){
                   Swal.fire(
                    'Error!!!',
                    'Oops, unable to receive claim. please try again',
                    'error'
                   ) 
                }
            })
        }
        })
}
</script>


<script>
$('#fileIssueForm').submit(function(e) {
    e.preventDefault();
    var id = $('#id').val();
    var message = $('#messagefile').val();
    $.ajax({
        url: "{{url('/report-issue-on-file')}}",
        method: "POST",
        data: {
            id: id,
            message: message,
            _token: "{{Session::token()}}"
        },
        success: function(response) {
            $('#fileIssueForm').trigger('reset')
            $('#fileIssue').modal('hide');
            // alert(JSON.stringify(response));
            if (response.status == 'success') {

                Swal.fire(
                        'Success',
                         response.message,
                        'success'
                        ).then(()=> {
                            window.location.reload()
                        })
            } else {
              
                 Swal.fire(
                        'Error!!!',
                         response.message,
                        'error'
                        )
            }
        },
        error: function(error) {
        
             Swal.fire(
                        'Error!!!',
                         'Oops something went wrong. Please try again',
                        'error'
            )
        }
    })
})
</script>
<script>
    function deleteClaim(id) {
        Swal.fire({
            title: "Delete Claim Now?",
            text: "Are your sure? Action cannot be undone!!!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Delete",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{url('/delete-claim')}}",
                    method: "POST",
                    data: { id: id, _token: "{{Session::token()}}" },
                    success: function (response) {
                        if (response.status == "success") {
                            Swal.fire(
                                "Success",
                                response.message,
                                "success"
                            ).then(() => {
                                window.location.href="{{url('/dashboard')}}";
                            });
                        } else {
                            Swal.fire("Error!!!", response.message, "error");
                        }
                    },
                    error: function (error) {
                        Swal.fire(
                            "Error!!!",
                            "Oops, unable to delete claim. please try again",
                            "error"
                        );
                    },
                });
            }
        });
    }
</script>
@stop