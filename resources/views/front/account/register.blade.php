<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Login Page</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" href="{{ asset('account-assets/style.css') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        @if (session('error'))
        <script>
            // document.addEventListener("DOMContentLoaded", function () {
            //     alert("{{ session('error') }}");
            // });
            document.addEventListener("DOMContentLoaded", function () {
                const errorMessage = "{{ session('error') }}";
                if (errorMessage) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                    });
                }
            });
        </script>
        @endif @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                alert("{{ session('success') }}");
            });
            // Swal.fire({
            //     position: "top-start",
            //     icon: "success",
            //     title: "Your work has been saved",
            //     showConfirmButton: true,
            //     timer: 1500
            // });
        </script>
        @endif
        <div class="container-login">
            <div class="container px-4 py-4 d-flex flex-row gap-4 rounded-4">
                <div class="d-flex justify-content-center align-items-center">
                    <img
                        src="{{ asset('front-assets/img/logotech.png') }}"
                        alt="LogotechNoHub"
                        class="center-img"
                    />
                </div>
                <div class="container">
                    <form
                        action=""
                        method="post"
                        name="registrationForm"
                        id="registrationForm"
                    >
                        <h2>Hello,Everyone</h2>
                        <p class="mb-5">we are glad you are here!</p>
                        <!-- @if(Session::has('error'))

                        <div>
                            {{ Session::get('error') }}
                        </div>
                        @endif @if(Session::has('success'))
                        <div>
                            {{ Session::get('success') }}
                        </div>
                        @endif -->
                        <div class="mb-2 position-relative">
                            <img
                                class="image-email"
                                src="{{ asset('account-assets/name.png') }}"
                                alt="name"
                                width="20px"
                                height="20px"
                            />
                            <input
                                type="name"
                                class="form-control name rounded-4"
                                id="name"
                                name="name"
                                aria-describedby="emailHelp"
                                placeholder="Name"
                            />
                            <hr
                                class="position-absolute translate-middle-x email"
                            />
                            <p></p>
                        </div>
                        <div class="mb-2 position-relative">
                            <img
                                class="image-email"
                                src="{{ asset('account-assets/email.png') }}"
                                alt="email"
                                width="20px"
                                height="20px"
                            />
                            <input
                                type="email"
                                class="form-control email rounded-4"
                                id="email"
                                name="email"
                                aria-describedby="emailHelp"
                                placeholder="Email"
                            />
                            <hr
                                class="position-absolute translate-middle-x email"
                            />
                            <p></p>
                        </div>
                        <div class="mb-2 mt-n5 position-relative">
                            <img
                                class="image-password"
                                src="{{ asset('account-assets/password.png') }}"
                                alt="password"
                                width="20px"
                                height="20px"
                            />
                            <input
                                type="password"
                                class="form-control password rounded-4"
                                id="password"
                                name="password"
                                placeholder="Password"
                            />
                            <hr
                                class="position-absolute translate-middle-x email"
                            />
                            <p></p>
                        </div>
                        <div class="mb-2 mt-n5 position-relative">
                            <img
                                class="image-password"
                                src="{{ asset('account-assets/password.png') }}"
                                alt="confirm password"
                                width="20px"
                                height="20px"
                            />
                            <input
                                type="password"
                                class="form-control password rounded-4"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Confirm Password"
                            />
                            <hr
                                class="position-absolute translate-middle-x email"
                            />
                        </div>
                        <br />
                        <div class="mb-5">
                            <button
                                type="submit"
                                class="button-login btn btn-primary mb-4 w-100 rounded-4"
                            >
                                Register
                            </button>
                        </div>
                        <div>
                            <p>
                                Already have an account?
                                <a
                                    href="{{ route('account.login') }}"
                                    class="text-decoration-none text-danger"
                                    >Login</a
                                >
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"
        ></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#registrationForm").submit(function (event) {
                    event.preventDefault();

                    $("button[type='submit']").prop("disable", true);
                    // Mendapatkan token CSRF dari meta tag dalam halaman
                    var csrfToken = $('meta[name="csrf-token"]').attr(
                        "content"
                    );

                    // Menambahkan token CSRF ke data yang akan dikirimkan
                    var formData = $(this).serializeArray();
                    formData.push({ name: "_token", value: csrfToken });

                    // Mengirimkan permintaan AJAX dengan token CSRF
                    $.ajax({
                        url: '{{ route("account.processRegister") }}',
                        type: "post",
                        data: formData,
                        dataType: "json",
                        success: function (response) {
                            $("button[type='submit']").prop("disable", false);
                            var errors = response.errors;

                            if (response.status == false) {
                                if (errors.name) {
                                    $("#name")
                                        .siblings("p")
                                        .addClass("invalid-feedback")
                                        .html(errors.name);
                                    $("#name").addClass("is-invalid");
                                } else {
                                    $("#name")
                                        .siblings("p")
                                        .removeClass("invalid-feedback")
                                        .html("");
                                    $("#name").addClass("is-invalid");
                                }

                                if (errors.email) {
                                    $("#email")
                                        .siblings("p")
                                        .addClass("invalid-feedback")
                                        .html(errors.email);
                                    $("#email").addClass("is-invalid");
                                } else {
                                    $("#email")
                                        .siblings("p")
                                        .removeClass("invalid-feedback")
                                        .html("");
                                    $("#email").addClass("is-invalid");
                                }

                                if (errors.password) {
                                    $("#password")
                                        .siblings("p")
                                        .addClass("invalid-feedback")
                                        .html(errors.password);
                                    $("#password").addClass("is-invalid");
                                } else {
                                    $("#password")
                                        .siblings("p")
                                        .removeClass("invalid-feedback")
                                        .html("");
                                    $("#password").addClass("is-invalid");
                                }
                            } else {
                                $("#password")
                                    .siblings("p")
                                    .removeClass("invalid-feedback");

                                $("#email")
                                    .siblings("p")
                                    .removeClass("invalid-feedback");

                                $("#name")
                                    .siblings("p")
                                    .removeClass("invalid-feedback");

                                window.location.href =
                                    "{{ route('account.login') }}";
                            }
                        },
                        error: function (JQXHR, exception) {
                            console.log("Something went wrong");
                        },
                    });
                });
            });
        </script>
    </body>
</html>
