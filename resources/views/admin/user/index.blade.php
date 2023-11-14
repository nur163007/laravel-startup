@extends('admin.main')
@section('title','User')
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
            <li class="breadcrumb-item active" aria-current="page">User</li>
        </ol>
    </div>
    <!-- PAGE-HEADER END -->
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="col-lg-6">
                        <h3 class="card-title">All Users</h3>
                    </div>
                    <div class="col-lg-6 text-right">
                        <button class="btn btn-info"  data-target="#userForm" data-toggle="modal" data-original-title="Add New user" onclick="ResetForm();">
                            <i class="fa fa-user-plus"></i>
                            <span class="hidden-xs">Add User</span>
                        </button>
                    </div>
                </div>

{{--                @include('admin.includes.message')--}}

                <div class="card-body">
{{--                    Search: <input type="text" id="myInput" onkeyup="searchData();" placeholder="Search for names.." title="Type in a name">--}}
                    <table id="all-user" class="table table-hover dataTable table-striped width-full">
                        <thead class="bg-white">
                        <tr>
                            <th>SL NO</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Description</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="get-user">

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="userForm" aria-hidden="true" aria-labelledby="myLargeModalLabel" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">User Form</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ResetForm();">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form  id="form-user" name="form-user" autocomplete="off" >
                                @csrf
                                <div class="container-fluid">
                                    <input type="hidden" name="hiddenUserId" id="hiddenUserId" value="0">
                                    <div class="row">
                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">First Name :</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="give first name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">Last Name :</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="give last name">
                                            </div>
                                        </div>
{{--                                        <div class="col-md-6 row mt-3">--}}
{{--                                            <label class="col-md-4 control-label">Username/Email :</label>--}}
{{--                                            <div class="col-md-8">--}}
{{--                                                <input type="text" class="form-control" name="username" id="username" placeholder="give user name" required>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">Email :</label>
                                            <div class="col-md-8">
                                                <input type="email" class="form-control" name="email" id="email" placeholder="give email" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">Password :</label>
                                            <div class="col-md-8">
                                                <input type="password" class="form-control" name="password" id="password" placeholder="give password" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">Mobile :</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="give mobile no">
                                            </div>
                                        </div>
                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">Role :</label>
                                            <div class="col-md-8">
                                                <select class="form-control"  name="role" id="role" placeholder="select role" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">DOB :</label>
                                            <div class="col-md-8">
                                                <input type="date" class="form-control" name="dob" id="dob" placeholder="date of birth">
                                            </div>
                                        </div>
                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">Company :</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="company" id="company" placeholder="give company name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">Department :</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="department" id="department" placeholder="give department">
                                            </div>
                                        </div>
                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">Designation :</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="designation" id="designation" placeholder="give designation">
                                            </div>
                                        </div>
                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">NID :</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="nid" id="nid" placeholder="give nid no">
                                            </div>
                                        </div>
                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">Passport :</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="passport" id="passport" placeholder="give passport no">
                                            </div>
                                        </div>
                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">Address Line1 :</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="address1" id="address1" placeholder="give address">
                                            </div>
                                        </div>
                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">Address Line2 :</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="address2" id="address2" placeholder="give address">
                                            </div>
                                        </div>
                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">State :</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="state" id="state" placeholder="give state">
                                            </div>
                                        </div>
                                        <div class="col-md-6 row mt-3">
                                            <label class="col-md-4 control-label">Country :</label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="country" id="country" placeholder="select country" required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="model-footer text-right">
                                        <label class="wc-error pull-left" id="form_error"></label>
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary mr-3" id="btnUserFormSubmit">
                                        <button type="button" class="btn btn-default btn-outline" data-dismiss="modal" aria-label="Close" onclick="ResetForm();">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->
        </div>
    </section>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {

            //get all users data

            $('#all-user').DataTable({
                ajax:"{{ route('view.alluser') }}",
                columns: [
                    { data: 'id' },
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                                return '<p>'+full['first_name']+ ' '+full['last_name']+ '</p>'
                        }
                    },
                    { data: 'username' },
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            if(data.company != null){
                                $company ="company: "+ data.company;
                            }else{
                                $company ="company: "+"";
                            } if (data.department != null){
                                $department ="department: "+data.department;
                            }else{
                                $department = "department: "+"";
                            } if (data.designation != null){
                                $designation ="designation: "+data.designation;
                            }else{
                                $designation = "designation: "+"";
                            } if (data.mobile != null){
                                $mobile ="mobile: "+data.mobile;
                            }else{
                                $mobile = "mobile: "+"";
                            }if (data.address1 != null && data.address2 != null){
                                $address = "address: "+data.address1 +' ' +data.address2;
                            }else if(data.address1 != null){
                                $address = "address: "+data.address1;
                            }else if(data.address2 != null){
                                $address = "address: "+data.address2;
                            } else{
                                $address = "address: "+"";
                            }
                            return '<p>'+$company +"<br>"+$department+"<br>"+$designation+"<br>"+"email: "+data.email+"<br>"+$mobile+"<br>"+$address+ '</p>'
                        }
                    },
                    { data: 'rolename' },
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            return "<button class='btn btn-warning btn-sm btn-edit' data-target='#userForm' data-toggle='modal' data-toggle='Edit User' data-original-title='Edit User' onclick='getEditUser("+full['id']+")'>Edit</button> <button class='btn btn-danger btn-sm btn-del' onclick='getDeleteUser("+full['id']+")'>Delete</button>";
                        }
                    },
                ],
            });
        });


        function ResetForm() {
            $('#form-user')[0].reset();
        }

    //    Country code select option
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

    //    Role select option
        $.ajax({
            url: "{{ route('role') }}",
            type: "GET",
            success: function (response) {
                var html = '<option value=""> choose a role</option>';
                if (response.length >0){
                    for (let i=0;i<response.length; i++){
                        html +='<option value="'+response[i]['id']+'">'+response[i]['name']+'</option>';
                    }
                }

                $("#role").html(html);
            }
        });

    //    user data submit
        $('#form-user').on("submit",function(event){
            event.preventDefault();
            var form = $(this).serialize();
            $.ajax({
                url:"{{route('user.store')}}",
                data:form,
                type:"POST",
                success:function(response){

                    if (response.success == true){
                        $("#form-user")[0].reset();
                        $('#userForm').modal('hide');
                        Toast.fire({
                            type:'success',
                            title:response.msg,
                        });
                        $('#all-user').DataTable().ajax.reload();
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

        // edit user data option
        function getEditUser(id) {
            $("#password").attr("required", false);
            $.ajax({
                url: "{{ url('user-edit') }}/"+id,
                type: "GET",
                success: function (response) {
                    let user = response.user;

                    $("#hiddenUserId").val(user.id);
                    $("#firstname").val(user.first_name);
                    $("#lastname").val(user.last_name);
                    $("#email").val(user.email);
                    $("#mobile").val(user.mobile);
                    $("#role").val(user.role).change();
                    $("#dob").val(user.dob);
                    $("#company").val(user.company);
                    $("#department").val(user.department);
                    $("#designation").val(user.designation);
                    $("#nid").val(user.nid);
                    $("#passport").val(user.passport);
                    $("#address1").val(user.address1);
                    $("#address2").val(user.address2);
                    $("#state").val(user.state);
                    $("#country").val(user.country).change();

                }

            });
        }

    //    user delete data option
        function getDeleteUser(id) {
            var result = confirm("Are you sure to delete?");
            if(result){
                $.ajax({
                    url: "{{ url('user-delete') }}/"+id,
                    type: "DELETE",
                    success: function (response) {
                        console.log(response)
                        if(response.success == true){
                            Toast.fire({
                                type:'success',
                                title:response.msg,
                            });
                            $('#all-user').DataTable().ajax.reload();
                        }

                    },
                    error:function(error){
                        Toast.fire({
                            type:'error',
                            title:'Something Error Found, Please try again.',
                        });
                    }

                });
            }
        }
    </script>

    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

@endsection

