@extends('includes.master')


@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h4 class="nk-block-title">Un-Processed Claims</h4>
                          <div class="nk-block-des text-soft">
                            <p>On this page, you will find all invalid claims. You can use the search to filter by description, claim id etc.</p>
                          </div>
                      </div><!-- .nk-block-head-content -->
                     
                  </div><!-- .nk-block-between -->
              </div><!-- .nk-block-head -->
              <div class="nk-block nk-block-lg">
                
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <table class="datatable-init-export nowrap table" data-export-title="Export">
                            <thead>
                                <tr>
                                    <th>Claim ID</th>
                                    <th>Description</th>
                                    <th>Scheme</th>
                                    <th>Company</th>
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
                                    <td>{{date('d-m-Y H:iA', strtotime($claim->created_at))}}</td>
                                    <td>
                                        <span class="{{$claim->claim_state != null ? $claim->claim_state?->cssclass: 'badge bg-outline-danger'}}">{{$claim->claim_state?->name}}</span>
                                    </td>
                                    <td>
                                        <a href="{{url('request-files?claimid='.$claim->claimid)}}" class="btn btn-round btn-sm btn-dark"><em class="icon ni ni-setting"></em> <span>Upload Request / Additional Files</span></a>
                                        <a href="{{url('processed-files?claimid='.$claim->claimid)}}" class="btn btn-round btn-sm btn-primary"><em class="icon ni ni-upload"></em> <span> Upload Processed Files </span></a>
                                        <button onclick="deleteClaim('{{$claim->id}}')" class="btn btn-round btn-sm btn-danger"><em class="icon ni ni-trash"></em> <span>Delete Claim</span></button>
                                        <a href="{{url('claim-details?claimid='.$claim->claimid)}}" class="btn btn-round btn-sm btn-info"><em class="icon ni ni-eye"></em> <span>Details</span></a>
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
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/libs/datatable-btns.js?ver=3.2.0')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function () {
      $('.select2').select2();
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
                                window.location.reload();
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