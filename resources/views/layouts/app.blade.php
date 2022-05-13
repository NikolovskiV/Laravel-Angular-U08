<!DOCTYPE html>
<html lang="en">
<?php 
    $createdMenu = createMenu();
?>
<head>
    @include('partials.head')
    <style>
        .bg-yellow2 {
            background-color: #63686f !important;
        }
        .error{
            color: red;
        }
    </style>
</head>


<body class="hold-transition skin-blue sidebar" style="padding-bottom: 0px !important;">

<div id="wrapper">

@include('partials.topbar')
@include('partials.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="position: relative;">
        <section class="content-header">
            <h1>{!!$createdMenu['currentIcon']!!} {{$createdMenu['currentPage']}}{!!$createdMenu['subpage']!!} 
                @if(Request::segment(3) == 'approve')
                (Approved)
                @elseif(Request::segment(3) == 'decline')
                (Declined)
                @endif
            </h1>
            <ol class="breadcrumb">
                <!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li> -->
                {!!$createdMenu['breadcrumb']!!}
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <div class="master-footer" style="width:100%;">
            <strong>Copyright © {{date('Y')}} | </strong> Developed & Maintained By Office of IT, NSU
        </div>
        @if(Session::get('prevUser'))
        <div class="master-footer" style="width:100%;">
            <a href="{{URL::to('admin/stop-acting-as-user')}}" class="btn bg-orange btn-flat margin" style="position:absolute;right: 0px;bottom: -8px;z-index: 99999;">
                Stop Acting As User
            </a>
        </div>
        @endif
    </div>
</div>
@include('partials.javascripts')
@yield('modal-nav')
@yield('modal')
@yield('modal-error')
<script type="text/javascript">
    var check = 0
    $( document ).ajaxStart(function() {
        check = 1;
        $("button").prop("disabled",true);
    });
    $( document ).ajaxStop(function() {
        $("button").not('#submit_button').prop("disabled",false);
        // $("#submit_button").prop("disabled",true);
        $(".main-sidebar").css('min-height', $(".content-wrapper").height()+40);
    });
    $(document).ready(function(){
        setTimeout(function(){
            $(".main-sidebar").css('min-height', $(".content-wrapper").height()+40);
            var sideBarHeight = $(".main-sidebar").height();
            var wrapperHeight = $(".content-wrapper").height();
            if((sideBarHeight > wrapperHeight+40) && check == 0){
                $(".content-wrapper").css('height', sideBarHeight-40);
            }
        }, 1);
    });
</script>
@yield('script')
</body>



</html>