@extends('admin.main2')
@section('title','registration')
@section('css')
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
    <style>
        .error{
            color: red;
        }
    </style>
@endsection
@section('content')
    <!-- BACKGROUND-IMAGE -->
    <div class="login-img">

        <!-- GLOABAL LOADER -->
        <div id="global-loader">
            <img src="{{URL::asset('assets/images/loader.svg')}}" class="loader-img" alt="Loader">
        </div>
        <!-- /GLOABAL LOADER -->

        <!-- PAGE -->
        <div class="page">
            <div class="">
                <!-- CONTAINER OPEN -->
                <div class="col col-login mx-auto">
                    <div class="text-center">
                        <img src="{{URL::asset('assets/images/brand/logo.png')}}" class="header-brand-img" alt="logo">
                    </div>
                </div>
                <div class="container-login100">
                    <div class="wrap-login100 p-6">
                        <form class="login100-form validate-form" id="registerForm">
                            @csrf
								<span class="login100-form-title">
									Registration
								</span>
                            <div class="wrap-input100 validate-input" data-validate = "Valid first name is required: md x">
                                <input class="input100" type="text" name="firstname" id="firstname" placeholder="First name">
                                <span class="error firstnameerr"></span>
                                <span class="symbol-input100">
										<i class="fa fa-user-plus" aria-hidden="true"></i>
									</span>
                            </div>
                            <div class="wrap-input100 validate-input" data-validate = "Valid last name is required: ahmed">
                                <input class="input100" type="text" name="lastname" id="lastname" placeholder="Last name">
                                <span class="error"></span>
                                <span class="symbol-input100">
										<i class="fa fa-user-plus" aria-hidden="true"></i>
									</span>
                            </div>
                            <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                                <input class="input100" type="text" name="email" id="email" placeholder="Email">
                                <span class="error emailerr"></span>
                                <span class="symbol-input100">
										<i class="zmdi zmdi-email" aria-hidden="true"></i>
									</span>
                            </div>

                            <div class="wrap-input100 validate-input">
                                <input class="input100" type="text" name="mobile" id="mobile" placeholder="Mobile">
                                <span class="error"></span>
                                <span class="symbol-input100">
										<i class="fa fa-phone" aria-hidden="true"></i>
									</span>
                            </div>
                            <div class="wrap-input100 validate-input">
                                <select class="input100" name="country" id="country" aria-invalid="country" placeholder="select country">
                                </select>
                                <span class="error"></span>
                                <span class="symbol-input100">
										<i class="fa fa-flag" aria-hidden="true"></i>
									</span>
                            </div>

                            <label class="custom-control custom-checkbox mt-4">
                                <input type="checkbox" class="custom-control-input" name="terms" id="terms" value="1">
                                <span class="custom-control-label">Agree the <a href="{{url('terms')}}">terms and policy</a></span>
                            </label>
                            <div class="container-login100-form-btn">
                                <input type="submit" name="submit" value="Register" id="submit" class="login100-form-btn btn-primary">
                            </div>
                            <div class="text-center pt-3">
                                <p class="text-dark mb-0">Already have account?<a href="{{url('/')}}" class="text-primary ml-1">Sign In</a></p>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!-- END PAGE -->

    </div>
    <!-- BACKGROUND-IMAGE CLOSED -->
@endsection
@section('js')
    <script>
        //  SweetAlert2
        const Toast = Swal.mixin({
            toast:true,
            position:'top-end',
            icon:'success',
            showConfirmbutton: false,
            timer:3000
        });

        // pass the csrf token for post method.
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('country') }}",
            type: "GET",
            success: function (response) {
                var html = '<option value=""> choose a country</option>';
                if (response.length >0){
                    for (let i=0;i<response.length; i++){
                        html +='<option value="'+response[i]['countrycode']+'">'+response[i]['countryname']+'</option>';
                    }
                }

                $("#country").html(html);
            }

        });

        $('#registerForm').on("submit",function(event) {
            event.preventDefault();
            if (validate() === true) {
            var form = $(this).serialize();
            $.ajax({
                url: "register",
                data: form,
                /*   contentType:false,
                   cache:false,
                   processData:false,*/
                type: "POST",
                success: function (response) {

                    if (response.msg) {
                        $("#registerForm")[0].reset();
                        $(".error").text("");
                        Toast.fire({
                            type: 'success',
                            title: response.msg,
                        });
                    } else {
                        printErrorMsg(response);
                    }

                },
                error: function (error) {
                    Toast.fire({
                        type: 'error',
                        title: 'Something Error Found, Please try again.',
                    });
                }
            });
        }else{
             return false;
        }
        });

        function printErrorMsg(msg) {
            $(".error").text("");
            $.each(msg,function(key,value) {
                $("."+key+"err").text(value);
            });
        }

        function validate() {
            if ($("#first_name").val() == "") {
                $("#first_name").focus();
                Toast.fire({
                    type: 'error',
                    title: 'First name is required!',
                });
                return false;
            }if ($("#last_name").val() == "") {
                $("#last_name").focus();
                Toast.fire({
                    type: 'error',
                    title: 'Last name is required!',
                });
                return false;
            }if ($("#email").val() == "") {
                $("#email").focus();
                Toast.fire({
                    type: 'error',
                    title: 'Email is required!',
                });
                return false;
            }if ($("#mobile").val() == "") {
                $("#mobile").focus();
                Toast.fire({
                    type: 'error',
                    title: 'Mobile is required!',
                });
                return false;
            }if ($("#country").val() == "") {
                $("#country").focus();
                Toast.fire({
                    type: 'error',
                    title: 'Country is required!',
                });
                return false;
            }
        }
    </script>
@endsection
