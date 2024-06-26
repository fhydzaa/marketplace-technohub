@extends('admin.layouts.app') @section('content')
<div class="container-fluid" style="position: relative">
    <div
        class="container d-flex flex-column justify-content-center align-items-center px-5 py-5"
        style="min-height: 100vh; border-radius: 10px"
    >
        <form
            action=""
            method="post"
            name="productForm"
            id="productForm"
            class="px-5 py-5 d-flex bg-light flex-column justify-content-center align-items-center rounded-4"
            style="border: 1px solid black; width: 100%"
        >
            <div
                class="d-flex flex-row justify-content-center align-items-center mb-3 w-100 gap-3"
            >
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Gambar</h2>
                        <div id="image" class="dropzone dz-clickable">
                            <div class="dz-message needsclick">
                                <br />Drop files here or click to upload.<br /><br />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="product-gallery">

            </div>

            <div
                class="d-flex flex-row justify-content-center align-items-center mb-3 w-100 gap-3"
            >
                <label for="title" class="col-2 form-label">Nama Produk</label>
                <input
                    type="text"
                    name="title"
                    class="col-10 form-control"
                    id="title"
                    style="width: 500px"
                />
            </div>
            <div
                class="d-flex flex-row justify-content-center align-items-center mb-3 w-100 gap-3"
            >
                <label for="category" class="col-2 form-label">Jenis</label>
                <input
                    type="text"
                    name="category"
                    class="col-10 form-control"
                    id="category"
                    style="width: 500px"
                />
            </div>
            <div
                class="d-flex flex-row justify-content-center align-items-center mb-3 w-100 gap-3"
            >
                <label for="price" class="col-2 form-label">Harga</label>
                <input
                    type="text"
                    name="price"
                    class="col-10 form-control"
                    id="price"
                    style="width: 500px"
                />
            </div>
            <div
            class="d-flex flex-row justify-content-center align-items-center mb-3 w-100 gap-3"
            >
                <label for="qty" class="col-2 form-label">Stok</label>
                <div>
                    <input
                        type="text"
                        name="qty"
                        class="form-control"
                        id="qty"
                        style="width: 500px"
                    />
                    <small class="text-danger" style="font-style: italic;">*maksimal stok 100</small>
                </div>
            </div>
            <div
                class="d-flex flex-row justify-content-center align-items-center mb-3 w-100 gap-3"
            >
                <label for="description" class="col-2 form-label"
                    >Deskripsi</label
                >
                <textarea
                    name="description"
                    class="col-10 form-control"
                    id="description"
                    style="width: 500px; min-height: 100px"
                ></textarea>
            </div>
            <input type="hidden" name="slug" id="slug" />
            <input type="hidden" name="status" id="status" value="1" />

            <div
                class="d-flex flex-row justify-content-center align-items-center w-100 mt-3"
            >
                <button type="submit" class="btn btn-primary rounded-4 px-4">
                    Submit
                </button>
            </div>
        </form>
        <!-- <div
            class="d-flex flex-row justify-content-center align-items-center w-100 mt-3"
        >
            <button type="button" class="btn btn-secondary rounded-4 px-4">
                Kembali
            </button>
        </div> -->
    </div>
</div>
@endsection @section('customJs')
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
        
        Swal.fire({
            title: 'Apakah Data yang di tambahkan sudah benar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                var fromArray = $(this).serializeArray();
                $.ajax({
                    url: '{{ route("product.store") }}',
                    type: "post",
                    data: fromArray,
                    dataType: "json",
                    success: function (response) {
                        Swal.fire(
                            'Berhasil!',
                            'Produk Berhasil Ditambahkan',
                            'success'
                        ).then(() => {
                            window.location.href = "{{ route('product.page') }}";
                        });
                    },
                    error: function () {
                        Swal.fire(
                            'Gagal!',
                            'Ada yang salah, silakan coba lagi.',
                            'error'
                        );
                    },
                });
            } else {
                console.log("Pengiriman form dibatalkan");
            }
        });
    });
        // $("#productForm").submit(function (event) {
        //     event.preventDefault();
        //     var fromArray = $(this).serializeArray();
        //     $.ajax({
        //         url: '{{ route("product.store") }}',
        //         type: "post",
        //         data: fromArray,
        //         dataType: "json",
        //         success: function (response) {
        //             window.location.href = "{{ route('product.page') }}";
        //         },
        //         error: function () {
        //             console.log("Something Wrong");
        //         },
        //     });
        // });

        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            url: "{{ route('temp-images.create') }}",
            maxFiles: 10,
            paramName: "image",
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (file, response) {
                // $("#image_id").val(response.image_id);
                //console.log(response)
                var html = `<input type="hidden" name="image_array[]" value="${response.image_id}">`;

                $("#product-gallery").append(html);
                

            },
        });
</script>
@endsection
