<!DOCTYPE html>
<html lang="en">
<head>
    <title>absenpegawai.com</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{asset('cekout/images/icons/favicon.ico')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('cekout/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('cekout/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('cekout/vendor/animate/animate.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('cekout/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('cekout/vendor/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('cekout/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css')}}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="http://admin.absenpegawai.com/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css
">
    <link rel="stylesheet" type="text/css" href="{{asset('cekout/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cekout/css/main.css')}}">
<!--===============================================================================================-->
</head>
<body>
      

    <div class="container-contact100">
        <div class="wrap-contact100" id="upload_form">
            <span class="contact100-form validate-form">
                <span class="contact100-form-title">
                     
                    @if($status == 'Sukses')
                   
                        INV-{{$random}}  <img src="http://admin.absenpegawai.com/paid.png" class="img-fluid"> 
                    @elseif ($status == 'Expired')
                         INV-{{$random}} <img src="http://admin.absenpegawai.com/expired.png" class="img-fluid">
                    @else
                       INV-{{$random}} {{$status}}
                    @endif
                </span>
        
            </span>
   
           <!--  <button id="pay-button">Bayar</button> -->
        <!--<pre><div id="result-json">JSON result will appear here after payment:<br></div></pre>-->
      
        </div>
    </div>



    <div id="dropDownSelect1"></div>

<link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
<!--===============================================================================================-->
    <script src="{{asset('cekout/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('cekout/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('cekout/vendor/bootstrap/js/popper.js')}}"></script>
    <script src="{{asset('cekout/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('cekout/vendor/select2/select2.min.js')}}"></script>
    <script>
        $(".selection-2").select2({
            minimumResultsForSearch: 20,
            dropdownParent: $('#dropDownSelect1')
        });
    </script>
<!--===============================================================================================-->
    <script src="{{asset('cekout/vendor/daterangepicker/moment.min.js')}}"></script>
    <script src="{{asset('cekout/vendor/daterangepicker/daterangepicker.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('cekout/vendor/countdowntime/countdowntime.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('cekout/js/main.js"></script>
<script src="http://admin.absenpegawai.com/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>



</body>
</html>

