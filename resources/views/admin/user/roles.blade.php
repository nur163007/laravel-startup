@extends('admin.main')
@section('title','role')
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
            <li class="breadcrumb-item active" aria-current="page">Role</li>
        </ol>
    </div>
    <!-- PAGE-HEADER END -->
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-lg-6">
                        <h3 class="card-title">All Roles</h3>
                    </div>
                    <div class="col-lg-6 text-right">
                        <button class="btn btn-info"  data-target="#roleForm" data-toggle="modal" data-original-title="Add New role" onclick="ResetForm();">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <span class="hidden-xs">Add New Role</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
{{--                    Search: <input type="text" id="myInput" onkeyup="searchData();" placeholder="Search for names.." title="Type in a name">--}}
                    <table id="role-table" class="table table-hover dataTable table-striped width-full">
                        <thead>
                        <tr>
                            <th>SL NO</th>
                            <th>NAME</th>
                            <th>DESCRIPTION</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody id="all-roles">

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- COL END -->

        <!-- Modal -->
        <div class="modal fade" id="roleForm" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Role Form</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ResetForm();">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form  id="form-role" name="form-role" autocomplete="off" >
                            @csrf
                            <div class="container-fluid">
                                <input type="hidden" name="hiddenRoleId" id="hiddenRoleId" value="0">
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Name :</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="give role name">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Description :</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="description" id="description" cols="30" rows="5" placeholder="Write something..."></textarea>
                                    </div>
                                </div>

                                <hr />
                                <div class="model-footer text-right">
                                    <label class="wc-error pull-left" id="form_error"></label>
                                    <input type="submit" name="submit" value="Submit" class="btn btn-primary mr-3" id="btnRoleFormSubmit">
                                    {{--                                        <button type="button" class="btn btn-primary mr-3" id="btnUserFormSubmit" >Submit</button>--}}
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

@endsection
@section('js')

    <script type="text/javascript">

        function ResetForm() {
            $('#form-role')[0].reset();
        }

        $(document).ready(function () {

            // get role data

            $('#role-table').DataTable({
                ajax:"{{ route('all.role') }}",
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'description' },
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            return "<button class='btn btn-warning btn-sm btn-edit' data-target='#roleForm' data-toggle='modal' data-toggle='Edit Role' data-original-title='Edit Role' onclick='getEditRole("+data.id+")'>Edit</button> <button class='btn btn-danger btn-sm btn-del' onclick='getDeleteRole("+data.id+")'>Delete</button>";
                        }
                    },
                ],
            });

        });

        //    role submit

        $('#form-role').on("submit",function(event){
            event.preventDefault();
            var form = $(this).serialize();
            $.ajax({
                url:"{{route('role.store')}}",
                data:form,
                type:"POST",
                success:function(response){

                    if (response.success == true){
                        $("#form-role")[0].reset();
                        $('#roleForm').modal('hide');
                        Toast.fire({
                            type:'success',
                            title:response.msg,
                        });
                        $('#role-table').DataTable().ajax.reload();
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


        // edit role option
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

        //    DELETE ROLE OPTION
        function getDeleteRole(id) {
            var result = confirm("Are you sure to delete?");
            if(result){
                $.ajax({
                    url: "{{ url('role-delete') }}/"+id,
                    type: "DELETE",
                    success: function (response) {
                        console.log(response)
                        if(response.success == true){
                            Toast.fire({
                                type:'success',
                                title:response.msg,
                            });
                            $('#role-table').DataTable().ajax.reload();
                        }
                        else if(response.success == false){
                            Toast.fire({
                                type:'error',
                                title:response.msg,
                            });
                            $('#role-table').DataTable().ajax.reload();
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
