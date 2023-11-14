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
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
    </div>
    <!-- PAGE-HEADER END -->
@endsection

@section('content')

    <!-- ROW-1 OPEN -->
    <div class="row" id="user-profile">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="wideget-user">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="wideget-user-desc d-sm-flex">
                                    <div class="wideget-user-img userpic  brround" style="height: 130px;width: 130px;box-shadow: 0 3px 10px 0 rgba(0,0,0,.15);">
                                        <img src=""  alt="" class="rounded-circle getUserProfile" style="height: 130px;width: 130px;">
                                    </div>
                                    <div class="user-wrap ml-3">
                                        <h4 class="getFullName"></h4>
                                        <h6 class="text-muted mb-3">Member Since: <span class="memberShip"></span></h6>
                                        <a href="{{route('user.editProfile')}}" class="btn btn-primary mt-1 mb-1"><i class="fa fa-edit"></i> Edit profile</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="border-top">
                    <div class="wideget-user-tab">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu1">
                                <ul class="nav">
                                    <li class=""><a href="#profile" class="active show" data-toggle="tab">Profile</a></li>
                                    <li><a href="#security" data-toggle="tab" class="">Security</a></li>
                                    <li><a href="#documents" data-toggle="tab" class="">Documents</a></li>
                                    <li  id="posPayment"><a href="#payment" data-toggle="tab" class="">Payments</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="border-0">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="profile">
                                <div id="profile-log-switch">
                                    <div class="media-heading">
                                        <h5><strong>Personal Information</strong></h5>
                                        <hr>
                                    </div>
                                    <div class="table-responsive ">
                                        <table class="table row table-borderless">
                                            <tbody class="col-lg-12 col-xl-6 p-0">
                                            <tr>
                                                <td><strong>Full Name :</strong> <span class="getFullName"></span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Company :</strong> <span class="getCompany"></span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email :</strong> <span class="getEmail"></span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Mobile :</strong> <span class="getMobile"></span></td>
                                            </tr>
                                            </tbody>
                                            <tbody class="col-lg-12 col-xl-6 p-0">
                                            <tr>
                                                <td><strong>Address :</strong> <span class="getAddress"></span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>National ID :</strong> <span class="getNid"></span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="security">
                                <div class="media-heading">
                                    <h5><strong>Security Information</strong></h5>
                                    <hr>
                                </div>
                                <div class="table-responsive ">
                                    <table class="table row table-borderless">
                                        <tbody class="col-lg-12 col-xl-6 p-0">
                                        <tr>
                                            <td><strong>Username :</strong> <span class="getuserName"></span></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="documents">
                                <div class="media-heading">
                                    <h5><strong>NID documents</strong></h5>
                                    <hr>
                                </div>
                                <div class="row mb-5">
                                    <div class="bg-white mainDiv">
                                        <img src="" alt="FRONT PAGE OF NATIONAL ID" id="showNIDFront">
                                    </div>
                                    <div class="bg-white mainDiv">
                                        <img src="" alt="BACK PAGE OF NATIONAL ID" id="showNIDBack">
                                    </div>
                                </div>
                                <div class="media-heading">
                                    <h5><strong>Additional documents</strong></h5>
                                    <hr>
                                </div>
                            </div>
                            <div class="tab-pane" id="payment">
                                <div class="media-heading">
                                    <h4><strong>Payment history</strong></h4><br>
                                </div>
                                <table id="user_payment_history" class="table table-hover dataTable table-striped width-full">
                                    <thead>
                                    <tr>
                                        <th>Package</th>
                                        <th>Billing period</th>
                                        <th>Amount</th>
                                        <th>Payment date</th>
                                    </tr>
                                    </thead>
                                    <tbody id="individual-payment-data">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- ROW-1 CLOSED -->

@endsection
