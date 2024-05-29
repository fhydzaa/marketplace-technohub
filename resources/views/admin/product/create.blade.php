@extends('admin.layouts.app') @section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Product</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="products.html" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <form action="" method="post" name="productForm" id="productForm">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Title</label>
                                        <input
                                            type="text"
                                            name="title"
                                            id="title"
                                            class="form-control"
                                            placeholder="Title"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Slug</label>
                                        <input
                                            type="text"
                                            readonly
                                            name="slug"
                                            id="slug"
                                            class="form-control"
                                            placeholder="Slug"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description"
                                            >Description</label
                                        >
                                        <textarea
                                            name="description"
                                            id="description"
                                            cols="30"
                                            rows="10"
                                            class="summernote"
                                            placeholder="Description"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <br />Drop files here or click to upload.<br /><br />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Pricing</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <input
                                            type="text"
                                            name="price"
                                            id="price"
                                            class="form-control"
                                            placeholder="Price"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Inventory</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input
                                            type="number"
                                            min="0"
                                            name="qty"
                                            id="qty"
                                            class="form-control"
                                            placeholder="Qty"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Product status</h2>
                            <div class="mb-3">
                                <select
                                    name="status"
                                    id="status"
                                    class="form-control"
                                >
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="products.html" class="btn btn-outline-dark ml-3"
                    >Cancel</a
                >
            </div>
        </div>
    </form>

    <!-- /.card -->
</section>
<!-- /.content -->
@endsection @section('customJs')
<!-- jQuery -->
<script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{
        asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')
    }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin-assets/js/adminlte.min.js') }}"></script>
<!-- Summernote -->
<script src="{{
        asset('admin-assets/plugins/summernote/summernote-bs4.min.js')
    }}"></script>
<script src="{{ asset('admin-assets/plugins/dropzone/dropzone.js') }}"></script>

<script>
    // Correct the event listener for the title input field
    $("#title").change(function () {
        let element = $(this);
        $("button[type=submit]").prop("disabled", true);
        $.ajax({
            url: '{{ route("getSlug") }}',
            type: "get",
            data: { title: element.val() },
            dataType: "json",
            success: function (response) {
                $("button[type=submit]").prop("disabled", false);
                if (response.status === true) {
                    $("#slug").val(response.slug);
                }
            },
        });
    });

    $("#productForm").submit(function (event) {
        event.preventDefault();
        var fromArray = $(this).serializeArray();
        $.ajax({
            url: '{{ route("product.store") }}',
            type: "post",
            data: fromArray,
            dataType: "json",
            success: function (response) {},
            error: function () {
                console.log("Something Wrong");
            },
        });
    });
</script>
@endsection
