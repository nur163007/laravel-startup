<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
          content="Volgh –  Bootstrap 4 Responsive Application Admin panel Theme Ui Kit & Premium Dashboard Design Modern Flat Laravel Template">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
          content="dashboard, admin, dashboard template, admin template, laravel, php laravel, laravel bootstrap, laravel admin template, bootstrap laravel, bootstrap in laravel, laravel dashboard template, laravel admin, laravel dashboard, laravel blade template, php admin">

    @include('admin.includes.styleCss')
    <style>
        .sidebarerr {
            color: red;
            font-size: 20px;
        }
    </style>
</head>

<body class="app sidebar-mini">

<!-- GLOBAL-LOADER -->
<div id="global-loader">
    <img src="{{URL::asset('assets/images/loader.svg')}}" class="loader-img" alt="Loader">
</div>
<!-- /GLOBAL-LOADER -->

<!-- PAGE -->
<div class="page">
    <div class="page-main">

        @include('admin.includes.left_sidebar')

        @include('admin.includes.mobile-header')

        <div class="app-content">
            <div class="side-app">

                <div class="page-header">
                    @yield('page-header')
                    @include('admin.includes.notification')
                </div>

                @yield('content')
                <br><br><br><br>
                @include('admin.includes.right_sidebar')

                @include('admin.includes.footer')

            </div>
        </div>
    </div>
    <!-- CONTAINER CLOSED -->
</div>

@include('admin.includes.styleJs')
<script type="text/javascript">
    //  SweetAlert2
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        icon: 'success',
        showConfirmbutton: false,
        timer: 3000
    });

    // localStorage.removeItem("accessToken");
    // localStorage.removeItem("expires_in");
    // localStorage.removeItem("userData");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var base_url = window.location.origin;
    var current_url = window.location.href;
    localStorage.setItem("currentURL", current_url);

    let getToken = localStorage.getItem("accessToken");
    $("#hiddenToken").val(getToken);
    $("#hiddenMobileToken").val(getToken);
    let getExpiry = localStorage.getItem("expires_in");
    let created_at = localStorage.getItem("created_at");
    let tokenCreateTime = new Date(created_at).getTime() / 1000;
    let currentTime = new Date().getTime() / 1000;
    let now = Math.floor(currentTime - tokenCreateTime);

    if (now >= getExpiry) {
        localStorage.removeItem("accessToken");
        localStorage.removeItem("expires_in");
    }

    if (getToken == null || getExpiry == null) {
        window.location.assign(base_url + "/");
    }
    $(document).ready(function () {
        let getUser = localStorage.getItem("userData");

        var data = JSON.parse(getUser);
        // console.log(data);
        //call sidebar fucntion
        var isauthor = data.is_authorized;
        var role = data.role;
        // console.log(isauthor)
        if (isauthor == 1) {
            getSidebar(role);
        }

        //user profile payment option
        $("#posPayment").hide();
        $("#payment").hide();
        if (role ==4){
            $("#posPayment").show();
            $("#payment").show();
        }else{
            $("#posPayment").hide();
            $("#payment").hide();
        }

        //all data show in deferent pages

        $(".getFullName").html(data.first_name + ' ' + data.last_name);
        $(".getCompany").html(data.company);
        $(".getEmail").html(data.email);
        $(".getMobile").html(data.mobile);
        $(".getAddress").html(data.address + ',' + data.city + ',' + data.state + '-' + data.zip_code + ',' + data.country);
        $(".getNid").html(data.nid);
        $(".getuserName").html(data.username);
        $(".memberShip").html(new Date(data.created_at).toLocaleDateString('en-us', {
            year: "numeric",
            month: "short",
            day: "numeric"
        }));
        if (data.avatar) {
            $(".getUserProfile").attr("src", "{{asset('assets/images/users/profile')}}/" + data.avatar);
        } else {
            $(".getUserProfile").attr("src", "{{asset('assets/images/users/profile/admin.jpg')}}");
        }


        //form value declaration

        $(".userid").val(data.id);
        $("#exampleInputFirstname").val(data.first_name);
        $("#exampleInputLastname").val(data.last_name);
        $("#exampleInputCompany").val(data.company);
        $("#exampleInputnumber").val(data.mobile);
        $("#exampleInputAddress").val(data.address);
        $("#exampleInputState").val(data.state);
        $("#exampleInputCity").val(data.city);
        $("#exampleInputZipcode").val(data.zip_code);
        // $("#country").val(data.country).change();


        //desktop logout function

        $("#logout-desktop").on('submit', function (event) {
            event.preventDefault();
            var form = $(this).serialize();
            $.ajax({
                url: "{{route('user_logout')}}",
                data: form,
                type: "POST",
                success: function (response) {
                    if (response.success == true) {

                        localStorage.removeItem("accessToken");
                        localStorage.removeItem("expires_in");
                        localStorage.removeItem("userData");
                        window.location.assign(base_url + "/");
                    }
                    $(".error").text("");
                    Toast.fire({
                        type: 'success',
                        title: response.msg,
                    });
                },
                error: function (error) {
                    Toast.fire({
                        type: 'error',
                        title: 'Something Error Found, Please try again.',
                    });
                }
            });
        });


        //mobile logout function

        $("#logout-mobile").on('submit', function (event) {
            event.preventDefault();
            var form = $(this).serialize();
            $.ajax({
                url: "{{route('user_logout')}}",
                data: form,
                type: "POST",
                success: function (response) {
                    if (response.success == true) {
                        localStorage.removeItem("accessToken");
                        localStorage.removeItem("expires_in");
                        localStorage.removeItem("userData");
                        window.location.assign(base_url + "/");
                    }
                    $(".error").text("");
                    Toast.fire({
                        type: 'success',
                        title: response.msg,
                    });
                },
                error: function (error) {
                    Toast.fire({
                        type: 'error',
                        title: 'Something Error Found, Please try again.',
                    });
                }
            });
        });

        //get all country function

        $.ajax({
            url: "{{ route('country') }}",
            type: "GET",
            success: function (response) {
                var html = '<option value=""> choose a country</option>';
                if (response.length > 0) {
                    for (let i = 0; i < response.length; i++) {
                        html += '<option value="' + response[i]['countrycode'] + '">' + response[i]['countryname'] + '</option>';
                    }

                }

                $("#country").html(html);
                $("#country").val(data.country).change();
            }

        });

        $.ajax({
            url: "{{ url('/user/profile/nid/show') }}/" + data.id,
            type: "GET",
            success: function (response) {
                var front = '';
                var back = '';
                if (response.success == true) {
                    let r = JSON.stringify(response.data);
                    var nid = JSON.parse(r);
                    // console.log(nid)
                    for (let i = 0; i < nid.length; i++) {
                        if (nid[i]['doc_title'] = 'NID FRONT PART') {
                            front = nid[0]['doc_path'];
                        }
                        if (nid[i]['doc_title'] = 'NID BACK PART') {
                            back = nid[1]['doc_path'];
                        }
                    }
                }
                $("#hiddenFront").val(front);
                $("#hiddenBack").val(back);

                $("#showNIDFront").attr("src", "{{asset('documents/nid/front')}}/" + front);
                $("#showNIDBack").attr("src", "{{asset('documents/nid/back')}}/" + back);

                $("#showFrontNid").attr("src", "{{asset('documents/nid/front')}}/" + front);
                $("#showBackNid").attr("src", "{{asset('documents/nid/back')}}/" + back);

                if ($("#hiddenFront").val() != '' && $("#hiddenBack").val() != '') {
                    $("#back_part").show();
                } else {
                    $("#back_part").hide();
                }
            }
        });

        //sidebar parent and child class open
        $(document).on( "click", "[data-toggle='slide']", function(e){
            var $this = $(this);
            var checkElement = $this.next();
            var animationSpeed = 300,
                slideMenuSelector = '.slide-menu';
            if (checkElement.is(slideMenuSelector) && checkElement.is(':visible')) {
                checkElement.slideUp(animationSpeed, function() {
                    checkElement.removeClass('open');
                });
                checkElement.parent("li").removeClass("is-expanded");
            }
            else if ((checkElement.is(slideMenuSelector)) && (!checkElement.is(':visible'))) {
                var parent = $this.parents('ul').first();
                var ul = parent.find('ul:visible').slideUp(animationSpeed);
                ul.removeClass('open');
                var parent_li = $this.parent("li");
                checkElement.slideDown(animationSpeed, function() {
                    checkElement.addClass('open');
                    parent.find('li.is-expanded').removeClass('is-expanded');
                    parent_li.addClass('is-expanded');
                });
            }
            if (checkElement.is(slideMenuSelector)) {
                e.preventDefault();
            }

        });
    });

    //sidebar function
    function getSidebar(role) {
        $.ajax({
            url: "{{url('get/sidebar')}}/" + role,
            type: "GET",
            success: function (response) {
                var html = '<li><h3>Main</h3></li>';
                let url;
                if (response.sidebar.length > 0) {
                    for (let i = 0; i < response.sidebar.length; i++) {
                        let sidebar = response.sidebar;
                        if (getToken == null) {
                            url = base_url + "/";
                        } else {
                            url = sidebar[i]['url'];
                        }
                        if (sidebar[i]['parent'] == null && sidebar[i]['url'] != null) {
                            html += "<li>" + '<a class="side-menu__item" href="' + base_url + '/' + url + '"><i class="side-menu__icon ' + sidebar[i]['icon'] + '"></i><span class="side-menu__label">' + sidebar[i]['name'] + '</span></a>' + "</li>";
                        } else {
                            html += "<li class='slide'>" + '<a class="side-menu__item submenu" data-toggle="slide" href="#" ><i class="side-menu__icon ' + sidebar[i]['icon'] + '"></i><span class="side-menu__label">' + sidebar[i]['name'] + '</span><i class="angle fa fa-angle-right"></i></a><ul class="slide-menu">';
                            for (let j = 0; j < response.submenu.length; j++) {
                                let submenu = response.submenu;
                                let suburl;
                                if (getToken == null) {
                                    suburl = base_url + "/";
                                } else {
                                    suburl = submenu[j]['url'];
                                }
                                if (submenu[j]['parent'] == sidebar[i]['id'] && submenu[j]['url'] != null) {
                                    html += "<li>" + '<a class="slide-item" href="' + base_url + '/' + suburl + '"><i class="' + submenu[j]['icon'] + '"></i><span class="side-menu__label ml-1">' + submenu[j]['name'] + '</span></a>' + "</li>";
                                }
                                // $(".submenu").html(sub);
                            }
                            html += "</ul></li>";
                        }
                    }
                    $(".side-menu").html(html);

                    //ACTIVE SIDEBAR MENU
                    $(".side-menu li a").each(function() {
                        var pageUrl = window.location.href.split(/[?#]/)[0];
                        if (this.href == pageUrl) {
                            $(this).addClass("active");   //child a add class
                            $(this).parent().addClass("is-expanded");  //child li add class
                            $(this).parent().parent().prev().addClass("active"); //parent a add class
                            $(this).parent().parent().addClass("open"); // clild ul class add
                            $(this).parent().parent().prev().addClass("is-expanded"); //parent a add class
                            $(this).parent().parent().parent().addClass("is-expanded"); // parent li class add
                            $(this).parent().parent().parent().parent().addClass("open"); // main ul class add
                            // $(this).parent().parent().parent().parent().prev().addClass("active");
                            $(this).parent().parent().parent().parent().parent().addClass("is-expanded"); //aside add class
                        }
                    });
                    // alert(html)
                } else {
                    $(".sidebarerr").text('No data found');
                }
            },
            error: function (error) {

            }
        });
    }

    function ResetForm() {
        $("#passwordChange")[0].reset();
    }
    function ResetDataForm() {
        location.reload();
    }
    function ResetNIDForm() {
        $("#front_nid").val('');
        $("#back_nid").val('');
        location.reload();
    }

    // Resller password change function

    $('#passwordChange').on("submit", function (event) {
        event.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            url: "{{route('change.password')}}",
            data: form,
            type: "POST",
            success: function (response) {

                if (response.success == true) {
                    Toast.fire({
                        type: 'success',
                        title: response.msg,
                    });
                    $("#passwordChange")[0].reset();
                    localStorage.removeItem("accessToken");
                    localStorage.removeItem("expires_in");
                    localStorage.removeItem("userData");
                    window.location.assign(base_url + "/");
                } else {
                    Toast.fire({
                        type: 'error',
                        title: response.msg,
                    });
                }

            },
            error: function (error) {
                Toast.fire({
                    type: 'error',
                    title: 'Something Error Found, Please try again.',
                });
            }
        });
    });

    //    Reseller profile data update funciton

    $('#updateProfileData').on("submit", function (event) {
        event.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            url: "{{route('change.user.data')}}",
            data: form,
            type: "POST",
            success: function (response) {

                if (response.success == true) {
                    Toast.fire({
                        type: 'success',
                        title: response.msg,
                    });
                    // $("#updateProfileData")[0].reset();
                    let r = JSON.stringify(response.user);
                    let data = JSON.parse(r);
                    localStorage.setItem("userData", r);
                    location.reload();
                } else {
                    Toast.fire({
                        type: 'error',
                        title: response.msg,
                    });
                }

            },
            error: function (error) {
                Toast.fire({
                    type: 'error',
                    title: 'Something Error Found, Please try again.',
                });
            }
        });
    });


    //    Reseller profile image update funciton

    $('#updateImageId').on("click", function (event) {
        event.preventDefault();
        let profile = $("#profileImage")[0].files;
        let userid = $(".userid").val();
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        var fd = new FormData();

        // Append data
        fd.append('profile', profile[0]);
        fd.append('userid', userid);
        fd.append('_token', CSRF_TOKEN);
        $.ajax({
            url: "{{route('change.profile.image')}}",
            cache: false,
            contentType: false,
            processData: false,
            type: 'post',
            data: fd,
            dataType: 'json',
            success: function (response) {

                if (response.success == true) {
                    Toast.fire({
                        type: 'success',
                        title: response.msg,
                    });
                    // $("#updateProfileData")[0].reset();
                    let r = JSON.stringify(response.userProfile);
                    let data = JSON.parse(r);
                    localStorage.setItem("userData", r);
                    location.reload();
                } else {
                    Toast.fire({
                        type: 'error',
                        title: response.msg,
                    });
                }

            },
            error: function (error) {
                Toast.fire({
                    type: 'error',
                    title: 'Something Error Found, Please try again.',
                });
            }
        });
    });

    //image preview function

    $("#updateImageId").hide();

    function displayImage(e) {
        if ($("#profileImage").val() != '') {
            $("#updateImageId").show();
        }
        if (e.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.querySelector('.userpicimg').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }

    }

    //  NID UPLOAD FUNCTION

    $("#back_part").hide();

    //nid front part
    function displayFrontPart(e) {
        if ($("#front_nid").val() != '') {
            $("#back_part").show();
        }
        if (e.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.querySelector('#showFrontNid').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }

    }

    //nid back part
    $("#uploadNidDiv").hide();

    function displayBackPart(e) {
        if ($("#back_nid").val() != '') {
            $("#uploadNidDiv").show();
        }
        if (e.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.querySelector('#showBackNid').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }

    }

    //UPLOAD NID DOCUMENTS

    $('#uploadNidBtn').on("click", function (event) {
        event.preventDefault();
        let nid1 = $("#front_nid")[0].files;
        let nid2 = $("#back_nid")[0].files;
        let userid = $(".userid").val();
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        var fd = new FormData();

        // Append data
        fd.append('front_part', nid1[0]);
        fd.append('back_part', nid2[0]);
        fd.append('userid', userid);
        fd.append('_token', CSRF_TOKEN);
        $.ajax({
            url: "{{route('change.profile.nid')}}",
            cache: false,
            contentType: false,
            processData: false,
            type: 'post',
            data: fd,
            dataType: 'json',
            success: function (response) {

                if (response.success == true) {
                    Toast.fire({
                        type: 'success',
                        title: response.msg,
                    });
                    // $("#updateProfileData")[0].reset();
                    let r = JSON.stringify(response.niddata);

                    localStorage.setItem("nidData", r);
                    location.reload();
                } else {
                    Toast.fire({
                        type: 'error',
                        title: response.msg,
                    });
                }

            },
            error: function (error) {
                Toast.fire({
                    type: 'error',
                    title: 'Something Error Found, Please try again.',
                });
            }
        });
    });

    //    payment history

    {{--$('#user_payment_history').DataTable({--}}
    {{--    --}}{{--ajax:"{{ route('all.navigation') }}",--}}
    {{--    --}}{{--columns: [--}}
    {{--    --}}{{--    { data: 'id' },--}}
    {{--    --}}{{--    { data: 'name' },--}}
    {{--    --}}{{--    { data: 'url' },--}}
    {{--    --}}{{--    { data: 'parentname' },--}}
    {{--    --}}{{--    {--}}
    {{--    --}}{{--        "data": null, "sortable": false, "class": "text-left padding-5",--}}
    {{--    --}}{{--        "render": function (data, type, full) {--}}
    {{--    --}}{{--            if (full["display"] == 1) {--}}
    {{--    --}}{{--                return '<p>'+'Active'+'</p>';--}}
    {{--    --}}{{--            } else {--}}
    {{--    --}}{{--                return '<p>'+'Inactive'+'</p>';--}}
    {{--    --}}{{--            }--}}
    {{--    --}}{{--        }--}}
    {{--    --}}{{--    },--}}
    {{--    --}}{{--    {--}}
    {{--    --}}{{--        "data": null, "sortable": false, "class": "text-left padding-5",--}}
    {{--    --}}{{--        "render": function (data, type, full) {--}}
    {{--    --}}{{--            return "<button class='btn btn-warning btn-sm btn-edit' data-target='#navigationForm' data-toggle='modal' data-toggle='Edit Nav' data-original-title='Edit Nav' onclick='getEditData("+full['id']+")'>Edit</button> <button class='btn btn-danger btn-sm btn-del' onclick='getDeleteData("+full['id']+")'>Delete</button>";--}}
    {{--    --}}{{--        }--}}
    {{--    --}}{{--    },--}}
    {{--    --}}{{--],--}}
    {{--});--}}

</script>
</body>
</html>
