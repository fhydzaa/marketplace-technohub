@extends('front.layouts.app') @section('content')
<div
    class="d-flex flex-column justify-content-center align-items-center"
    style="min-height: 100vh"
>
    <div
        class="container d-flex flex-column justify-content-center align-items-center"
        style="
            width: 600px;
            height: 650px;
            border: 1px solid black;
            border-radius: 20px;
        "
    >
        <div
            class="d-flex flex-row justify-content-center align-items-center mb-3 w-100 gap-3"
        >
            <input
                type="file"
                name="gambar"
                id="gambarInput"
                style="display: none"
            />
            <div class="rounded-circle" id="imagePreview">
                <img
                    class="rounded-circle"
                    id="previewImage"
                    src="{{ $userdetails->first()->image }}"
                    width="200px"
                    height="200px"
                    style="border: 2px solid black"
                />
            </div>
            <div>
                <button
                    type="button"
                    class="col-10 form-control btn btn-success"
                    id="uploadButton"
                    style="width: 150px"
                >
                    Pilih Gambar
                </button>
            </div>
        </div>
        <br />
        <br />
        <form
            action="{{ route('account.profileUpdate', $user->id) }}"
            method="POST"
            class="d-flex flex-column gap-4"
        >
            @csrf
            @method('PUT')
            @if ($userdetails->isNotEmpty())
            <input type="hidden" name="user_id" value="{{ $user->id }}" />
            <input type="hidden" id="base64Image" name="base64Image" />
            <div class="row">
                <label class="col-5" for="name">Nama</label>
                <input
                    class="col-7 rounded-4"
                    type="text"
                    id="name"
                    name="name"
                    value="{{ $user->name }}"
                />
            </div>
            <div class="row">
                <label class="col-5" for="email">Email</label>
                <input
                    class="col-7 rounded-4"
                    type="text"
                    id="email"
                    name="email"
                    value="{{ $user->email }}"
                />
            </div>
            <div class="row">
                <label class="col-5" for="gender">Jenis Kelamin</label>
                <select class="col-7 rounded-4" id="gender" name="gender">
                    <option value="Laki - Laki" {{ $userdetails->first()->gender == 'Laki - Laki' ? 'selected' : '' }}>Laki - Laki</option>
                    <option value="Perempuan" {{ $userdetails->first()->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>            
            <div  class="row">
                <label class="col-5" for="no_telephone">No-Telepon</label>
                <input
                    class="col-7 rounded-4"
                    type="text"
                    id="no_telephone"
                    name="no_telephone"
                    value="{{ $userdetails->first()->no_telephone }}"
                />
            </div>
            <div class="d-flex justify-content-center">
                <button
                    id="buttonprofile"
                    name="buttonprofile"
                    class="btn text-light px-4 rounded-4"
                    style="background-color: #123159"
                >
                    Simpan
                </button>
            </div>
        @endif  
        </form>
    </div>
</div>
@endsection @section('customJs')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var uploadButton = document.getElementById("uploadButton");
        var imagePreview = document.getElementById("imagePreview");
        var fileInput = document.getElementById("gambarInput");
        var base64ImageInput = document.getElementById("base64Image");
        var defaultImageSrc = "{{ $userdetails->first()->image }}"; // Path ke gambar default

        uploadButton.addEventListener("click", function () {
            fileInput.click();
        });

        fileInput.addEventListener("change", function () {
            var file = fileInput.files[0];
            if (file) {
                // Memeriksa ukuran file
                var maxSizeInBytes = 100 * 1024; // 500 KB
                if (file.size > maxSizeInBytes) {
                    alert(
                        "Ukuran file terlalu besar. Maksimum 100 KB yang diperbolehkan."
                    );
                    fileInput.value = ""; // Menghapus file yang dipilih
                    return;
                }
                var reader = new FileReader();
                reader.onload = function (e) {
                    var image = new Image();
                    image.src = e.target.result;
                    image.alt = "Selected Image";
                    image.style.width = "200px";
                    image.style.height = "200px";
                    image.style.borderRadius = "50%";
                    imagePreview.innerHTML = "";
                    imagePreview.appendChild(image);

                    // Simpan data base64 di input tersembunyi
                    base64ImageInput.value = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        document
            .querySelector("form")
            .addEventListener("submit", function (event) {
                if (base64ImageInput.value === "") {
                    fetch(defaultImageSrc)
                        .then((response) => response.blob())
                        .then((blob) => {
                            var reader = new FileReader();
                            reader.onloadend = function () {
                                base64ImageInput.value = reader.result;
                                document.querySelector("form").submit();
                            };
                            reader.readAsDataURL(blob);
                            event.preventDefault(); // Mencegah form submit sementara
                        });
                }
            });

        var defaultImageBlob;
        fetch(defaultImageSrc)
            .then((response) => response.blob())
            .then((blob) => {
                defaultImageBlob = blob;
                var reader = new FileReader();
                reader.onloadend = function () {
                    var image = new Image();
                    image.src = reader.result;
                    image.alt = "Default Image";
                    image.style.width = "200px";
                    image.style.height = "200px";
                    image.style.borderRadius = "50%";
                    imagePreview.innerHTML = "";
                    imagePreview.appendChild(image);

                    // Set base64 value
                    base64ImageInput.value = reader.result;
                };
                reader.readAsDataURL(blob);
            });
    });
</script>
@endsection
