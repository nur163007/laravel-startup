@extends('admin.main')
@section('title','privilege')
@section('css')
{{--    <link href="{{ URL::asset('assets/plugins/morris/morris.css')}}" rel="stylesheet">--}}
{{--    <link href="{{ URL::asset('assets/plugins/rating/rating.css')}}" rel="stylesheet">--}}
    <style>
        .roleList {
            font-size: 15px;
        }

        .hiddenTitle h1 {
            font-size: 25px;
            color: #DCDBDB;
        }

        .hiddenImage {
            margin-left: 240px;
            height: 250px;
            opacity: 0.2;
        }

        #userRole .selectedItem {
            display: block;
            height: 100%;
            width: 100%;
            line-height: 35px;
            color: black;
            box-sizing: border-box;
            border-top: 1px solid rgba(255, 255, 255, .1);
            border-bottom: 1px solid rgba(255, 255, 255, .1);
            border-radius: 0;
        }

        #userRole .active,#userRole .active a{
            background-color: #E7EEEC;
            color: black;
        }
    </style>
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">Dashboard</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Privilege</li>
        </ol>
    </div>
    <!-- PAGE-HEADER END -->
@endsection
@section('content')
    <!-- ROW-1 OPEN -->
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12">
            <div class="card">
                <div class="list-group list-group-transparent mb-0 mail-inbox">
                    <div class="mt-4 mb-4 ml-4 mr-4 text-right">
                        <button class="btn btn-secondary btn-md btn-block" data-target="#roleFormPriv"
                                data-toggle="modal"
                                data-original-title="New Role">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <span class="hidden-xs">New Role</span>
                        </button>
                    </div>
                    <ul style="width: 100%;" id="userRole">

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-12 col-sm-12">
            <!-- Modal -->
            <div class="modal fade" id="roleFormPriv" aria-hidden="true" aria-labelledby="exampleModalTitle"
                 role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Role Form</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    onclick="ResetFormPriv();">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="form-role-priv" name="form-role-priv" autocomplete="off">
                                @csrf
                                <div class="container-fluid">
                                    <input type="hidden" name="hiddenRoleId" id="hiddenRoleId" value="0">
                                    <div class="row mt-3">
                                        <label class="col-md-3 control-label">Name :</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name"
                                                   placeholder="give role name">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <label class="col-md-3 control-label">Description :</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="description" id="description" cols="30"
                                                      rows="5" placeholder="Write something..."></textarea>
                                        </div>
                                    </div>

                                    <hr/>
                                    <div class="model-footer text-right">
                                        <label class="wc-error pull-left" id="form_error"></label>
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary mr-3"
                                               id="btnRoleFormSubmit">
                                        {{--                                        <button type="button" class="btn btn-primary mr-3" id="btnUserFormSubmit" >Submit</button>--}}
                                        <button type="button" class="btn btn-default btn-outline" data-dismiss="modal"
                                                aria-label="Close" onclick="ResetFormPriv();">Close
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->

            <div class="card">
                <div class="card-header mb-3">
                    <div class="col-lg-12 hiddenTitle text-center">
                        <h1 class="card-title">Please select a role to view privilege list</h1>
                    </div>
                    <div class="col-lg-6 showTitle">
                        <h4 class="card-title">Privilege list of<span class="ml-2 roleName"></span></h4>
                    </div>
                </div>
                <div class="card-body pt-0">

                    <img src="{{asset('assets/images/logos/nodata.jpg')}}" class="hiddenImage" alt="">

                    <table id="privilege-table"
                           class="table table-bordered table-hover dataTable table-striped width-full table-sm">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Url</th>
                            <th class="text-center" style="width:80px;">Enable</th>
                        </tr>
                        </thead>
                        <tbody id="all-privilege">

                        </tbody>
                    </table>

                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- ROW-1 CLOSED -->

@endsection
@section('js')

    <script type="text/javascript">

        function ResetFormPriv() {
            $('#form-role-priv')[0].reset();
        }

        $("#privilege-table").hide();
        $(".hiddenTitle").show();
        $(".hiddenImage").show();
        $(".showTitle").hide();

        $(document).ready(function () {

            //role submit
            $('#form-role-priv').on("submit", function (event) {
                event.preventDefault();
                var form = $(this).serialize();
                $.ajax({
                    url: "{{route('role.store')}}",
                    data: form,
                    type: "POST",
                    success: function (response) {

                        if (response.success == true) {
                            $("#form-role-priv")[0].reset();
                            $('#roleFormPriv').modal('hide');
                            Toast.fire({
                                type: 'success',
                                title: response.msg,
                            });
                            getRole();
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

            //get all role
            getRole();

        });

        //get all role
        function getRole() {
            $.ajax({
                url: "{{ route('all.role') }}",
                type: "GET",
                success: function (response) {
                    var data = JSON.stringify(response.data)
                    var res = JSON.parse(data)

                    var html = '';
                    if (res.length > 0) {
                        for (let i = 0; i < res.length; i++) {
                            html += '<li><div class="row"><div class="col-sm-8 col-lg-8 col-8"> ' +
                                '<a class="list-group-item list-group-item-action d-flex align-items-center selectedItem" href="javascript:void(0)" onclick="loadPrivTable(' + res[i].id + ')">' +
                                '<span class="font-weight-bold">' + res[i].name + '</span></a></div>' +
                                '<div class="col-sm-4 col-lg-4 col-4 mt-4">' +
                                '<button class=\'btn btn-warning btn-sm btn-edit\' data-target=\'#roleFormPriv\' data-toggle=\'modal\' data-toggle=\'Edit Role\' data-original-title=\'Edit Role\' onclick=\'getEditRole(' + res[i].id + ')\'><i class="fa fa-pencil"></i> </button> ' +
                                '<button class=\'btn btn-danger btn-sm btn-del\' onclick=\'getDeleteRole(' + res[i].id + ')\'><i class="fa fa-trash"></i></button></div></div>'+
                                '</li>';
                        }
                    }
                    // console.log(html)
                    $("#userRole").html(html);
                }

            });
        }

        //    get privilege data
        function loadPrivTable(id) {

            $("#privilege-table").show();
            $(".hiddenTitle").hide();
            $(".hiddenImage").hide();
            $(".showTitle").show();

            var header = document.querySelector("#userRole").querySelectorAll("li");

            header.forEach(element => {
                element.addEventListener("click", function () {
                    header.forEach(nav => nav.classList.remove("active"))
                    this.classList.add("active")
                });
            });

            $('#privilege-table').DataTable({
                "ajax": {
                    "url": "{{route('show.privilege')}}",
                    "type": "GET",
                    "data": {
                        "roleid": id
                    }
                },
                columns: [
                    {"data": "id", "class": "text-center"},
                    {"data": "name"},
                    {"data": "url"},
                    {
                        "data": null, "sortable": false, "class": "text-center",
                        "render": function (data, type, full) {
                            $(".roleName").html(full['rolename']);
                            if (full['access'] == 0)
                                return '<button class="btn btn-sm btn-icon btn-flat btn-default" data-toggle="Enable" data-original-title="Enable" onclick="ChangeEnable(' + full['roleid'] + ', ' + full['id'] + ', 1)"><i class="fa fa-check" style="color:lightgray;font-size: 15px;" aria-hidden="true"></i></button>';
                            else
                                return '<button class="btn btn-sm btn-icon btn-flat btn-default" data-toggle="Enable" data-original-title="Enable" onclick="ChangeEnable(' + full['roleid'] + ', ' + full['id'] + ', 0)"><i class="fa fa-check" style="color:limegreen;font-size: 15px;" aria-hidden="true"></i></button>';
                        }
                    }],
                "paging": true,
                "stateSave": true,
                "bDestroy": true
            });

        }

        function ChangeEnable(roleid, moduleid, action) {
            $.ajax({
                url: "{{ route('privilege.update') }}",
                type: "GET",
                data: {
                    "roleid": roleid,
                    "moduleid": moduleid,
                    "action": action,
                },
                success: function (response) {

                    if (response.success == true) {
                        Toast.fire({
                            type: 'success',
                            title: response.msg,
                        });
                        loadPrivTable(roleid)
                    }
                },
                error: function (error) {
                    Toast.fire({
                        type: 'error',
                        title: 'Something Error Found, Please try again.',
                    });
                }

            });
        }

    //     get edit data
        // edit option
        function getEditRole(id) {
            $.ajax({
                url: "{{ url('role-edit') }}/"+id,
                type: "GET",
                success: function (response) {

                    $("#hiddenRoleId").val(response.id);
                    $("#name").val(response.name);
                    $("#description").val(response.description);

                }

            });
        }

        //    DELETE OPTION
        function getDeleteRole(id) {
            var result = confirm("Are you sure to delete?");
            if(result){
                $.ajax({
                    url: "{{ url('role-delete') }}/"+id,
                    type: "DELETE",
                    success: function (response) {
                        if(response.success == true){
                            Toast.fire({
                                type:'success',
                                title:response.msg,
                            });
                            getRole();
                            location.reload();
                        }
                        else if(response.success == false){
                            Toast.fire({
                                type:'error',
                                title:response.msg,
                            });
                            getRole();
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

@endsection
