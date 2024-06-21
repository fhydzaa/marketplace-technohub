<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Dashboard Admin</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
            crossorigin="anonymous"
        />
        <link
            rel="stylesheet"
            href="{{
                asset('admin-assets/plugins/dropzone/min/dropzone.min.css')
            }}"
        />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link
            rel="stylesheet"
            href="{{
                asset(
                    'admin-assets/https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback'
                )
            }}"
        />
        <!-- Font Awesome -->
        <link
            rel="stylesheet"
            href="{{
                asset('admin-assets/plugins/fontawesome-free/css/all.min.css')
            }}"
        />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css"
        />
        <!-- Theme style -->
        <!-- <link
            rel="stylesheet"
            href="{{ asset('admin-assets/css/adminlte.min.css') }}"
        /> -->
        <link
            rel="stylesheet"
            href="{{
                asset('admin-assets/plugins/summernote/summernote-bs4.min.css')
            }}"
        />
        <link
            rel="stylesheet"
            href="{{ asset('admin-assets/plugins/dropzone/dropzone.css') }}"
        />
        <link
            rel="stylesheet"
            href="{{ asset('admin-assets/css/custom.css') }}"
        />
    </head>
    <body>
        <div class="d-flex flex-row" style="min-height: 100vh">
            @include('admin.layouts.sidebar');

            <div
                class="container d-flex flex-column w-100"
                style="background-color: #032d64"
            >
                @yield('content')
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{ asset('front-assets/script.js') }}"></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"
        ></script>
        <!-- Summernote -->
        <script src="{{
                asset('admin-assets/plugins/summernote/summernote-bs4.min.js')
            }}"></script>
        <script src="{{
                asset('admin-assets/plugins/dropzone/min/dropzone.min.js')
            }}"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });
            $(document).ready(function () {
                $(".summernote").summernote({
                    height: 250,
                });
            });
        </script>
        <script>
            document
                .getElementById("logoutButton")
                .addEventListener("click", function (event) {
                    event.preventDefault();
                    var confirmLogout = confirm(
                        "Apakah Anda yakin ingin keluar?"
                    );
                    if (confirmLogout) {
                        window.location.href = this.href;
                    }
                });
        </script>
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
        @yield('customJs')
    </body>
</html>
