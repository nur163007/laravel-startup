@extends('admin.main')
@section('title','navigation')
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
            <li class="breadcrumb-item active" aria-current="page">Navigation</li>
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
                            <h3 class="card-title">All Navigation</h3>
                        </div>
                        <div class="col-lg-6 text-right">
                            <button class="btn btn-info"  data-target="#navigationForm" data-toggle="modal" data-original-title="Add New navigation" onclick="ResetForm();">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                <span class="hidden-xs">Add New Navigation</span>
                            </button>
                        </div>
                </div>
                <div class="card-body">
{{--                    Search: <input type="text" id="myInput" onkeyup="searchData();" placeholder="Search for names.." title="Type in a name">--}}
                    <table id="navigation-table" class="table table-hover dataTable table-striped width-full">
                        <thead>
                        <tr>
                            <th>SL NO</th>
                            <th>NAME</th>
                            <th>URL</th>
                            <th>PARENT</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody id="all-nav">

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- COL END -->

        <!-- Modal -->
        <div class="modal fade" id="navigationForm" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
            <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Navigation Form</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ResetForm();">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form  id="form-navigation" name="form-navigation" autocomplete="off" >
                                @csrf
                            <div class="container-fluid">
                                <input type="hidden" name="hiddenNavId" id="hiddenNavId" value="0">
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Name :</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="give module name">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Url :</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="url" name="url" placeholder="give url"/>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Icon:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="icon" name="icon" placeholder="give icon name" />
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Parent:</label>
                                    <div class="col-md-9 wrap-input100 validate-input">
                                        <select class="form-control"  name="parent" id="parent" placeholder="select parent">
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Display: </label>
                                    <div class="col-md-9">
                                        <div class="checkbox-custom checkbox-primary">
                                            <input type="checkbox" id="display" name="display" checked />
                                            <label for="display"></label>
                                        </div>
                                    </div>
                                </div>
                                    <hr />
                                    <div class="model-footer text-right">
                                        <label class="wc-error pull-left" id="form_error"></label>
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary mr-3" id="btnNavFormSubmit">
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
            $('#form-navigation')[0].reset();
        }

        $(document).ready(function () {

            $('#navigation-table').DataTable({
                ajax:"{{ route('all.navigation') }}",
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'url' },
                    { data: 'parentname' },
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            if (full["display"] == 1) {
                                return '<p>'+'Active'+'</p>';
                            } else {
                                return '<p>'+'Inactive'+'</p>';
                            }
                        }
                    },
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            return "<button class='btn btn-warning btn-sm btn-edit' data-target='#navigationForm' data-toggle='modal' data-toggle='Edit Nav' data-original-title='Edit Nav' onclick='getEditData("+full['id']+")'>Edit</button> <button class='btn btn-danger btn-sm btn-del' onclick='getDeleteData("+full['id']+")'>Delete</button>";
                        }
                    },
                ],
            });

        });

        // PARENT NAV ROUTE
        $.ajax({
            url: "{{ route('parent') }}",
            type: "GET",
            success: function (response) {
                // console.log(response)
                var html = '<option value=""> choose a parent</option>';
                if (response.length >0){
                    for (let i=0;i<response.length; i++){
                        html +='<option value="'+response[i]['id']+'">'+response[i]['name']+'</option>';
                    }
                }

                $("#parent").html(html);
            }

        });


    //    navigation submit

        $('#form-navigation').on("submit",function(event){
            event.preventDefault();
            var form = $(this).serialize();
            $.ajax({
                url:"{{route('add.navigation')}}",
                data:form,
                type:"POST",
                success:function(response){

                    if (response.success == true){
                        $("#form-navigation")[0].reset();
                        $('#navigationForm').modal('hide');
                        Toast.fire({
                            type:'success',
                            title:response.msg,
                        });
                        getSidebar(1);
                        $('#navigation-table').DataTable().ajax.reload();
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

    // //    search option
    //     function searchData() {
    //         var input, filter, table, tr, td, i, txtValue;
    //         input = document.getElementById("myInput");
    //         filter = input.value.toUpperCase();
    //         table = document.getElementById("navigation-table");
    //         tr = table.getElementsByTagName("tr");
    //         for (i = 0; i < tr.length; i++) {
    //             td = tr[i].getElementsByTagName("td")[1];
    //             if (td) {
    //                 txtValue = td.textContent || td.innerText;
    //                 if (txtValue.toUpperCase().indexOf(filter) > -1) {
    //                     tr[i].style.display = "";
    //                 } else {
    //                     tr[i].style.display = "none";
    //                 }
    //             }
    //         }
    //     }

    // edit option
        function getEditData(id) {
            $.ajax({
                url: "{{ url('navigation-edit') }}/"+id,
                type: "GET",
                success: function (response) {

                    $("#hiddenNavId").val(response.id);
                    $("#name").val(response.name);
                    $("#url").val(response.url);
                    $("#icon").val(response.icon);
                    $("#parent").val(response.parent).change();

                    if(response.display !=1){
                        $('#display').removeAttr('checked');
                    } else {
                        $('#display').attr('checked','checked');
                    }

                }

            });
        }

        //    DELETE OPTION
        function getDeleteData(id) {
            var result = confirm("Are you sure to delete?");
            if(result){
                $.ajax({
                    url: "{{ url('navigation-delete') }}/"+id,
                    type: "DELETE",
                    success: function (response) {
                        console.log(response)
                        if(response.success == true){
                            Toast.fire({
                                type:'success',
                                title:response.msg,
                            });
                            getSidebar(1);
                            $('#navigation-table').DataTable().ajax.reload();
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
