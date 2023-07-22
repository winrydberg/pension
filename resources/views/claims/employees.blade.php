@extends('includes.master')


@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h4 class="nk-block-title">Employees For Claim | {{$claim->claimid}}</h4>
                          <div class="nk-block-des text-soft">
                              <p>On this page, employees for claim with ID {{$claim->claimid}}. You can use the search to search by name, amount etc.</p>
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
                                    <th>Claim Type</th>
                                    <th>Company</th>
                                    <th>Amount</th>
                                    <th>Account Name</th>
                                    <th>Bank</th>
                                    <th>Branch</th>
                                    <th>Acc. No</th>

                                    <th>Employee Cont.</th>
                                    <th>Employer Cont.</th>
                                    <th>Withdrawal Amt</th>
                                    <th>Tax Percentage</th>
                                    <th>Amount Payable To SSNIT</th>
                                    <th>Name on Cheque</th>
                                    <th>Cheque No.</th>
                                    <th>Status</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $c)
                                <tr>
                                        
                                        <td>
                                            {{$c->name}}
                                            {{-- <div style="display:flex; flex-direction:row;">
                                                <span style="margin-left: 10px;">{{$c->name}}</span>
                                                <div class="user-avatar xs bg-primary">
                                                    <span>AB</span>
                                                </div>
                                            </div> --}}
                                        </td>
                                        <td>{{$c->policy_number}}</td>
                                        <td>{{$c->claimtype}}</td>
                                        <td>{{$c->company}}</td>
                                        <td>{{$c->amount}}</td>
                                        <td>{{$c->name}}</td>
                                        <td>{{$c->bank}}</td>
                                        <td>{{$c->bankbranch}}</td>
                                        <td>{{$c->accnumber}}</td>
                                        <td>{{$c->employee_contribution}}</td>
                                        <td>{{$c->employer_contribution}}</td>
                                        <td>{{$c->withdrawal_amount}}</td>
                                        <td>{{$c->tax_percentage}}</td>
                                        <td>{{$c->amount_payable_to_ssnit}}</td>
                                        <td>{{$c->name_on_cheque}}</td>
                                        <td>{{$c->cheque_number}}</td>
                                        <td>
                                            
                                        {{-- @if($c->payment_status == true) --}}
                                            <span class="{{$claim?->claim_state != null ? $claim?->claim_state?->cssclass: 'badge bg-outline-primary'}}"><em class="icon ni ni-setting"></em> <span>{{$claim?->claim_state?->name}}</span></span>
                                        {{-- @else
                                            <span class="badge badge-danger">Not Paid</span>
                                        @endif --}}
                                        </td>
                                        <td>
                                        @if($claim->paid)
                                            @role('accounting')
                                            <button class="btn btn-xs btn-primary" onclick="enterChequeNo({{$c->id}},  {{$c->claim_id}})"><i class="fa fa-credit-card"></i>  Enter Cheque No</button>
                                            @endrole
                                        @endif
                                        
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