@extends('admin.main')
@section('title','lookup')
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
            <li class="breadcrumb-item active" aria-current="page">Lookup</li>
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
                        <h3 class="card-title">All Lookup</h3>
                    </div>
                    <div class="col-lg-6 text-right">
                        <button class="btn btn-info"  data-target="#lookupForm" data-toggle="modal" data-original-title="Add New lookup" onclick="ResetForm();">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <span class="hidden-xs">Add New Lookup</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="lookup-table" class="table table-hover dataTable table-striped width-full">
                        <thead>
                        <tr>
                            <th>SL NO</th>
                            <th>NAME</th>
                            <th>DESCRIPTION</th>
                            <th>PARENT</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody id="all-lookups">

                        </tbody>
                    </table>
                    {{--                    <div class="mt-3" style="margin-right: 40px">--}}
                    {{--                        <button id="prevButton" style="border: 1px solid black">Previous</button>--}}
                    {{--                        <button id="nextButton" style="border: 1px solid black">Next</button>--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div><!-- COL END -->

        <!-- Modal -->
        <div class="modal fade" id="lookupForm" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Lookup Form</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ResetForm();">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form  id="form-lookup" name="form-lookup" autocomplete="off" >
                            @csrf
                            <div class="container-fluid">
                                <input type="hidden" name="hiddenLookupId" id="hiddenLookupId" value="0">
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Name :</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="give workgroup name">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Description :</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="description" id="description" cols="30" rows="5" placeholder="Write something..."></textarea>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Parent:</label>
                                    <div class="col-md-9 wrap-input100 validate-input">
                                        <select class="form-control"  name="lookupparent" id="lookupparent" placeholder="select parent">
                                        </select>
                                    </div>
                                </div>
                                <hr />
                                <div class="model-footer text-right">
                                    <label class="wc-error pull-left" id="form_error"></label>
                                    <input type="submit" name="submit" value="Submit" class="btn btn-primary mr-3" id="btnLookupForm">
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
            $('#form-lookup')[0].reset();
        }

        $(document).ready(function () {
            $('#lookup-table').DataTable({
                ajax:"{{ route('all.lookup') }}",
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'description' },
                    { data: 'parentname' },
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            return "<button class='btn btn-warning btn-sm btn-edit' data-target='#lookupForm' data-toggle='modal' data-toggle='Edit Lookup' data-original-title='Edit Lookup' onclick='getEditLookup("+full['id']+")'>Edit</button> <button class='btn btn-danger btn-sm btn-del' onclick='getDeleteLookup("+full['id']+")'>Delete</button>";
                        }
                    },
                ],
            });

        });

        // PARENT NAV ROUTE
        $.ajax({
            url: "{{ route('lookup.parent') }}",
            type: "GET",
            success: function (response) {
                // console.log(response)
                var html = '<option value=""> choose a parent</option>';
                if (response.length >0){
                    for (let i=0;i<response.length; i++){
                        html +='<option value="'+response[i]['id']+'">'+response[i]['name']+'</option>';
                    }
                }

                $("#lookupparent").html(html);
            }

        });


        //    navigation submit

        $('#form-lookup').on("submit",function(event){
            event.preventDefault();
            var form = $(this).serialize();
            $.ajax({
                url:"{{route('add.lookup')}}",
                data:form,
                type:"POST",
                success:function(response){

                    if (response.success == true){
                        $("#form-lookup")[0].reset();
                        $('#lookupForm').modal('hide');
                        Toast.fire({
                            type:'success',
                            title:response.msg,
                        });
                        $('#lookup-table').DataTable().ajax.reload();
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

        // edit option
        function getEditLookup(id) {
            $.ajax({
                url: "{{ url('lookup-edit') }}/"+id,
                type: "GET",
                success: function (response) {

                    $("#hiddenLookupId").val(response.id);
                    $("#name").val(response.name);
                    $("#description").val(response.description);
                    $("#lookupparent").val(response.parent).change();

                }

            });
        }

        //    DELETE OPTION
        function getDeleteLookup(id) {
            var result = confirm("Are you sure to delete?");
            if(result){
                $.ajax({
                    url: "{{ url('lookup-delete') }}/"+id,
                    type: "DELETE",
                    success: function (response) {

                        if(response.success == true){
                            Toast.fire({
                                type:'success',
                                title:response.msg,
                            });
                            $('#lookup-table').DataTable().ajax.reload();
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
