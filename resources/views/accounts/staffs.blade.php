@extends('includes.master')


@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h4 class="nk-block-title">All Staff</h4>
                          <div class="nk-block-des text-soft">
                              <p>Manage staff and access/permissions on this page</p>
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
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                    <th>Status</th>
                                    <th>Department</th>
                                    <th>Assigned Scheme(s)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $s)
                                <tr>
                                    <td>{{$s->firstname.' '.$s->lastname}}</td>
                                    <td>{{$s->email}}</td>
                                    <td>{{$s->phoneno}}</td>
                                    <td> 
                                      @if($s->is_active)
                                        <span class="badge rounded-pill bg-success">Active</span>
                                      @else
                                        <span class="badge rounded-pill bg-danger">Not Active</span>
                                      @endif
                                    </td>
                                    <td>{{$s->department!=null?$s->department->name:''}}</td>
                                    <td>
                                        <?php
                                        $permissions = $s->permissions;
                                      ?>
                                      @if(count($permissions) <= 0)
                                          <p>Not A Scheme Admin</p>
                                      @else
                                          @foreach ($permissions as $p)
                                            <span class="badge rounded-pill bg-primary">{{$p->name}}</span>
                                          @endforeach
                                      @endif</td>
                                    <td>
                                        @role('system-admin')
                                        <a href="{{url('/edit-staff?staffid='.$s->id)}}" class="btn btn-info btn-round btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                        @if($s->is_active)
                                          <button onclick="updateStaffAccountState('{{$s->id}}','0')" class="btn btn-danger btn-round btn-sm">Deactivate Account</button>
                                        @else
                                          <button onclick="updateStaffAccountState('{{$s->id}}','1')" class="btn btn-success btn-round btn-sm">Activate Account</button>
                                        @endif
                                      @endrole
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2();
    })
</script>


  <script>
    function updateStaffAccountState(id, state){
      var title = 'Deactivating Account';
      var infomess = "Are you sure you want to deactivate this account?";
      if(state ==1){
        var title = 'Account Activation';
        var infomess = "Are you sure you want to activate this account?"
      }else{
        var title = 'Account Deactivation';
        var infomess = "Are you sure you want to deactivate this account?"
      }
      Swal.fire({
        title: title,
        text: infomess,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Continue'
        }).then((result) => {
        if (result.isConfirmed) {
            $('#loader').show()
            $.ajax({
                url: "{{url('/update-staff-account-state')}}",
                method: "POST",
                data: {id: id, state, state, _token: "{{Session::token()}}"},
                success: function(response){
                    if(response.status == 'success'){
                      Swal.fire(
                        'Success!!!',
                        response.message,
                        'success'
                      ).then(() => {
                        window.location.reload();
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
                  $('#loader').hide()
                   Swal.fire(
                    'Error!!!',
                    'Oops, Something went wrong. Please try again later',
                    'error'
                   ) 
                }
            })
        }
        })
    }
  </script>
@stop