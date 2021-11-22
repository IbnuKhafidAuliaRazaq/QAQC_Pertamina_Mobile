<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<!-- Bootstrap tether Core JavaScript -->

<script src="{{ asset('/new_joborder/public/landingpage/js/jquery.min.js') }}"></script>
<script src="{{ asset('/new_joborder/public/landingpage/assets/bootstrap/js/popper.min.js')  }}"></script>
<script src="{{ asset('/new_joborder/public/landingpage/assets/bootstrap/js/bootstrap.min.js')  }}"></script>
<!--Wave Effects -->
<script src="{{ asset('/new_joborder/public/landingpage/js/waves.js') }}"></script>
<!--stickey kit -->
<script src="{{ asset('/new_joborder/public/landingpage/js/sticky-kit.min.js') }}"></script>
<!-- jQuery for carousel -->
<script src="{{ asset('/new_joborder/public/landingpage/assets/owl.carousel/owl.carousel.min.js')  }}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('/new_joborder/public/landingpage/js/custom.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.25/r-2.2.9/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.25/r-2.2.9/datatables.min.js"></script>


<script>
    $(document).ready( function () {
        $('#datatables').DataTable({
            paginate: false,
        });
    } );
</script>
