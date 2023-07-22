@include('includes.header')

 <!-- main @s -->
 <div class="nk-main ">
        @include('includes.sidebar')

        <div class="nk-wrap ">
            @include('includes.topnav')

            @yield('contentone')

            @yield('contenttwo')

            @include('includes.footerbar')
        </div>

 </div>

@include('includes.footer')

