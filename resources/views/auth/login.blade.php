<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="UPT | Pension Claim Management Portal">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>Login | Pension Claim Management Portal</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{asset('assets/css/dashlite.css?ver=3.2.0')}}">
    <link id="skin-default" rel="stylesheet" href="{{asset('assets/css/theme.css?ver=3.2.0')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}">
</head>

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-split nk-split-page nk-split-lg">
                        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                            <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                                <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"><em class="icon ni ni-info"></em></a>
                            </div>
                            <div class="nk-block nk-block-middle nk-auth-body">
                                <div class="brand-logo pb-5">
                                    <a href="#" class="logo-link">
                                        
                                    </a>
                                </div>
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Sign-In</h5>
                                        <div class="nk-block-des">
                                            <p>Sign-In to continue</p>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <p class="alert alert-danger" style="display:none" id="errormessage"></p>
                                <form action="#" id="userLogin" class="form-validate is-alter" autocomplete="off">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="email-address">Email</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input autocomplete="off" name="email" type="text" class="form-control form-control" required id="email-address" placeholder="Enter your email address">
                                        </div>
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Password</label>
                                            {{-- <a class="link link-primary link-sm" tabindex="-1" href="html/pages/auths/auth-reset.html">Forgot Password?</a> --}}
                                        </div>
                                        <div class="form-control-wrap">
                                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input autocomplete="new-password" name="password" type="password" class="form-control form-control" required id="password" placeholder="Enter your passcode">
                                        </div>
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <button class="btn btn-md btn-primary btn-block"><i class="fa fa-lock" id="lock" style="margin-right: 5px;"></i>   <i class="fa fa-spinner fa-spin" id="loader" style="display:none; margin-right: 5px;"></i> Sign In</button>
                                    </div>
                                </form><!-- form -->
                                <div class="form-note-s2 pt-4"> 
                                </div>
                                
                            </div><!-- .nk-block -->
                            <div class="nk-block nk-auth-footer">
                                <div class="nk-block-between">
                                    
                                </div>
                                <div class="mt-3">
                                    <p>&copy; {{date('Y')}} Digicode Systems. All Rights Reserved.</p>
                                </div>
                            </div><!-- .nk-block -->
                        </div><!-- .nk-split-content -->
                        <div style="background-image: url('{{asset('assets/images/bg4.avif')}}'); background-size:cover;" class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right" data-toggle-body="true" data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
                            <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto">
                                <div class="slider-init" data-slick='{"dots":true, "arrows":false}'>
                                    <div class="slider-item">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img">
                                                {{-- <img class="round" src="./images/slides/promo-a.png" srcset="./images/slides/promo-a2x.png 2x" alt=""> --}}
                                            </div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h2 style="color:white">UNITED PENSION TRUST</h2>
                                                <p style="color:white">Manage claim files and payments in one location</p>
                                            </div>
                                        </div>
                                    </div><!-- .slider-item -->
                                    <div class="slider-item">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img">
                                                {{-- <img class="round" src="./images/slides/promo-b.png" srcset="./images/slides/promo-b2x.png 2x" alt=""> --}}
                                            </div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h2 style="color:white">UNITED PENSION TRUST</h2>
                                                <p style="color:white">Manage claim files and payments in one location</p>
                                            </div>
                                        </div>
                                    </div><!-- .slider-item -->
                                    <div class="slider-item">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img">
                                                {{-- <img class="round" src="./images/slides/promo-c.png" srcset="./images/slides/promo-c2x.png 2x" alt=""> --}}
                                            </div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h2 style="color:white">UNITED PENSION TRUST</h2>
                                                <p style="color:white">Manage claim files and payments in one location</p>
                                            </div>
                                        </div>
                                    </div><!-- .slider-item -->
                                </div><!-- .slider-init -->
                                <div class="slider-dots"></div>
                                <div class="slider-arrows"></div>
                            </div><!-- .slider-wrap -->
                        </div><!-- .nk-split-content -->
                    </div><!-- .nk-split -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="{{asset('assets/js/bundle.js?ver=3.2.0')}}"></script>
    <script src="{{asset('assets/js/scripts.js?ver=3.2.0')}}"></script>
    <!-- select region modal -->

    
<script>
    $('#userLogin').submit(function(event){
      event.preventDefault();
      $('#lock').hide();
      $('#loader').show();
      $.ajax({
        url: "{{url('/login')}}",
        method: "POST",
        data: $(this).serialize(),
        success: function(res){
          $('#lock').show();
          $('#loader').hide();
          if(res.status =='success'){
            window.location.href=res.url;
          }else{
            $('#errormessage').text(res.message).show().delay(1500).slideUp(1000);
          }
        },
        error: function(error){
          console.log(error);
          $('#lock').show();
          $('#loader').hide();
        }
      })
    })
  
    
  </script>
 

</html>