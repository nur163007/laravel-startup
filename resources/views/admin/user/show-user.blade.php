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
                    <div style="margin-bottom: 50px;">
                        <div class="wideget-user-tab">
                            <div class="tab-menu-heading">
                                <div class="tabs-menu1">
                                    <ul class="nav">
                                        <li class=""><a href="#profile" class="active show" data-toggle="tab">Profile</a></li>
                                        <li><a href="#security" data-toggle="tab" class="">Security</a></li>
                                        <li><a href="#documents" data-toggle="tab" class="">Documents</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-0">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="profile">
                                <input type="hidden" id="hiddenUserId" value="{{$id}}">
                                <div id="profile-log-switch">
                                    <div class="media-heading">
                                        <h5><strong>Personal Information</strong></h5>
                                        <hr>
                                    </div>
                                    <div class="table-responsive ">
                                        <table class="table row table-borderless">
                                            <tbody class="col-lg-12 col-xl-6 p-0">
                                            <tr>
                                                <td><strong>Full Name :</strong> <span id="fullNameId"></span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Company :</strong> <span id="companyNameId"></span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email :</strong> <span id="emailId"></span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Mobile :</strong> <span id="mobileId"></span></td>
                                            </tr>
                                            </tbody>
                                            <tbody class="col-lg-12 col-xl-6 p-0">
                                            <tr>
                                                <td><strong>Address :</strong> <span id="addressId"></span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>National ID :</strong> <span id="nidId"></span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="wideget-user-img userpic" style="height: 130px;width: 130px;border: 1px solid black">
                                                        <img src=""  alt="" id="getProfilePic" style="height: 130px;width: 130px;">
                                                    </div>
                                                </td>
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
                                            <td><strong>Username :</strong> <span id="userNameId"></span></td>
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
                                        <img src="" alt="FRONT PAGE OF NATIONAL ID" id="userNIDFront">
                                    </div>
                                    <div class="bg-white mainDiv">
                                        <img src="" alt="BACK PAGE OF NATIONAL ID" id="userNIDBack">
                                    </div>
                                </div>
                                <div class="media-heading">
                                    <h5><strong>Additional documents</strong></h5>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success" onclick="userAccept()">Accept</button>
                    <button type="button" class="btn btn-danger" data-target="#rejectUserForm" data-toggle="modal" data-original-title="Reject user">Reject</button>
                    <button type="button" class="btn btn-info pull-right" onclick="getBack();">Back</button>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="rejectUserForm" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Rejection Cluase</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ResetReject();">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form  id="form-reject-user" autocomplete="off" >
                                @csrf
                                <div class="container-fluid">
                                    <input type="hidden" name="hiddenCustomerId" id="hiddenCustomerId" value="{{$id}}">
                                    <div class="row mt-3">
                                        <label class="col-md-2 control-label">Reason :</label>
                                        <div class="col-md-10">
                                            <textarea class="form-control" rows="5" cols="40" name="admin_comments" id="admin_comments" placeholder="Write the rejection cause..." required></textarea>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="model-footer text-right">
                                        <label class="wc-error pull-left" id="form_error"></label>
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary mr-3" id="btnRejectSubmit">
                                        <button type="button" class="btn btn-default btn-outline" data-dismiss="modal" aria-label="Close" onclick="ResetReject();">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->
        </div><!-- COL-END -->
    </div>
    <!-- ROW-1 CLOSED -->
@endsection

@section('js')
<script type="text/javascript">

    // VIEW INDIVIDUAL USER PROFILE
    $.ajax({
        url: "{{ url('/individual-users-profile') }}/"+$("#hiddenUserId").val(),
        type: "GET",
        dataType: "json",
        success: function (response) {
            // console.log(response)
            let r = JSON.stringify(response.data);
            var data = JSON.parse(r);
            //
            // console.log(r)
            $("#fullNameId").html(data[0].first_name+' '+data[0].last_name);
            $("#companyNameId").html(data[0].company);
            $("#emailId").html(data[0].email);
            $("#mobileId").html(data[0].mobile);
            $("#addressId").html(data[0].address +','+data[0].city+'-'+data[0].zip_code+','+data[0].country);
            $("#nidId").html(data[0].nid);
            $("#getProfilePic").attr("src","{{asset('assets/images/users/profile')}}/"+data[0].avatar);
            $("#userNameId").html(data[0].username);

            $("#userNIDFront").attr("src","{{asset('documents/nid/front')}}/"+data[0].front_part);
            $("#userNIDBack").attr("src","{{asset('documents/nid/back')}}/"+data[0].back_part);
        }

    });

    // ACCEPT USER REQUEST
    function userAccept() {
        let id =$("#hiddenUserId").val();
        $.ajax({
            url: "{{ url('user/accept/data') }}/"+id,
            type: "GET",
            success: function (response) {
                if (response.success == true){
                    window.location.assign(base_url+"/dashboard");
                }
            }

        });
    }

    function ResetReject() {
        $('#form-reject-user')[0].reset();
        $('#rejectUserForm').modal('hide');
    }
    function getBack() {
        window.location.assign(base_url+"/dashboard");
    }

    //REJECT USER REQUEST
    $('#form-reject-user').on("submit",function(event){
        event.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            url:"{{route('user.rejection.data')}}",
            data:form,
            type:"POST",
            success:function(response){

                if (response.success == true){
                    $("#form-reject-user")[0].reset();
                    $('#rejectUserForm').modal('hide');
                    Toast.fire({
                        type:'success',
                        title:response.msg,
                    });
                    window.location.assign(base_url+"/dashboard");
                }
            },
            error:function(error){
                Toast.fire({
                    type:'error',
                    title:'Something Error Found, Please try again.',
                });
            }
        });
    });


</script>
@endsection
