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
            <div class="row" id="product-gallery"></div>

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
                    value="{{ $product->title }}"
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
                    value="{{ $product->category }}"
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
                    value="{{ $product->price }}"
                />
            </div>
            <div
                class="d-flex flex-row justify-content-center align-items-center mb-3 w-100 gap-3"
            >
                <label for="qty" class="col-2 form-label">Stok</label>
                <input
                    type="text"
                    name="qty"
                    class="col-10 form-control"
                    id="qty"
                    style="width: 500px"
                    value="{{ $product->qty }}"
                />
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
                    >{{ $product->description }}</textarea
                >
            </div>
            <input
                type="hidden"
                name="slug"
                id="slug"
                value="{{ $product->slug}}"
            />
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
<!-- <script>
    // Ambil elemen tombol dan input file
    var uploadButton = document.getElementById("uploadButton");
    var imagePreview = document.getElementById("imagePreview");
    var fileInput = document.getElementById("gambarInput");

    // // Tambahkan event listener untuk klik pada tombol
    uploadButton.addEventListener("click", function () {
        // Trigger event klik pada input file saat tombol diklik
        fileInput.click();
    });

    // Tambahkan event listener untuk saat gambar dipilih
    fileInput.addEventListener("change", function () {
        // Bersihkan preview sebelum menampilkan gambar yang baru dipilih
        imagePreview.innerHTML = "";

        var file = fileInput.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            var image = new Image();
            image.src = e.target.result;
            image.alt = "mantap";
            image.style.width = "200px";
            image.style.borderRadius = "50%";
            imagePreview.appendChild(image);
        };
        reader.readAsDataURL(file);
    });
</script> -->
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
                url: '{{ route("product.update", $product->id) }}',
                type: "put",
                data: fromArray,
                dataType: "json",
                success: function (response) {
                    window.location.href = "{{ route('product.page') }}";
                },
                error: function () {
                    console.log("Something Wrong");
                },
            });
        });

        const dropzone = new Dropzone("#image", {
    url: "{{ route('productImage.update') }}",
    maxFiles: 10,
    paramName: "image",
    params: {'product_id':'{{ $product->id }}'},
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png,image/gif",
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    success: function (file, response) {
        var html = `<input type="hidden" name="image_array[]" value="${response.image_id}">`;
        $("#product-gallery").append(html);
    },
    removedfile: function(file) {
        // Make an AJAX request to delete the file from server
        $.ajax({
            type: 'POST',
            url: '{{ route("product.removeImage") }}',
            data: {
                image_id: file.image_id, // Assuming you have an image_id assigned to each file
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                window.location.reload();
            },
            error: function(xhr, status, error) {
                // Handle error response if needed
            }
        });
    }
});

// Fungsi untuk menambahkan gambar awal ke Dropzone
function loadInitialImage(imageUrl, imageId) {
    var mockFile = { name: "Existing Image", size: 12345, type: 'image/jpeg', image_id: imageId };

    // Menambahkan mock file ke Dropzone
    dropzone.emit("addedfile", mockFile);
    dropzone.emit("thumbnail", mockFile, imageUrl);
    dropzone.emit("complete", mockFile);

    // Menyembunyikan tombol hapus untuk gambar awal (opsional)
    // mockFile.previewElement.querySelector(".dz-remove").style.display = "none";
}

// URL gambar yang ingin Anda tambahkan
@if($product->product_image)
@foreach($product->product_image as $key => $productImage)
    var imageUrl = '{{ asset('uploads/product/small/'.$productImage->image) }}';
    var imageId = '{{ $productImage->id }}'; // Assuming you have an ID for each image
    if (imageUrl) {
        loadInitialImage(imageUrl, imageId);
    }
@endforeach
@endif

</script>
@endsection
