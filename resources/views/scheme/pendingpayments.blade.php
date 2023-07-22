@extends('includes.master')


@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h4 class="nk-block-title">Pending Payment</h4>
                          <div class="nk-block-des text-soft">
                              <p>On this page, you will find received claims pending payment. If payment have been submitted to bank, please indicate that  here.</p>
                          </div>
                      </div>
                     
                  </div>
              </div>
              <div class="nk-block nk-block-lg">   
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <table class="datatable-init-export nowrap table" data-export-title="Export">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Policy No</th>
                                    <th>Claim ID</th>
                                    <th>Company</th>
                                    <th>Amount</th>
                                    {{-- <th>Amount</th> --}}
                                    <th>Bank</th>
                                    <th>Acc. No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $c)
                                <tr>
                                        
                                        <td>
                                            {{$c->name}}
                                        </td>
                                        <td>{{$c->policy_number}}</td>
                                        <td>{{$c->claimid}}</td>
                                        <td>{{$c->company}}</td>
                                        <td>{{$c->amount}}</td>
                                        {{-- <td>{{$c->name}}</td> --}}
                                        <td>{{$c->bank}}</td>
                                        <td>{{$c->accnumber}}</td>
                                        <td>
                                            <button onclick="showSendToBankModal('{{$c->id}}', '{{$c->name}}', '{{$c->amount}}')" class="btn btn-round btn-sm btn-danger"><em class="icon ni ni-send"></em> <span>Send Payment To Bank</span></button>
                                        </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

               
            </div>
          </div>
      </div>
  </div>
</div>



<div class="modal fade" tabindex="-1" id="sentTobank">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Send Payment To Bank</h5>
            </div>
            <div class="modal-body">
                <form id="sentTobankForm" action="POST">
                    {{csrf_field()}}
                    
                            <div class="form-group" hidden>
                                <label> ID</label>
                                <input class="form-control" readonly name="id" id="id" />
                            </div>
                            <div class="form-group">
                                <label> Employee Name</label>
                                <input class="form-control" disabled  name="empname" id="empname" />
                            </div>

                            <div class="form-group">
                                <label> Amount Due</label>
                                <input class="form-control" disabled  name="amount" id="amount" />
                            </div>
                            <div class="form-group">
                                <label>File Name</label>
                                <select class="form-control" name="bank" required>
                                    <option value="">Select an option</option>
                                    @foreach($banks as $bank)
                                        <option value="{{$bank->id}}">{{$bank->name}}</option>
                                    @endforeach
                                </select>
                            </div>
        
                        <button type="submit" class="btn btn-primary">Send to Bank</button>
        
                </form>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text">Report an issue on a claim file</span>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')

<!-- Select2 -->
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/libs/datatable-btns.js?ver=3.2.0')}}"></script>
<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2();
    })

    function showSendToBankModal(id, empname, amount){
        $('#id').val(id);
        $('#amount').val(amount);
        $('#empname').val(empname);
        $('#sentTobank').modal('show');
    }


$('#sentTobankForm').submit(function(event){
    event.preventDefault();

    Swal.fire({
        title: 'Sending To Bank',
        text: "Are your sure?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Proceed'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{url('/send-to-bank')}}",
                method: "POST",
                data: $('#sentTobankForm').serialize(),
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