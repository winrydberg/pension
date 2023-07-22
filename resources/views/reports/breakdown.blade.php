@extends('includes.master')


@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h4 class="nk-block-title">{{$title}} </h4>
                          <div class="nk-block-des text-soft">
                              <p>On this page, you'll find reports breakdown by employees. Use the search box to search by employee name, company, scheme, account number etc. </p>
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
                                    
                                    <th>Employee Name</th>
                                    <th>Policy No</th>
                                    <th>Claim Type</th>
                                    <th>Company</th>
                                    <th>Amount</th>
                                    <th>Account Name</th>
                                    <th>Acc. No</th>
                                    <th>Cheque No</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $emp)
                                <tr>
                                     <td>
                                         {{$emp->name}}
                                     </td>
                                     <td>{{$emp->policy_number}}</td>
                                     <td>{{$emp->claimtype}}</td>
                                     <td>{{$emp->company}}</td>
                                     <td>{{$emp->amount}}</td>
                                     <td>{{$emp->name}}</td>
                                     <td>{{$emp->accnumber}}</td>
                                     <td>{{$emp->cheque_number}}</td>
                                     <td></td>
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
@stop