@extends('includes.master')


@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h4 class="nk-block-title">Received Claims Pending Payment</h4>
                          <div class="nk-block-des text-soft">
                              <p>On this page, you will find all received claims pending payment by scheme admins. Use the search box to filter by Claim ID, Claim description, Created date etc. </p>
                          </div>
                      </div><!-- .nk-block-head-content -->
                     
                  </div><!-- .nk-block-between -->
              </div><!-- .nk-block-head -->
              <div class="nk-block nk-block-lg">
                {{-- <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title">Data Table with Export</h4>
                        <div class="nk-block-des">
                            <p>To intialize datatable with export buttons, use <code class="code-class">.datatable-init-export</code> with <code>table</code> element. <br> <strong class="text-dark">Please Note</strong> By default export libraries is not added globally, so please include <code class="code-class">"js/libs/datatable-btns.js"</code> into your page to active export buttons.</p>
                        </div>
                    </div>
                </div> --}}
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <div class="col-md-12" id="senttobancon" hidden>
                            <button class="btn btn-md btn-round btn-danger pull-right" onclick="updateToSendtoBank()"><em class="icon ni ni-send"></em> <span>Sent To Bank</span></button>
                        </div>
                        <table class="datatable-init-export nowrap table" data-export-title="Export" id="rcvdTable">
                            <thead>
                                <tr>
                                    <th class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="chk">
                                            <label class="custom-control-label" for="chk"></label>
                                        </div>
                                    </th>
                                    <th>Claim ID</th>
                                    <th>Description</th>
                                    <th>Scheme</th>
                                    <th>Company</th>
                                    <th>Audited By</th>
                                    <th>Created Date</th>
                                    <th>Claim State</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($claims as $claim)
                                <tr>
                                    <td class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="{{$claim->claimid.'__'.$claim->id}}">
                                            <label class="custom-control-label" for="{{$claim->claimid.'__'.$claim->id}}"></label>
                                        </div>
                                    </td>
                                    <td>{{$claim->claimid}}</td>
                                    <td>{{$claim->description}}</td>
                                    <td>{{$claim->scheme?->name}}</td>
                                    <td>{{$claim->company?->name}}</td>
                                    <td>{{$claim->audited_by}}</td>
                                    <td>{{date('d-m-Y H:iA', strtotime($claim->created_at))}}</td>
                                    <td>                                                        
                                        <span class="{{$claim->claim_state != null ? $claim->claim_state?->cssclass: 'badge bg-outline-primary'}}"><em class="icon ni ni-check-circle"></em> <span>{{$claim->claim_state?->name}}</span></span>
                                    </td>
                                    <td>
                                        @role('system-admin|claim-entry|front-end')
                                        <a href="{{url('request-files?claimid='.$claim->claimid)}}" class="btn btn-round btn-sm btn-dark"><em class="icon ni ni-setting"></em> <span>Upload Request / Additional Files</span></a>
                                        @endrole

                                        {{-- <button onclick="receiveClaim({{$claim->id}})" class="btn btn-round btn-sm btn-success"><em class="icon ni ni-thumbs-up"></em> <span>Receive Claim</span></button> --}}
                                       
                                        <a href="{{url('claim-details?claimid='.$claim->claimid)}}" class="btn btn-round btn-sm btn-info"><em class="icon ni ni-eye"></em> <span>Claim Details</span></a>


                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- .card-preview -->
            </div>
          </div>
      </div>
  </div>
</div>

<div class="modal fade modal-lg" tabindex="-1" id="sentTobank">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Payment Sent To Bank</h5>
            </div>
            <div class="modal-body">
                <form id="sentTobankForm" action="POST">
                    {{csrf_field()}}
                            <div class="form-group" style="display:none;">
                                <label> ID</label>
                                <input class="form-control" readonly name="ids" id="ids" />
                            </div>
                            <div class="form-group">
                                <label> Claim IDs</label>
                                <input class="form-control" readonly  name="claimid" id="claimid" />
                            </div>
                            <div class="form-group">
                                <label for="firstname">Select Files</label>
                                <input id="input-id" name="schemefiles[]" multiple  type="file" >   
                            </div>
        
                        <button type="submit" class="btn btn-primary">Send to Bank</button>
        
                </form>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text">Use this form to save details sent to bank</span>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')

<!-- Select2 -->
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/libs/datatable-btns.js?ver=3.2.0')}}"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">

<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/plugins/buffer.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/plugins/filetype.min.js" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/fileinput.min.js"></script>
<script>
    $(function () {
      $('.select2').select2();
    })
    $(document).ready(function() {
        $("#input-id").fileinput({'previewFileType': 'any', 'showUpload': false, 'maxFileCount': 0});
    });
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
</script>

<script>
var selected = new Array();
var claim_ids = new Array();
$("input:checkbox").click(function ()
 {
     if($(this).is(':checked'))
     {  
        claim_ids.push($(this).attr('id').split('__')[0]);
        selected.push($(this).attr('id').split('__')[1]);
        //  $(this).parents("tr:first").data('prevColor', $(this).parents("tr:first").css('background-color'));
        //  $(this).parents("tr:first").css('background-color', 'yellow');
     }
     else
     {
        const index = selected.indexOf($(this).attr('id').split('__')[1]);
        if (index > -1) { // only splice array when item is found
            selected.splice(index, 1); // 2nd parameter means remove one item only
            claim_ids.splice(index, 1); // 2nd parameter means remove one item only
        }
        //  $(this).parents("tr:first").css('background-color', $(this).parents("tr:first").data('prevColor'));
     }

     if(selected.length > 0){
        $('#senttobancon').removeAttr('hidden');
     }else{
        $('#senttobancon').attr('hidden', 'hidden');
     }
 });



function updateToSendtoBank(){
    $('#ids').val(selected.join(", "));
    $('#claimid').val(claim_ids.join(", "));
    $('#sentTobank').modal('show');
}

$('#sentTobankForm').submit(function(event){
    event.preventDefault();
    var formData = new FormData(this);
    Swal.fire({
        title: 'Sent To Bank',
        text: "Are your sure?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Proceed'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{url('/sent-to-bank')}}",
                method: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
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
                    'Oops, something went wrong. please try again',
                    'error'
                   ) 
                }
            })
        }
        })
})
</script>



@stop