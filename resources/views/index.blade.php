@extends('includes.master')

@section('styles')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@stop

@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h3 class="nk-block-title page-title">Dashboard</h3>
                          <div class="nk-block-des text-soft">
                              <p>Welcome back to your PCM Platform</p>
                          </div>
                      </div><!-- .nk-block-head-content -->
                      <div class="nk-block-head-content">
                          <div class="toggle-wrap nk-block-tools-toggle">
                              <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                              <div class="toggle-expand-content" data-content="pageMenu">
                                  <ul class="nk-block-tools g-3">
                                      {{-- <li>
                                          <div class="dropdown">
                                              <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-calender-date"></em><span><span class="d-none d-md-inline">Last</span> 30 Days</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                              <div class="dropdown-menu dropdown-menu-end">
                                                  <ul class="link-list-opt no-bdr">
                                                      <li><a href="#"><span>Last 30 Days</span></a></li>
                                                      <li><a href="#"><span>Last 6 Months</span></a></li>
                                                      <li><a href="#"><span>Last 1 Years</span></a></li>
                                                  </ul>
                                              </div>
                                          </div>
                                      </li> --}}
                                      @role('system-admin|claim-entry|front-desk')
                                        <li class="nk-block-tools-opt"><a href="{{url('new-claim')}}" class="btn btn-primary"><i class="fa fa-plus-circle"></i><span> New Claim</span></a></li>
                                      @endrole
                                  </ul>
                              </div>
                          </div>
                      </div><!-- .nk-block-head-content -->
                  </div><!-- .nk-block-between -->
              </div><!-- .nk-block-head -->
              <div class="nk-block">
                  <div class="row g-gs">
                      <div class="col-md-3">
                          <div class="card card-bordered card-full">
                              <div class="card-inner">
                                  <div class="card-title-group align-start mb-0">
                                      <div class="card-title">
                                          <strong>Pending Audit</strong>
                                      </div>
                                  </div>
                                  <div class="card-amount">
                                      <span class="amount"> {{$pendingAudit}} </span>
                                      {{-- <span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>1.93%</span> --}}
                                  </div>
                                  {{-- <span> --}}
                                    {{-- <a href="#" class="badge badge-dim bg-warning"><em class="icon ni ni-link"></em><span>View Claims</span></a> --}}
                                    @hasanyrole('system-admin|audit')
                                        <a href="{{url('/pending-audit')}}" class="btn btn-dim btn-xs btn-round btn-outline-primary" ><em class="icon ni ni-link"></em> <span>View Claims</span></a>
                                    @else
                                    <a href="#" style="pointer-events: none !important; cursor: default;" class="btn btn-dim btn-xs btn-round btn-outline-primary" ><em class="icon ni ni-link"></em> <span>View Claims</span></a>
                                    @endhasanyrole
                                {{-- </span> --}}
                              </div>
                          </div><!-- .card -->
                      </div><!-- .col -->
                      <div class="col-md-3">
                          <div class="card card-bordered card-full">
                              <div class="card-inner">
                                  <div class="card-title-group align-start mb-0">
                                      <div class="card-title">
                                          <strong class="title">Pending Scheme Receipt</strong>
                                      </div>
                                  </div>
                                  <div class="card-amount">
                                      <span class="amount"> {{$pendingSchemeReceipt}} </span>
                                  </div>
                                @hasanyrole('system-admin|accounting')
                                    <a href="{{url('/pending-receipt')}}" class="btn btn-dim btn-xs btn-round btn-outline-success" ><em class="icon ni ni-link"></em> <span>View Claims</span></a>
                                @else
                                <a href="#" style="pointer-events: none !important; cursor: default;" class="btn btn-dim btn-xs btn-round btn-outline-success" ><em class="icon ni ni-link"></em> <span>View Claims</span></a>
                                @endhasanyrole
                                 
                              </div>
                          </div><!-- .card -->
                      </div><!-- .col -->
                      <div class="col-md-3">
                          <div class="card card-bordered  card-full">
                              <div class="card-inner">
                                  <div class="card-title-group align-start mb-0">
                                      <div class="card-title">
                                          <strong class="title">Claims With Issue</strong>
                                      </div>
                                  </div>
                                  <div class="card-amount">
                                      <span class="amount"> {{$claimsWithIssueCount}}
                                      </span>
                                  </div>
                                 
                                  <a href="{{url('/claims-with-issue')}}" class="btn btn-dim btn-xs btn-round btn-outline-warning" ><em class="icon ni ni-link"></em> <span>View Claims</span></a>
                                   
                                 
                              </div>
                          </div><!-- .card -->
                      </div><!-- .col -->

                      <div class="col-md-3">
                          <div class="card card-bordered  card-full">
                              <div class="card-inner">
                                  <div class="card-title-group align-start mb-0">
                                      <div class="card-title">
                                          <strong class="title">Claims Not Processed</strong>
                                      </div>
                                      <div class="card-tools">
                                          <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="UnProcessed Claims"></em>
                                      </div>
                                  </div>
                                  <div class="card-amount">
                                      <span class="amount"> {{$unProcessedCount}} 
                                      </span>
                                  </div>
                                  @hasanyrole('system-admin|claim-entry|front-desk')
                                        <a href="{{url('/un-processed-claims')}}" class="btn btn-dim btn-xs btn-round btn-outline-danger" ><em class="icon ni ni-link"></em> <span>View Claims</span></a>
                                    @else
                                        <a href="#" style="pointer-events: none !important; cursor: default;" class="btn btn-dim btn-xs btn-round btn-outline-danger" ><em class="icon ni ni-link"></em> <span>View Claims</span></a>
                                    @endhasanyrole
                                  
                              </div>
                          </div><!-- .card -->
                      </div><!-- .col -->



                      <div class="col-md-12 col-xxl-4">
                        <div class="card card-bordered card-full">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Claims By Month</h6>
                                    </div>
                                    <div class="card-tools mt-n1 me-n1">
                                      <form method="GET" action="#">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="month" onchange="changeEventHandler(event)" value="{{$currentMonthYear}}" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <div class="" style="padding: 10px;">

                                
                                <div id="accordion">
                                    @foreach ($claimsByDate as $key => $claims)
                                    <h3>{{ \Carbon\Carbon::parse($key)->format('j F, Y') }}</h3>
                                    <div>
                                        <table class="datatable-init-export nowrap table table-hover table-striped" data-export-title="Export">
                                            <thead>
                                                <tr>
                                                    <th>Claim ID</th>
                                                    <th>Description</th>
                                                    <th>Scheme</th>
                                                    <th>Company</th>
                                                    <th>Status</th>
                                                    <th>Created At</th>
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
                                                    <td>
                                                        <span class="{{$claim->claim_state != null ? $claim->claim_state?->cssclass: 'badge bg-outline-primary'}}">{{$claim->claim_state?->name}}</span>
                                                    </td>
                                                    <td>{{date('d-m-Y H:iA', strtotime($claim->created_at))}}</td>
                                                    <td>
                                                        <a href="{{url('claim-details?claimid='.$claim->claimid)}}" class="btn btn-sm btn-round btn-outline-info"><em class="icon ni ni-eye"></em> <span>Details</span></a>
                                                        @hasanyrole('system-admin|claim-entry|front-desk')
                                                        <a href="{{url('request-files?claimid='.$claim->claimid)}}" class="btn btn-round btn-sm btn-outline-dark"><em class="icon ni ni-setting"></em> <span>Upload Request / Additional Files</span></a>
                                                        @if($claim->claim_state_id < 2)
                                                        <a href="{{url('processed-files?claimid='.$claim->claimid)}}" class="btn btn-round btn-sm btn-outline-primary"><em class="icon ni ni-setting"></em> <span>Upload Processed Files</span></a>
                                                        @endif
                                                        @endhasanyrole
                                                        @if($claim->claim_state_id == 2)
                                                            @role('audit')
                                                                <a href="{{url('audit?claimid='.$claim->claimid)}}" class="btn btn-round btn-sm btn-outline-success"><em class="icon ni ni-setting"></em><span>Audit Claim</span></a>
                                                            @endrole
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endforeach
                                    
                                  </div>
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->



                      
                      <div class="col-md-7 col-xxl-5">
                          <div class="card card-bordered h-100">
                              <div class="card-inner">
                                  <div class="card-title-group align-start pb-3 g-2">
                                      <div class="card-title">
                                          <h6 class="title">Claim Issues</h6>
                                          <p>Pending issues on claims will appear here.</p>
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
                      <div class="col-md-5 col-xxl-3">
                          <div class="card card-bordered">
                              <div class="card-inner">
                                  <div class="card-title-group">
                                      <div class="card-title">
                                          <h6 class="title">Claims By State - Chart</h6>
                                      </div>
                                      <div class="card-tools">
                                          <div class="drodown">
                                            <select class="form-control">
                                                <option value="7">7 Days</option>
                                                <option value="15">15 Days</option>
                                                <option value="30">30 Days</option>
                                            </select>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="traffic-channel">
                                      <div class="traffic-channel-doughnut-ck">
                                          <canvas class="analytics-doughnut" id="BookingData"></canvas>
                                      </div>
                                      <div class="traffic-channel-group g-2">
                                        @foreach($states as $state)
                                          <div class="traffic-channel-data">
                                              <div class="title"><span class="dot dot-lg sq" data-bg="#9cabff"></span><span>{{$state->name}}</span></div>
                                              <div class="amount">{{$state->claim_count}} </div>
                                          </div>
                                        @endforeach
                                          {{-- <div class="traffic-channel-data">
                                              <div class="title"><span class="dot dot-lg sq" data-bg="#1ee0ac"></span><span>Double</span></div>
                                              <div class="amount">859 <small>23.94%</small></div>
                                          </div>
                                          <div class="traffic-channel-data">
                                              <div class="title"><span class="dot dot-lg sq" data-bg="#f9db7b"></span><span>Delux</span></div>
                                              <div class="amount">482 <small>12.94%</small></div>
                                          </div>
                                          <div class="traffic-channel-data">
                                              <div class="title"><span class="dot dot-lg sq" data-bg="#ffa353"></span><span>Suit</span></div>
                                              <div class="amount">138 <small>4.49%</small></div>
                                          </div> --}}
                                      </div><!-- .traffic-channel-group -->
                                  </div><!-- .traffic-channel -->
                              </div>
                          </div><!-- .card -->
                      </div><!-- .col -->
                      {{-- <div class="col-xxl-5">
                          <div class="card card-bordered h-100">
                              <div class="card-inner">
                                  <div class="card-title-group pb-3 g-2">
                                      <div class="card-title">
                                          <h6 class="title">Income vs Expenses</h6>
                                          <p>How was your income and Expenses this month.</p>
                                      </div>
                                      <div class="card-tools shrink-0 d-none d-sm-block">
                                          <ul class="nav nav-switch-s2 nav-tabs bg-white">
                                              <li class="nav-item"><a href="#" class="nav-link">7 D</a></li>
                                              <li class="nav-item"><a href="#" class="nav-link active">1 M</a></li>
                                              <li class="nav-item"><a href="#" class="nav-link">3 M</a></li>
                                          </ul>
                                      </div>
                                  </div>
                                  <div class="analytic-ov">
                                      <div class="analytic-data-group analytic-ov-group g-3">
                                          <div class="analytic-data analytic-ov-data">
                                              <div class="title text-primary">Income</div>
                                              <div class="amount">2.57K</div>
                                              <div class="change down"><em class="icon ni ni-arrow-long-down"></em>12.37%</div>
                                          </div>
                                          <div class="analytic-data analytic-ov-data">
                                              <div class="title text-danger">Expenses</div>
                                              <div class="amount">3.5K</div>
                                              <div class="change down"><em class="icon ni ni-arrow-long-up"></em>8.37%</div>
                                          </div>
                                      </div>
                                      <div class="analytic-ov-ck">
                                          <canvas class="analytics-line-large" id="analyticOvData"></canvas>
                                      </div>
                                      <div class="chart-label-group ms-5">
                                          <div class="chart-label">01 Jan, 2020</div>
                                          <div class="chart-label d-none d-sm-block">15 Jan, 2020</div>
                                          <div class="chart-label">30 Jan, 2020</div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div> --}}
                     
                  </div><!-- .row -->
              </div><!-- .nk-block -->
          </div>
      </div>
  </div>
</div>
@stop

@section('scripts')
<script src="{{asset('assets/js/libs/datatable-btns.js?ver=3.2.0')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
  $( function() {
    $( "#accordion" ).accordion();
  } );
</script>

<script>
    function changeEventHandler(event) {
         var urlParts = window.location.href.split("?");
         window.location.href = urlParts[0]+'?date='+event.target.value;
    }
</script>


<script>
  // init chart
  NioApp.coms.docReady.push(function () {
    analyticsLineLarge();
  });
  var BookingData = {
    labels: ["Single", "Double", "Dlux", "Suit", "gsgshs"],
    dataUnit: 'People',
    legend: false,
    datasets: [{
      borderColor: "#fff",
      background: ["#798bff", "#1ee0ac", "#f9db7b", "#ffa353", '#000000'],
      data: [3305, 859, 482, 138, 1000]
    }]
  };
  function analyticsDoughnut(selector, set_data) {
    var $selector = selector ? $(selector) : $('.analytics-doughnut');
    $selector.each(function () {
      var $self = $(this),
        _self_id = $self.attr('id'),
        _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data;
      var selectCanvas = document.getElementById(_self_id).getContext("2d");
      var chart_data = [];
      for (var i = 0; i < _get_data.datasets.length; i++) {
        chart_data.push({
          backgroundColor: _get_data.datasets[i].background,
          borderWidth: 2,
          borderColor: _get_data.datasets[i].borderColor,
          hoverBorderColor: _get_data.datasets[i].borderColor,
          data: _get_data.datasets[i].data
        });
      }
      var chart = new Chart(selectCanvas, {
        type: 'doughnut',
        data: {
          labels: _get_data.labels,
          datasets: chart_data
        },
        options: {
          legend: {
            display: _get_data.legend ? _get_data.legend : false,
            labels: {
              boxWidth: 12,
              padding: 20,
              fontColor: '#6783b8'
            }
          },
          rotation: -1.5,
          cutoutPercentage: 70,
          maintainAspectRatio: false,
          tooltips: {
            enabled: true,
            rtl: NioApp.State.isRTL,
            callbacks: {
              title: function title(tooltipItem, data) {
                return data['labels'][tooltipItem[0]['index']];
              },
              label: function label(tooltipItem, data) {
                return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
              }
            },
            backgroundColor: '#fff',
            borderColor: '#eff6ff',
            borderWidth: 2,
            titleFontSize: 13,
            titleFontColor: '#6783b8',
            titleMarginBottom: 6,
            bodyFontColor: '#9eaecf',
            bodyFontSize: 12,
            bodySpacing: 4,
            yPadding: 10,
            xPadding: 10,
            footerMarginTop: 0,
            displayColors: false
          }
        }
      });
    });
  }
</script>
@stop
