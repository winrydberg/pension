@extends('includes.master')


@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h4 class="nk-block-title ">Search Claim</h4>
                          <div class="nk-block-des text-soft">
                              <p>Search claim using Claim ID, Customer name, Company, Scheme etc.</p>
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
                                          <h6 class="title">Search Claim</h6>
                                      </div>
                                      
                                  </div>

                                  <div class="card">
                                    <form action="#"  id="searchClaim" method="GET">
                                        {{csrf_field()}}
                                        <div class="row g-gs">
                                            <div class="row" style="margin-top: 30px;">
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fva-message">Search Term</label>
                                                        <div class="form-control-wrap">
                                                            <input class="form-control" value="{{request()->get('term')}}" required name="term"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label class="form-label" for="fva-message">Search By</label>
                                                        <div class="form-control-wrap">
                                                            <select class="form-control" name="searchby" required>
                                                                <option value="">Select an option</option>
                                                                <option value="1" {{request()->get('searchby') == 1 ? 'selected="selected"' : ''}}>Claim ID</option>
                                                                <option value="2" {{request()->get('searchby') == 2 ? 'selected="selected"' : ''}}>Customer Name</option>
                                                                <option value="3" {{request()->get('searchby') == 3 ? 'selected="selected"' : ''}}>Company Name</option>
                                                                <option value="4" {{request()->get('searchby') == 4 ? 'selected="selected"' : ''}}>Scheme Name</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> <em id="loader" class="fa fa-spinner fa-spin"></em> <span>Search Claim</span></button>
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
                                <table class="datatable-init-export nowrap table" data-export-title="Export">
                                    <thead>
                                        <tr>
                                            <th>Claim ID</th>
                                            <th>Description</th>
                                            <th>Scheme</th>
                                            <th>Company</th>
                                            <th>Created Date</th>
                                            <th>Reason</th>
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
                                                <td>{{$claim->invalid_reason}}</td>
                                                <td>
                                                    <a href="{{url('request-files?claimid='.$claim->claimid)}}" class="btn btn-round btn-sm btn-dark">Upload Request / Additional Files</a>
                                                    <a href="{{url('claim-details?claimid='.$claim->claimid)}}" class="btn btn-round btn-sm btn-info">Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card-preview -->
                    </div>
                  </div>
                  @endif

                  @if(isset($customers))
                  <div class="row g-gs" >
                    <div class="col-md-12">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table class="datatable-init-export nowrap table" data-export-title="Export">
                                    <thead>
                                        <tr>
                                            <th>Claim ID</th>
                                            <th>Customer Name</th>
                                            <th>Scheme</th>
                                            <th>Company</th>
                                            <th>Status</th>
                                            <th>Created Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                            
                                            @foreach ($customer->claims as $claim)
                                                <tr>
                                                        <td>
                                                            {{$claim->claimid}}
                                                        </td>
                                                        <td>{{$customer->name}}</td>
                                                        <td>{{$claim->scheme->name}} - {{$claim->scheme->tiertype}}</td>
                                                        <td>{{$claim->company->name}}</td>
                                                        <td>
                                                            <span class="{{$claim->claim_state != null ? $claim->claim_state?->cssclass: 'badge bg-outline-primary'}}">{{$claim->claim_state?->name}}</span>
                                                        </td>
                                                        <td>{{date('Y-m-d H:i A',strtotime($claim->created_at))}}</td>
                                                        <td>
                                                            <a href="{{url('claim-details?claimid='.$claim->claimid)}}" class="btn btn-round btn-sm btn-info"><em class="icon ni ni-eye"></em> <span>Details</span></a>
                                                        </td>
                                                </tr>
                                            @endforeach
                                
                                        @endforeach
                                    </tbody>
                                </table>
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