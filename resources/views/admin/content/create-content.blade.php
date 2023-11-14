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
                        <h3 class="card-title">Create Content</h3>
                    </div>
                </div>
                <div class="card-body">
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
                                    <div class="wrap-input100 validate-input">
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
                                <div class="col-md-12 from-group">
                                    <div class="checkbox-custom checkbox-primary">
                                        <input type="checkbox" id="is_active" name="is_active" checked/> &nbsp;
                                        <label for="is_active">Is Active</label>
                                    </div>
                                </div>
                                <div class="col-md-12 from-group">
                                    <div class="checkbox-custom checkbox-primary">
                                        <input type="checkbox" id="is_published" name="is_published" checked/> &nbsp;
                                        <label for="is_published">Is Published</label>
                                    </div>
                                </div>
                                <hr />
                                <div class="model-footer text-right">
                                    <label class="wc-error pull-left" id="form_error"></label>
                                    <input type="submit" name="submit" value="Submit" class="btn btn-primary mr-3" id="btnContentFormSubmit">
                                    {{--                                        <button type="button" class="btn btn-primary mr-3" id="btnUserFormSubmit" >Submit</button>--}}
                                    <button type="button" class="btn btn-default btn-outline" onclick="ResetContentForm()">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- COL END -->

    </div>

@endsection
@section('js')

    <script type="text/javascript">

        $(document).ready(function () {
            let getUser = localStorage.getItem("userData");

            var userData = JSON.parse(getUser);

            var userId = userData.id;
            $("#hiddenUser").val(userId);

            // keywords function
            $('#keywords').tokenfield();

            //content summernote

            $('#contents').summernote({
                height: 200,
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
                            Toast.fire({
                                type: 'success',
                                title: response.msg,
                            });
                        }
                    },
                    error: function (error) {
                        Toast.fire({
                            type: 'error',
                            title: 'Something Error Found, Please try again.',
                        });
                    }
                });
            }else{
                return false;
            }
            });
        });

        //validdtion
        function validateRequest() {
            if($("#content_type").val()==""){
                $("#content_type").focus();
                Toast.fire({
                    type: 'error',
                    title: 'Select content type.',
                });
                return false;
            }
            if($("#keywords").val()==""){
                $("#keywords").focus();
                Toast.fire({
                    type: 'error',
                    title: 'Add keywords.',
                });
                return false;
            }
            if($("#contents").val()==""){
                $("#contents").focus();
                Toast.fire({
                    type: 'error',
                    title: 'Add Contents.',
                });
                return false;
            }
            return true;
        }

        // edit option
        function getEditData(id) {
            $.ajax({
                url: "{{ url('navigation-edit') }}/" + id,
                type: "GET",
                success: function (response) {

                    $("#hiddenNavId").val(response.id);
                    $("#name").val(response.name);
                    $("#url").val(response.url);
                    $("#icon").val(response.icon);
                    $("#parent").val(response.parent).change();

                    if (response.display != 1) {
                        $('#display').removeAttr('checked');
                    } else {
                        $('#display').attr('checked', 'checked');
                    }

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
