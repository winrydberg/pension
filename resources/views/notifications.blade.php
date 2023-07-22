@extends('includes.master')


@section('contentone')
<div class="nk-content ">
  <div class="container-fluid">
      <div class="nk-content-inner">
          <div class="nk-content-body">
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                      <div class="nk-block-head-content">
                          <h4 class="nk-block-title">Notifications</h4>
                          <div class="nk-block-des text-soft">
                              <p>On this page, you'll find all your notifications, both read and unread.</p>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="nk-block nk-block-lg">
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <div class="nk-tb-list nk-tb-ulist">
                            <div class="nk-tb-item nk-tb-head">
                               
                                <div class="nk-tb-col"><span class="sub-text">Title</span></div>
                                <div class="nk-tb-col tb-col-mb"><span class="sub-text">Message Type</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Actions</span></div>
                            
                            </div>
                            <div class="nk-tb-item">
                                
                                <div class="nk-tb-col">
                                    <a href="html/user-details-regular.html">
                                        <div class="user-card">
                                            <div class="user-avatar bg-danger">
                                                <span><em class="icon ni ni-bell"></em></span>
                                            </div>
                                            <div class="user-info">
                                                <span class="tb-lead">Abu Bin Ishtiyak <span class="dot dot-success d-md-none ms-1"></span></span>
                                                {{-- <span>info@softnio.com</span> --}}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="nk-tb-col tb-col-mb">
                                    <span class="tb-amount">35,040.34 <span class="currency">USD</span></span>
                                </div>
                                
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-status text-success">Active</span>
                                </div>
                                <div class="nk-tb-col nk-tb-col-tools">
                                    <ul class="nk-tb-actions gx-1">
                                    
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#"><em class="icon ni ni-focus"></em><span>Quick View</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>

              <div class="nk-block nk-block-lg">
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        
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