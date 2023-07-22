@extends('includes.master')


@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h4 class="nk-block-title">My Assigned Schemes</h4>
                          <div class="nk-block-des text-soft">
                              <p>Below are claims assigned to you.</p>
                          </div>
                      </div><!-- .nk-block-head-content -->
                     
                  </div><!-- .nk-block-between -->
              </div><!-- .nk-block-head -->
              <div class="nk-block">
                  <div class="row g-gs">
                    <div class="row g-gs">
                        @foreach($schemes as $scheme)
                            <div class="col-sm-6 col-lg-4 col-xxl-3">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner">
                                        <div class="project">
                                            <div class="project-head">
                                                <a href="#" class="project-title">
                                                    <div class="user-avatar sq bg-purple"><span>{{substr(explode(' ', $scheme->name." ")[0], 0, 1);}}{{substr(explode(' ', $scheme->name." ")[1], 0, 1);}}</span></div>
                                                    <div class="project-info">
                                                        <h6 class="title">{{$scheme->name}}</h6>
                                                        <span class="sub-text">{{$scheme->tiertype}}</span>
                                                    </div>
                                                </a>
                                                {{-- <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger mt-n1 me-n1" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="html/apps-kanban.html"><em class="icon ni ni-eye"></em><span>View Project</span></a></li>
                                                            <li><a href="#"><em class="icon ni ni-edit"></em><span>Edit Project</span></a></li>
                                                            <li><a href="#"><em class="icon ni ni-check-round-cut"></em><span>Mark As Done</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div> --}}
                                            </div>
                                            {{-- <div class="project-details">
                                                <p>Design and develop the DashLite template for Envato Marketplace.</p>
                                            </div> --}}
                                            <div class="project-progress">
                                                {{-- <div class="project-progress-details">
                                                    <div class="project-progress-task"><em class="icon ni ni-check-round-cut"></em><span>3 Tasks</span></div>
                                                    <div class="project-progress-percent">93.5%</div>
                                                </div> --}}
                                                <div class="progress progress-pill progress-md bg-light">
                                                    <div class="progress-bar" data-progress="100"></div>
                                                </div>
                                            </div>
                                            <div class="project-meta">
                                                <ul class="project-users g-1">
                                                    <li>
                                                        @if($scheme?->receipt_count() > 0)
                                                            <div class="user-avatar sm bg-danger" title="No Claim Pending Receipt"><span>{{$scheme?->receipt_count()}}</span></div>
                                                        @else
                                                            <div class="user-avatar sm bg-success" title="No Claim Pending Receipt"><span>{{$scheme?->receipt_count()}}</span></div>
                                                        @endif
                                                    </li>
                                                </ul>
                                                <a href="{{url('/pending-receipt?schemeid='.$scheme->id)}}" class="badge badge-dim bg-warning"><em class="icon ni ni-link"></em><span>View Claims</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
            
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
<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2();
    })
</script>

<script>

    var cloneclount =0;

    $(document).ready(function(){
       $('#loader').hide()
       $('#newCompany').submit(function(event) {
        event.preventDefault();
  
        Swal.fire({
          title: 'Add a New Company',
          text: "You are about to add new company",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Continue'
          }).then((result) => {
          if (result.isConfirmed) {
              $('#loader').show()
              $.ajax({
                  url: "{{url('/new-company')}}",
                  method: "POST",
                  data: $('#newCompany').serialize(),
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
                      'Oops, unable to add company. Please try again',
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