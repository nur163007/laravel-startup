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
    <div class="row">
        <div class="col-lg-4 col-xl-4 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form id="profileImageForm" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center">
                            <div class="userprofile">
                                <input type="hidden" class="userid" name="userid">
                                <div class="userpic  brround" style="margin-bottom: 40px;">
                                    <img src="" alt="" class="userpicimg getUserProfile"
                                         style="height: 120px;width: 120px;">

                                    <label for="profileImage"
                                           style="margin-left: 120px; margin-bottom: 10px; font-size: 16px;"><i
                                            class="fa fa-camera"></i></label>
                                    <input type="file" name="avatar" id="profileImage" onchange="displayImage(this)"
                                           style="display: none;visibility: none;">

                                </div>
                                <h3 class="getFullName text-dark mb-2"></h3>
                                <p class="mb-1 text-muted getCompany"></p>

                            </div>
                        </div>
                        <input type="submit" name="submit" class="btn btn-success pull-right" id="updateImageId"
                               value="update">
                    </form>
                </div>
            </div>
            <div class="card">
                <form id="passwordChange">
                    @csrf
                    <div class="card-header">
                        <div class="card-title">Edit Password</div>
                    </div>
                    <div class="card-body">

                        <input type="hidden" class="userid" name="userid">

                        <div class="form-group">
                            <label class="form-label">Old Password</label>
                            <input type="password" class="form-control" name="oldpassword" id="oldpassword"
                                   placeholder="Given old password" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" name="newpassword" id="newpassword"
                                   placeholder="Given new password" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="confirmpassword" id="confirmpassword"
                                   placeholder="Given confirm password" required>
                        </div>
                    </div>
                    <div class="card-footer text-right">

                        <input type="submit" class="btn btn-success" name="submit" value="Change password">
                        <button type="button" class="btn btn-danger" onclick="ResetForm()">Cancel</button>
                    </div>
                </form>
            </div>

{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <form action="{{route('bkash-create-payment')}}" class="btn-image-form">--}}
{{--                        <button class="btn-image" type="submit">--}}
{{--                            <img src="{{asset('assets/images/logos/bkash_payment.png')}}" class="btn-icon" alt="bkash logo">--}}
{{--                        </button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}


        </div>
        <div class="col-lg-8 col-xl-8 col-md-12 col-sm-12">
            <div class="card">
                <form id="updateProfileData">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">Edit Profile</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" class="userid" name="userid">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputname">First Name</label>
                                    <input type="text" class="form-control" name="first_name" id="exampleInputFirstname"
                                           placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputname1">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" id="exampleInputLastname"
                                           placeholder="Enter Last Name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Company</label>
                                    <input type="text" class="form-control" name="company" id="exampleInputCompany"
                                           placeholder="Enter Company name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputnumber">Mobile Number</label>
                                    <input type="text" class="form-control" name="mobile" id="exampleInputnumber"
                                           placeholder="Enter mobile number">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" id="exampleInputAddress"
                                           placeholder="Enter Address">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">State</label>
                                    <input type="text" class="form-control" name="state" id="exampleInputState"
                                           placeholder="Enter State">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" name="city" id="exampleInputCity"
                                           placeholder="Enter City">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Zipcode</label>
                                    <input type="text" class="form-control" name="zip_code" id="exampleInputZipcode"
                                           placeholder="Enter Zipcode">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Country</label>
                                    <select class="form-control" name="country" id="country" aria-invalid="country"
                                            placeholder="select country">
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-success" name="submit" value="Save">
                        <button type="button" class="btn btn-danger" onclick="ResetDataForm()">Cancel</button>
                    </div>
                </form>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Documents</h3>
                </div>
                <div class="card-body">
                    <form id="nidUploadForm">
                        <div class="memberblock mb-0">
                            <div class="row ">
                                <input type="hidden" id="hiddenFront">
                                <input type="hidden" id="hiddenBack">
                                <div class="bg-white mainDiv">
                                    <img src="" alt="TAKE FRONT PAGE OF NATIONAL ID" id="showFrontNid">
                                    <input type="file" name="front_nid" id="front_nid" class="my_file"
                                           onchange="displayFrontPart(this)">
                                </div>
                                <div class="bg-white mainDiv" id="back_part">
                                    <img src="" alt="TAKE BACK PAGE OF NATIONAL ID" id="showBackNid">
                                    <input type="file" name="back_nid" id="back_nid" class="my_file"
                                           onchange="displayBackPart(this)">
                                </div>
                            </div>
                        </div>
                        <div id="uploadNidDiv" class="pull-right">
                            <input type="submit" name="submit" class="btn btn-success" id="uploadNidBtn" value="update">
                            <button type="button" class="btn btn-danger" onclick="ResetNIDForm()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- ROW-1 CLOSED -->
@endsection

