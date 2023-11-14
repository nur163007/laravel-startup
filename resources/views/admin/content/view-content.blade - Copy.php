@extends('admin.main')
@section('title','Content')
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
            <li class="breadcrumb-item active" aria-current="page">Content</li>
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
                        <h3 class="card-title">All Content</h3>
                    </div>
                    <div class="col-lg-6 text-right">
                        <button class="btn btn-info" data-target="#createContentForm" data-toggle="modal"
                                data-original-title="Add New Content" onclick="ResetContentForm();">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <span class="hidden-xs">Add New Content</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {{--                    Search: <input type="text" id="myInput" onkeyup="searchData();" placeholder="Search for names.." title="Type in a name">--}}
                    <table id="content-table" class="table table-hover dataTable table-striped width-full">
                        <thead>
                        <tr>
                            <th>SL NO</th>
                            <th>Content Type</th>
                            <th>Creator</th>
                            <th>Created at</th>
                            <th>Active status</th>
                            <th>Publish status</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody id="all-content">

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- COL END -->
        <!-- Content create Modal -->
        <div class="modal fade" id="createContentForm" aria-hidden="true" aria-labelledby="myLargeModalLabel"
             role="dialog">
            <div class="modal-dialog" role="document" style="max-width: 1140px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create content</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                onclick="ResetContentForm();">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-content" name="form-content" autocomplete="off">
                            @csrf
                            <div class="container-fluid">
                                <div class="row">
                                    <input type="hidden" id="hiddenUser" name="hiddenUser">
                                    <div class="col-md-6 from-group">
                                        <label class="form-label">Content type</label>
                                        <div class="wrap-input100 validate-input">
                                            <select class="form-control" name="content_type" id="content_type">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 from-group">
                                        <label class="form-label">Meta tag</label>
                                        <div class="wrap-input100 validate-input">
                                            <input type="text" class="form-control" id="meta_tag" name="meta_tag"
                                                   placeholder="give meta tag"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 from-group">
                                        <label class="form-label">Meta description</label>
                                        <div class="wrap-input100 validate-input">
                                        <textarea class="form-control" id="meta_description" name="meta_description"
                                                  cols="40" rows="3" placeholder="Write something....."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6 from-group">
                                        <label class="form-label">Keywords</label>
                                        <div class="">
                                            <input type="text" class="form-control" name="keywords" id="keywords"
                                                   placeholder="Type keywords and press enter"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12 from-group">
                                        <label class="form-label">Content</label>
                                        <div class="wrap-input100 validate-input">
                                        <textarea data-plugin="summernote" class="form-control" id="contents"
                                                  name="contents"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-2 from-group">
                                        <div class="checkbox-custom checkbox-primary">
                                            <input type="checkbox" id="is_active" name="is_active" checked/> &nbsp;
                                            <label for="is_active">Is Active</label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 from-group text-left">
                                        <div class="checkbox-custom checkbox-primary">
                                            <input type="checkbox" id="is_published" name="is_published" checked/>
                                            &nbsp;
                                            <label for="is_published">Is Published</label>
                                        </div>
                                    </div>
                                    <div class="model-footer text-right mt-4">
                                        <label class="wc-error pull-left" id="form_error"></label>
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary mr-3"
                                               id="btnContentFormSubmit">
                                        {{--                                        <button type="button" class="btn btn-primary mr-3" id="btnUserFormSubmit" >Submit</button>--}}
                                        <button type="button" class="btn btn-default btn-outline"
                                                onclick="ResetContentForm()">Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Content create Modal -->

        <!-- Content view Modal -->
        <div class="modal fade" id="viewContentPage" aria-hidden="true" aria-labelledby="myLargeModalLabel"
             role="dialog">
            <div class="modal-dialog" role="document" style="max-width: 1140px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Individual content</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                onclick="ResetForm();">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row row-lg">
                            <div class="col-xlg-6 col-md-6">
                                <h5><span class="h4 font-weight-bold mt-2">Content type : </span><span
                                        class="getContentType"></span></h5>
                                <h5><span class="h4 font-weight-bold mt-2">Keywords : </span><span
                                        class="getKeyword"></span></h5>
                                <h5><span class="h4 font-weight-bold mt-2">Meta tag : </span><span
                                        class="getMetaTag"></span></h5>
                                <h5><span class="h4 font-weight-bold mt-2">Meta description : </span><span
                                        class="getMetaDesc"></span></h5>
                                <h5><span class="h4 font-weight-bold mt-2">Content Creator : </span><span
                                        class="getContentCreator"></span></h5>
                                <h5><span class="h4 font-weight-bold mt-2">Created at : </span><span
                                        class="getCreatedDate"></span></h5>
                                <h5><span class="h4 font-weight-bold mt-2">Active : </span><span
                                        class="getActive"></span></h5>
                                <h5><span class="h4 font-weight-bold mt-2">Publish : </span><span
                                        class="getPublish"></span></h5>
                            </div>
                            <div class="col-xlg-6 col-md-6">
                                <h5><span class="h4 font-weight-bold mt-2">Content : </span><span
                                        class="getContent"></span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Content view Modal -->
    </div>

@endsection
@section('js')

    <script type="text/javascript">
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {

            let getUser = localStorage.getItem("userData");

            var userData = JSON.parse(getUser);

            var userId = userData.id;
            $("#hiddenUser").val(userId);


            //content summernote

            $('#contents').summernote({
                height: 180,
                placeholder: 'Write your Contents here....',
            });

            // content type function

            $.ajax({
                url: "{{ route('contenttype.lookup') }}",
                type: "GET",
                success: function (response) {

                    var res = response.content;

                    var html = '<option value=""> Choose a content type</option>';
                    if (res.length > 0) {
                        for (let i = 0; i < res.length; i++) {
                            html += '<option value="' + res[i]['id'] + '">' + res[i]['name'] + '</option>';
                        }
                    }

                    $("#content_type").html(html);
                }
            });

            //Content data show datatable

            $('#content-table').DataTable({
                ajax: "{{ route('show.all.content') }}",
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            return '<p>' + full['first_name'] + ' ' + full['last_name'] + '</p>';
                        }
                    },
                    {data: 'created_at'},
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            if (full['is_active'] == '1') {
                                return '<p> Active </p>';
                            } else {
                                return '<p> Inactive </p>';
                            }
                        }
                    },
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            if (full['is_published'] == '1') {
                                return '<p> Published </p>';
                            } else {
                                return '<p> Unpublished </p>';
                            }
                        }
                    },
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            return "<button class='btn btn-success btn-sm btn-del' data-target='#viewContentPage' data-toggle='modal' data-toggle='view content' data-original-title='view content' onclick='getViewData(" + full['id'] + ")'>View</button>" +
                                "";
                        }
                    },
                ],
            });

            // keywords function
            $('#keywords').tokenfield({
                autocomplete: {
                    delay: 100
                },
                showAutocompleteOnFocus: true
            });

            //    content submit

            $('#form-content').on("submit", function (event) {
                event.preventDefault();
                var form = $(this).serialize();
                if (validateRequest()) {
                    $.ajax({
                        url: "{{route('add.content')}}",
                        data: form,
                        type: "POST",
                        success: function (response) {

                            if (response.success == true) {
                                $('#keywords').tokenfield('destroy');
                                $('#contents').summernote('reset');
                                $('#form-content')[0].reset();
                                $('#createContentForm').modal('hide');
                                Toast.fire({
                                    type: 'success',
                                    title: response.msg,
                                });
                                $('#content-table').DataTable().ajax.reload();
                            }
                        },
                        error: function (error) {
                            Toast.fire({
                                type: 'error',
                                title: 'Something Error Found, Please try again.',
                            });
                        }
                    });
                } else {
                    return false;
                }
            });
        });


        //validdtion
        function validateRequest() {
            if ($("#content_type").val() == "") {
                $("#content_type").focus();
                Toast.fire({
                    type: 'error',
                    title: 'Select content type.',
                });
                return false;
            }
            if ($("#keywords").val() == "") {
                $("#keywords").focus();
                Toast.fire({
                    type: 'error',
                    title: 'Add keywords.',
                });
                return false;
            }
            if ($("#contents").val() == "") {
                $("#contents").focus();
                Toast.fire({
                    type: 'error',
                    title: 'Add Contents.',
                });
                return false;
            }
            return true;
        }

        // view individual data function
        function getViewData(id) {
            $.ajax({
                url: "{{ url('api/view/individual/content') }}/" + id,
                type: "GET",
                success: function (response) {
                    var res = response.data;

                    $(".getContentType").html(res.name);
                    $(".getKeyword").html(res.keywords);
                    $(".getMetaTag").html(res.meta_tag);
                    $(".getMetaDesc").html(res.meta_description);
                    $(".getContentCreator").html(res.first_name + ' ' + res.last_name);
                    $(".getCreatedDate").html(new Date(res.created_at).toLocaleDateString('en-us', {
                        year: "numeric",
                        month: "long",
                        day: "numeric"
                    }));
                    if (res.is_active == 1) {
                        $(".getActive").html('Active');
                    } else {
                        $(".getActive").html('Inactive');
                    }
                    if (res.is_published == 1) {
                        $(".getPublish").html('Published');
                    } else {
                        $(".getPublish").html('Unpublished');
                    }
                    $(".getContent").html(res.content);
                }

            });
        }

        //    DELETE OPTION
        function getDeleteData(id) {
            var result = confirm("Are you sure to delete?");
            if (result) {
                $.ajax({
                    url: "{{ url('navigation-delete') }}/" + id,
                    type: "DELETE",
                    success: function (response) {
                        console.log(response)
                        if (response.success == true) {
                            Toast.fire({
                                type: 'success',
                                title: response.msg,
                            });
                            getSidebar(1);
                            $('#navigation-table').DataTable().ajax.reload();
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

        }

        function ResetContentForm() {
            $('#keywords').tokenfield('destroy');
            $('#contents').summernote('reset');
            $('#form-content')[0].reset();
        }
    </script>
@endsection
