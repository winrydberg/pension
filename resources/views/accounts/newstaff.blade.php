@extends('includes.master')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
@stop

@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h4 class="nk-block-title">New Staff</h4>
                          <div class="nk-block-des text-soft">
                              <p>Add new staff to PCM platform</p>
                          </div>
                      </div><!-- .nk-block-head-content -->
                      
                  </div><!-- .nk-block-between -->
              </div><!-- .nk-block-head -->
              <div class="nk-block">
                  <div class="row g-gs">
                      
                      <div class="col-xxl-4">
                          <div class="card card-bordered card-full">
                              <div class="card-inner d-flex flex-column h-100">
                                  <div class="card-title-group mb-3">
                                      <div class="card-title me-1">
                                          <h6 class="title">Staff Information</h6>
                                      </div>
                                  </div>
                                  
                                    <div class="">
                                        <form action="#" class="form-validate" id="newStaff">
                                            {{csrf_field()}}
                                            <div class="row g-gs">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fv-full-name">First Name</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="firstname" class="form-control" id="firstname" name="firstname" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="form-label" for="fv-full-name">Last Name</label>
                                                      <div class="form-control-wrap">
                                                          <input type="text" name="lastname" class="form-control" id="lastname" name="lastname" required>
                                                      </div>
                                                  </div>
                                              </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fv-email">Email address</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni ni-mail"></em>
                                                            </div>
                                                            <input type="text" name="email" class="form-control" id="email" name="email" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fv-phone">Phone</label>
                                                        <div class="form-control-wrap">
                                                            <div class="input-group">
                                                                <input type="text" name="phoneno" class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fv-subject">Password</label>
                                                        <div class="form-control-wrap">
                                                            <input type="password" class="form-control" name="password" id="password" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                  <div class="form-group">
                                                      <label class="form-label" for="fv-subject">Confirm Password</label>
                                                      <div class="form-control-wrap">
                                                          <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" required>
                                                      </div>
                                                  </div>
                                              </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fv-topics">Department</label>
                                                        <div class="form-control-wrap ">
                                                            <select class="select2 form-control" id="department" name="department_id" data-placeholder="Select a department" required style="width: 100%;">
                                                                <option label="" value="">Select an option</option>
                                                                @foreach ($departments as $d)
                                                                  <option value="{{$d->id}}">{{$d->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fv-topics">Roles</label>
                                                        <div class="form-control-wrap ">
                                                            <select class="form-control select2" id="role" name="roles[]"  multiple="multiple" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                                                <option label="" value="">Select an option</option>
                                                                    @foreach($roles as $role)
                                                                      <option value="{{$role->id}}">{{$role->name}}</option>
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                              
                                                {{-- <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Roles</label>
                                                        <ul class="custom-control-group g-3 align-center">
                                                            @foreach($roles as $role)
                                                            <li>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="{{$role->name}}" id="role{{$role->id}}">
                                                                    <label class="custom-control-label" for="role{{$role->id}}">{{$role->name}}</label>
                                                                </div>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div> --}}

                                                <div class="col-md-6" id="schemeassignment" hidden>
                                                  <div class="form-group">
                                                      <label class="form-label" for="fv-topics">Schemes</label>
                                                      <div class="form-control-wrap ">
                                                          <select class="form-control select2" id="permissions" name="permissions[]"  multiple="multiple" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                                              <option label="" value="">Select an option</option>
                                                               @foreach ($permissions as $permission)
                                                                    <option value="{{$permission->id}}">{{$permission->name}}</option>
                                                                @endforeach
                                                          </select>
                                                      </div>
                                                  </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-md btn-primary"><em class="fa fa-plus"></em> Staff</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                              </div>
                          </div>
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
      $('.select2').select2()

      $('#role4').on('change', function(event){
        if(this.checked) {
          $('#schemeassignment').removeAttr('hidden');
        }else{
          $('#schemeassignment').attr("hidden",true);
        }
      })

      
    })

    $( document ).ready(function() {

        $('#role').on('change', function(event){
        var values = $('#role').val();
        var last = values[values.length -1 ];
        if(values.includes('4')){
            $('#schemeassignment').removeAttr('hidden');
        }else{
            $('#schemeassignment').attr("hidden",true);;
        }
    })



//       $('#department').on('change', function(){
     
//      var selected = $(this).val();
//      // alert(selected)
//      switch(selected){
//        case '1':
//         $('#role1').prop('checked', true);
//         $('#role2').prop('checked', false);
//         $('#role3').prop('checked', false);
//         $('#role4').prop('checked', false);
//         $('#role5').prop('checked', false);
//         $('#schemeassignment').attr("hidden",true);
//          break;
//        case '2':
//         $('#role1').prop('checked', false);
//         $('#role2').prop('checked', true);
//         $('#role3').prop('checked', false);
//         $('#role4').prop('checked', false);
//         $('#role5').prop('checked', false);
//         $('#schemeassignment').attr("hidden",true);
//          break;
//        case '3': 
//        $('#role1').prop('checked', false);
//         $('#role2').prop('checked', false);
//         $('#role3').prop('checked', true);
//         $('#role4').prop('checked', false);
//         $('#role5').prop('checked', false);
//         $('#schemeassignment').attr("hidden",true);
//          break;
//        case '4': 
//         $('#role1').prop('checked', false);
//         $('#role2').prop('checked', false);
//         $('#role3').prop('checked', false);
//         $('#role4').prop('checked', true);
//         $('#role5').prop('checked', false);
//         $('#schemeassignment').removeAttr('hidden');
//          break;
//        case '5': 
//         $('#role1').prop('checked', false);
//         $('#role2').prop('checked', false);
//         $('#role3').prop('checked', false);
//         $('#role4').prop('checked', false);
//         $('#role5').prop('checked', true);
//         $('#schemeassignment').attr("hidden",true);
//         break
//        default:
//          break;
//      }
//    })
    });
</script>

<script>

    var cloneclount =0;

    $(document).ready(function(){
       $('#loader').hide()
       $('#newStaff').submit(function(event) {
        event.preventDefault();
  
        Swal.fire({
          title: 'Add a New Staff',
          text: "You are about to add new staff",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Continue'
          }).then((result) => {
          if (result.isConfirmed) {
              $('#loader').show()
              $.ajax({
                  url: "{{url('/new-staff')}}",
                  method: "POST",
                  data: $('#newStaff').serialize(),
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
                      'Oops, something went wrong. Please try again',
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


