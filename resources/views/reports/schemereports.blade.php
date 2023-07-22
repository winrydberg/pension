@extends('includes.master')


@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h4 class="nk-block-title ">Generate Reports</h4>
                          <div class="nk-block-des text-soft">
                              <p>Generate reports by scheme</p>
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
                                          <h6 class="title">Generate Scheme Reports</h6>
                                      </div>
                                      
                                  </div>

                                  <div class="card">
                                    <form action="#"  id="searchClaim" method="GET">
                                        {{csrf_field()}}
                                        <div class="row g-gs">
                                            <div class="row" style="margin-top: 30px;">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fva-message">Start Date</label>
                                                        <div class="form-control-wrap">
                                                            <input class="form-control" type="date" value="{{request()->get('startdate')}}" required name="startdate"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fva-message">End Date</label>
                                                        <div class="form-control-wrap">
                                                            <input class="form-control" value="{{request()->get('enddate')}}" type="date" required name="enddate"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fva-message">Scheme</label>
                                                        <div class="form-control-wrap">
                                                            <select class="form-control select2" name="scheme" required>
                                                                <option value="">Select an option</option>
                                                                @foreach($schemes as $scheme)
                                                                     <option value="{{$scheme->id}}" {{request()->get('scheme') ==  $scheme->id? 'selected="selected"' : ''}}>{{$scheme->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> <em id="loader" class="fa fa-spinner fa-spin"></em> <span>Generate Report</span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                  </div>
                                 
                              </div>
                          </div><!-- .card -->
                      </div><!-- .col -->
                  </div><!-- .row -->
              </div>
              <div class="nk-block">
                
                  @if(isset($claims))

                  
                  <div class="row g-gs" >
                    <div class="col-md-12">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                @if(count($claims) > 0)

                                <p><strong>Company Name: </strong> {{$selscheme->name}}</p>
                                <p><strong>Total Amount(GHC): </strong> {{$total_amount}}</p>
                                
                                <hr />

                                <a href="{{url('/excel-reports?scheme='.request()->query('scheme').'&startdate='.request()->query('startdate').'&enddate='.request()->query('enddate'))}}" class="btn btn-success btn-md btn-round"><em class="icon ni ni-download"></em> <span>Export To Excel</span></a>

                                <hr />
                                <table class="datatable-init-export nowrap table" data-export-title="Export">
                                    <thead>
                                        <tr>
                                            <th>Month, Year</th>
                                            <th>Company</th>
                                            <th>Amount (GHC)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($claims as $claim)
                                            <tr>
                                                <td>{{$claim->months}}</td>
                                                <td>{{$selscheme->name}}</td>
                                                <td>{{$claim->sums}}</td>
                                                <td>
                                                    <a href="{{url('/reports-breakdown?month='.$claim->months.'&company='.$selscheme->id)}}" class="btn btn-primary btn-round btn-sm"><em class="icon ni ni-info"></em> <span>Breakdown</span></a>
                                                    {{-- <a href="#" class="btn btn-success btn-xs"><i class="fa fa-user"></i>Breakdown By Employee</a> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                    <p class="alert alert-danger">No claims found for selected dates and scheme</p>
                                @endif
                            </div>
                        </div><!-- .card-preview -->
                    </div>
                  </div>
                 
                  @endif

     
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
      $('.select2').select2();
    })
</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- xlsx js -->
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
 --}}


<script>
  $(document).ready(function(){
     $('#loader').hide()
    
  })

</script>

@stop