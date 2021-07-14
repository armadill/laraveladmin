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
                    INV-{{$random}} 
                </span>
                
                <div class="wrap-input100 validate-input" data-validate="Domain is required">
                    <span class="label-input100">Domain</span>
                    <input type="hidden" name="txtrandom" type="text" value="{{$random}}">
                    <input class="input100" type="text" name="name" value="{{$data->domain}}" readonly placeholder="Enter your domain">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Number is required">
                    <span class="label-input100">Whatsapp</span>
                    <input class="input100" type="text" name="name" readonly value="{{$data->nope}}" placeholder="Enter your Whatsapp">
                    <span class="focus-input100"></span>
                </div>

                <!--  <div class="wrap-input100 input100-select">
                    <span class="label-input100">Orderan untuk</span>
                    <div>
                        <select class="selection-2" name="service">
                            <option>1 Bulan</option>
                            <option>2 Bulan</option>
                            <option>3 Bulan</option>
                            <option>4 Bulan</option>
                            <option>5 Bulan</option>
                            <option>6 Bulan</option>
                            <option>7 Bulan</option>
                            <option>8 Bulan</option>
                            <option>9 Bulan</option>
                            <option>10 Bulan</option>
                            <option>11 Bulan</option>
                            <option>12 Bulan</option>

                        </select>
                    </div>
                    <span class="focus-input100"></span>
                </div> -->

                <div class="wrap-input100 validate-input" data-validate="Number is required">
                    <span class="label-input100">Total Tagihan</span>
                    @php
                    $total = $data->harga*$data->maxuser+$data->hargax;
                    $hasil = "Rp " . number_format($total,2,',','.');
                    @endphp
                    <input class="input100" type="text" name="name" readonly value="{{$hasil}}">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Number is required">
                    <span class="label-input100">E-mail</span>
                    <input class="input100" type="text" name="name" readonly value="{{$data->email}}" placeholder="Enter your Whatsapp">
                    <span class="focus-input100"></span>
                </div>

                <!--  <div class="wrap-input100 validate-input" data-validate="Number is required">
                    <span class="label-input100">Email</span>
                    <input class="input100" type="email" name="email" placeholder="Enter your Email">
                    <span class="focus-input100"></span>
                </div>
               
 -->
               

               <!--  <div class="wrap-input100 validate-input" data-validate = "Message is required">
                    <span class="label-input100">Message</span>
                    <textarea class="input100" name="message" placeholder="Your message here..."></textarea>
                    <span class="focus-input100"></span>
                </div> -->

                <div class="container-contact100-form-btn">
                    <div class="wrap-contact100-form-btn">
                        <div class="contact100-form-bgbtn"></div>
                        <button class="contact100-form-btn" id="pay-button" >
                            <span>
                                Bayar
                                <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </span>
   
           <!--  <button id="pay-button">Bayar</button> -->
        <!--<pre><div id="result-json">JSON result will appear here after payment:<br></div></pre>-->
      <script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-EsjNNv3zRFv8evNi"></script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function(){
                // SnapToken acquired from previous step
                snap.pay('{{$token}}', {
                    // Optional
                    onSuccess: function(result){

                 document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                  
                  Swal.fire(
                        'Berhasil!',
                        'Pembayaran anda berhasil',
                        'success'
                     );    
            
                     setTimeout(function() {
                        window.location = "{{$data->domain}}";
                    }, 5000);
    
                    },
                    
                    // Optional
                    onPending: function(result){
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    },
                    // Optional
                    onError: function(result){
                    //   document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                     Swal.fire(
                        'Eror!',
                        'Terjadi error',
                        'error'
                     );    
                    }
                });
            };
        </script>
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

