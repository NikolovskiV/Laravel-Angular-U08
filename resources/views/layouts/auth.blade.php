<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body class="page-header-fixed">

    <div class="container-fluid">
        @yield('content')
    </div>

    <div class="scroll-to-top"
         style="display: none;">
        <i class="fa fa-arrow-up"></i>
    </div>
    <div class="login-footer">
        <strong>Copyright © {{date('Y')}} <a href="#">NSUIT</a>.</strong> All rights
        reserved.
    </div>
    @include('partials.javascripts')
    <script>
        function onSignIn(googleUser) {
          var profile = googleUser.getBasicProfile();
          console.log(googleUser);
          console.log(profile);
          console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
          console.log('Name: ' + profile.getName());
          console.log('Image URL: ' + profile.getImageUrl());
          console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
        }
    </script>

</body>
</html>
