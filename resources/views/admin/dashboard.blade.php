@extends('admin.main')
@section('title','dashboard')
@section('css')
    {{--    <link href="{{ URL::asset('assets/plugins/morris/morris.css')}}" rel="stylesheet">--}}
    {{--    <link href="{{ URL::asset('assets/plugins/rating/rating.css')}}" rel="stylesheet">--}}
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">Dashboard</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>
    <!-- PAGE-HEADER END -->
@endsection
@section('content')
    <div id="admin">
        @include('admin.individual_dashboard.admin_dashboard')
    </div>
    <div id="partner">
        @include('admin.individual_dashboard.partner_dashboard')
    </div>
    <div id="pos">
        @include('admin.individual_dashboard.pos_dashboard')
    </div>
@endsection
@section('js')

    <script type="text/javascript">

        $(document).ready(function () {
            let getUser = localStorage.getItem("userData");

            var data = JSON.parse(getUser);

            var isauthor = data.is_authorized;
            var isdocreject = data.is_doc_rejected;
            var userrole = data.role;
            var userId = data.id;

            $(".unauthoraisation").hide();
            $(".authorized").hide();
            $("#partner").hide();
            $("#pos").hide();
            $("#admin").hide();
            $("#posPayment").hide();
            $("#payment").hide();
            $(".hidePaymentBtn").show();


            if (userrole == 1) {
                $("#partner").hide();
                $("#pos").hide();
                $("#admin").show();
            } else if (userrole == 3) {
                $("#partner").show();
                $("#admin").hide();
                $("#pos").hide();
                if (isauthor == 1) {
                    $(".unauthoraisation").hide();
                    $(".authorized").show();
                } else {
                    $(".unauthoraisation").show();
                    $(".authorized").hide();
                    if (isdocreject == 0) {
                        $(".notReject").show();
                        $(".isReject").hide();
                    } else {
                        $(".notReject").hide();
                        $(".isReject").show();
                    }
                }
            } else if (userrole == 4) {
                $("#partner").hide();
                $("#admin").hide();
                $("#pos").show();
                if (isauthor == 1) {
                    $(".unauthoraisation").hide();
                    $(".authorized").show();
                } else {
                    $(".unauthoraisation").show();
                    $(".authorized").hide();
                    if (isdocreject == 0) {
                        $(".notReject").show();
                        $(".isReject").hide();
                    } else {
                        $(".notReject").hide();
                        $(".isReject").show();
                    }
                }
            }

            //list all registration data

            $('#verification_data_table').DataTable({
                ajax: "{{ route('all.dashboard.data') }}",
                columns: [
                    {data: 'id'},
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            return '<p>' + data.first_name + ' ' + data.last_name + '</p>';
                        }
                    },
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            if (full['role'] == 3) {
                                return '<p>Partner</p>';
                            } else if (full['role'] == 4) {
                                return '<p>POS Owner</p>';
                            }

                        }
                    },
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            return '<p>' + data.address + ',' + data.city + '-' + data.zip_code + ',' + data.country + '</p>';
                        }
                    },
                    {data: 'created_at'},
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            if (full["is_authorized"] == 1) {
                                return '<p class="text-success">' + 'Accepted all documents' + '</p>';
                            } else {
                                if (full["is_completed"] == 0) {
                                    return '<p class="text-warning">' + 'Pending Approval' + '</p>';
                                } else {
                                    if (full["is_doc_rejected"] == 0) {
                                        return '<p class="text-warning">' + 'Pending Approval' + '</p>';
                                    } else {
                                        return '<p class="text-danger">' + 'Reject the user Request' + '</p>';
                                    }
                                }
                            }
                        }
                    },
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            return "<button class='btn btn-info btn-sm' data-toggle='Edit User' data-original-title='Edit User' onclick='getShowUserProfile(" + full['id'] + ")'><i class='fa fa-edit'></i></button>";
                        }
                    },
                ],
            });

            //list of pending data

            $.ajax({
                url: "{{ url('/user/pos/dashboard/list') }}/" + userId,
                type: "GET",
                success: function (response) {

                    var list = '';
                    var res = response.userinfo;
                    if (response.success == true) {
                            if (userrole == 3) {
                                /*for (let i = 0; i < res.length - 1; i++) {
                                    if (res[i].registration_status == null) {
                                        list += '<li class="mt-2 ml-5"><i class="fa fa-times" style="color:red;font-size: 15px;" aria-hidden="true"></i> ' + res[i].name + '</li>';
                                    } else {
                                        list += '<li class="mt-2 ml-5"><i class="fa fa-check" style="color:limegreen;font-size: 15px;" aria-hidden="true"></i> ' + res[i].name + '</li>';
                                    }
                                }*/
                                if (res.registration_status == null){
                                    list += '<li class="mt-2 ml-5"><i class="fa fa-times" style="color:red;font-size: 15px;" aria-hidden="true"></i> Doument upload</li>' +
                                        '<li class="mt-2 ml-5"><i class="fa fa-times" style="color:red;font-size: 15px;" aria-hidden="true"></i> Admin Approval</li>';
                                }else if (res.registration_status == 2){
                                    list += '<li class="mt-2 ml-5"><i class="fa fa-check" style="color:limegreen;font-size: 15px;" aria-hidden="true"></i> Doument upload</li>' +
                                        '<li class="mt-2 ml-5"><i class="fa fa-times" style="color:red;font-size: 15px;" aria-hidden="true"></i> Admin Approval</li>';
                                }else if (res.registration_status == 3){
                                    list += '<li class="mt-2 ml-5"><i class="fa fa-check" style="color:limegreen;font-size: 15px;" aria-hidden="true"></i> Doument upload</li>' +
                                        '<li class="mt-2 ml-5"><i class="fa fa-check" style="color:limegreen;font-size: 15px;" aria-hidden="true"></i> Admin Approval</li>';
                                }

                            } else if (userrole == 4) {
                           /*     for (let i = 0; i < res.length; i++) {
                                    if (res[i].registration_status == null) {
                                        list += '<li class="mt-2 ml-5"><i class="fa fa-times" style="color:red;font-size: 15px;" aria-hidden="true"></i> ' + res[i].name + '</li>';
                                    } else {

                                        list += '<li class="mt-2 ml-5"><i class="fa fa-check" style="color:limegreen;font-size: 15px;" aria-hidden="true"></i> ' + res[i].name + '</li>';
                                    }
                                }*/
                                if (res.registration_status == null){
                                    list += '<li class="mt-2 ml-5"><i class="fa fa-times" style="color:red;font-size: 15px;" aria-hidden="true"></i> Doument upload</li>' +
                                        '<li class="mt-2 ml-5"><i class="fa fa-times" style="color:red;font-size: 15px;" aria-hidden="true"></i> Admin Approval</li>' +
                                        '<li class="mt-2 ml-5"><i class="fa fa-times" style="color:red;font-size: 15px;" aria-hidden="true"></i> Payment</li>';
                                }
                                else if (res.registration_status == 2){
                                    list += '<li class="mt-2 ml-5"><i class="fa fa-check" style="color:limegreen;font-size: 15px;" aria-hidden="true"></i> Doument upload</li>' +
                                        '<li class="mt-2 ml-5"><i class="fa fa-times" style="color:red;font-size: 15px;" aria-hidden="true"></i> Admin Approval</li>' +
                                        '<li class="mt-2 ml-5"><i class="fa fa-times" style="color:red;font-size: 15px;" aria-hidden="true"></i> Payment</li>';
                                }else if (res.registration_status == 3){
                                    list += '<li class="mt-2 ml-5"><i class="fa fa-check" style="color:limegreen;font-size: 15px;" aria-hidden="true"></i> Doument upload</li>' +
                                        '<li class="mt-2 ml-5"><i class="fa fa-check" style="color:limegreen;font-size: 15px;" aria-hidden="true"></i> Admin Approval</li>' +
                                        '<li class="mt-2 ml-5"><i class="fa fa-times" style="color:red;font-size: 15px;" aria-hidden="true"></i> Payment</li>';
                                }
                            }
                        $(".posAcountDashboard").html(list);
                    }

                }
            });

            // complete task after registration
            $.ajax({
                url: "{{ url('/user/pos/complete/payment') }}/" + userId,
                type: "GET",
                success: function (response) {
                    var res = response.data;
                    if (response.success == true) {
                        for (let i = 0; i < res.length; i++) {
                            if (res[i]['payment_date'] != null) {
                                $(".hidePaymentBtn").hide();
                            } else {
                                $(".hidePaymentBtn").show();
                            }
                        }
                    }
                }
            });

            //    in partner dashboard count users
            $.ajax({
                url: "{{ url('/user/partner/count/users') }}/" + userId,
                type: "GET",
                success: function (response) {
                    var activeUser = response.activeUser;
                    var suspend = response.suspendUser;

                    $(".activeUsers").html(activeUser)
                    $(".suspendUsers").html(suspend)

                }
            });
        });

        //individual profile show by admin
        function getShowUserProfile(id) {
            window.location.assign(base_url + "/user/profile/info/" + id);
        }


    </script>

@endsection
