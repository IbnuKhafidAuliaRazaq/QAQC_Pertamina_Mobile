
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    @include('layouts.css')
    <script src="https://kit.fontawesome.com/a56f08e261.js" crossorigin="anonymous"></script>
    <style>

        .my-preloader{
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            position: absolute;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999 !important;
        }
        .my-load{
            background-color: white;
            width: 100px;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            animation: fadeIn 3s ease-in-out infinite;
            position: fixed;
            top: 43%
        }
        .my-load img{
            width: 60px;
            height: 40px;
        }

        @keyframes fadeIn{
            0%{
                opacity: 0;
            }
            50%{
                opacity: 1;
            }
            100%{
                opacity: 0;
            }
        }

</style>
</head>
<body class="fix-header">
    <div class="my-preloader d-none">
        <div class="my-load">
            <img src="{{ url('new_joborder/public/preload/logo-pertamina.png') }}" alt="">
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @include('layouts.navbar')
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="lpage-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="lcontainer-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="fix-width mb-5">
                    @yield('content')
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <script>
        window.onbeforeunload = function() {
            // setTimeout(() => {
                document.querySelector('.my-preloader').classList.remove('d-none')
            // }, 1500);
        }
        function fire_load(){
            console.log('doc')
            setTimeout(() => {
                document.querySelector('.my-preloader').classList.add('d-none')
            }, 5000);
        }
            
        // if(document.readyState == 'loading'){
        //     document.addEventListener('DOMContentLoaded', function(){
        //         document.querySelector('.my-preloader').classList.add('d-none')
        //     })
        // }else{
        //     document.querySelector('.my-preloader').classList.remove('d-none')
        // }
    </script>
    @include('layouts.js')

    @yield('js')
</body>

</html>
