<!DOCTYPE html>
<html lang="en">


    @include('partials.head')
    <style>
        .bg-yellow2 {
            background-color: #63686f !important;
        }
        .error{
            color: red;
        }
    </style>


<body class="hold-transition skin-blue layout-boxed sidebar-mini">

<div id="wrapper">

@include('partials.sidebar_student')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper student" style="position: relative;">
        <!-- Main content -->
        <section class="content" style="padding:30px">
            @yield('content')
        </section>
        <div class="student-footer">
            <strong>Copyright © {{date('Y')}} <a href="#">NSUIT</a>.</strong> All rights
            reserved.
        </div>
    </div>
</div>

@include('partials.javascripts')
@yield('modal-nav')
@yield('modal')
@yield('modal-error')<script type="text/javascript">
    $( document ).ajaxStart(function() {
        $("button").prop("disabled",true);
    });
    $( document ).ajaxStop(function() {
        $("button").prop("disabled",false);
        $(".main-sidebar").css('min-height', $(".content-wrapper").height());
    });
    $(document).ready(function(){
        setTimeout(function(){
            $(".main-sidebar").css('min-height', $(".content-wrapper").height());
        }, 1);
    });
</script>
@yield('script')
</body>
    
</html>