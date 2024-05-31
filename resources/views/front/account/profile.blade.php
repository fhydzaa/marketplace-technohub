@extends('front.layouts.app')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh">
    <div class="container d-flex flex-column justify-content-center align-items-center" style="width: 600px; height: 650px; border: 1px solid black; border-radius: 20px;">
        <h1 class="mb-3 fw-bold">Profile Pengguna</h1>
        <div class="d-flex flex-row justify-content-center align-items-center mb-3 w-100 gap-3">
            <input type="file" name="gambar" id="gambarInput" style="display: none;">
            <div class="rounded-circle" id="imagePreview">
                <img class="rounded-circle" id="previewImage" src="" width="200px" height="200px" style="border: 2px solid black">
            </div>
            <div>
                <button type="button" class="col-10 form-control btn btn-success" id="uploadButton" style="width: 150px;">
                    Pilih Gambar
                </button>
            </div>
        </div>
        <h2 class="fw-bold mb-4">Rawon</h2>
        <form action="#" method="POST" class="d-flex flex-column gap-4">
            <div class="row">
                <label class="col-5" for="email">Email</label>
                <input class="col-7 rounded-4" type="text" id="email" name="email" placeholder="rawon@gmail.com">
            </div>
            <div class="row">
                <label class="col-5" for="jeniskelamin">Jenis Kelamin</label>
                <input class="col-7 rounded-4" type="text" id="jeniskelamin" name="jeniskelamin" placeholder="Laki - Laki">
            </div>
            <div class="row">
                <label class="col-5" for="notelepon">No-Telepon</label>
                <input class="col-7 rounded-4" type="text" id="notelepon" name="notelepon" placeholder="09876543">
            </div>
            <div class="d-flex justify-content-center">
                <button id="buttonprofile" name="buttonprofile" class="btn text-light px-4 rounded-4" style="background-color: #123159;">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('costumJs')
<script>
    var uploadButton = document.getElementById("uploadButton");
    var imagePreview = document.getElementById("imagePreview");
    var fileInput = document.getElementById("gambarInput");

    uploadButton.addEventListener("click", function () {
        fileInput.click();
    });

    fileInput.addEventListener("change", function () {
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
</script>
@endsection
