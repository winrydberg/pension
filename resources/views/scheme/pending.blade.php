@extends('includes.master')


@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h4 class="nk-block-title">Claims Pending Receipt {{$selectedscheme != null ? " | ".$selectedscheme->name : ''}}</h4>
                          <div class="nk-block-des text-soft">
                              <p>On this page, you will find all audited claims pending receipt by scheme admins. Use the search box to filter by Claim ID, Claim description, Created date etc. </p>
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
                        <table class="datatable-init-export nowrap table" data-export-title="Export">
                            <thead>
                                <tr>
                                    <th>Claim ID</th>
                                    <th>Description</th>
                                    <th>Scheme</th>
                                    <th>Company</th>
                                    {{-- <th>Audited By</th> --}}
                                    <th>Created Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($claims as $claim)
                                <tr>
                                    <td>{{$claim->claimid}}</td>
                                    <td>{{$claim->description}}</td>
                                    <td>{{$claim->scheme?->name}}</td>
                                    <td>{{$claim->company?->name}}</td>
                                    {{-- <td>{{$claim->audited_by}}</td> --}}
                                    <td>{{date('d-m-Y H:iA', strtotime($claim->created_at))}}</td>
                                    <td>                                                        
                                        <span class="{{$claim->claim_state != null ? $claim->claim_state?->cssclass: 'badge bg-outline-primary'}}"><em class="icon ni ni-check"></em> <span>{{$claim->claim_state?->name}}</span> </span>
                                    </td>
                                    <td>
                                        @role('system-admin|claim-entry|front-end')
                                        <a href="{{url('request-files?claimid='.$claim->claimid)}}" class="btn btn-round btn-sm btn-dark"><em class="icon ni ni-setting"></em> <span>Upload Request / Additional Files</span></a>
                                        @endrole

                                        <button onclick="receiveClaim({{$claim->id}})" class="btn btn-round btn-sm btn-success"><em class="icon ni ni-thumbs-up"></em> <span>Receive Claim</span></button>
                                       
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
@stop