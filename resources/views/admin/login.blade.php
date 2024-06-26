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
        <link rel="stylesheet" href="{{ asset('admin-assets/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('account-assets/style.css') }}" />
    </head>
    <body>
        <div class="container">
            <div class="row-cols-1 mt-3"></div>
            <div class="row-cols-1">
                <div class="container-login">
                    <div class="container p-4 d-flex flex-row gap-4 rounded-4">
                        <img
                            src="{{ asset('admin-assets/logotech.png') }}"
                            alt="LogotechNoHub"
                        />
                        <div class="container">
                            <form
                                action="{{ route('admin.authenticate') }}"
                                method="post"
                            >
                                @csrf

                                <h2>Hello,Everyone</h2>
                                <p class="mb-5">we are glad you are here!</p>
                                @include('admin.massege')
                                <div class="mb-2 position-relative">
                                    <img
                                        class="image-email"
                                        src="{{
                                            asset('admin-assets/email.png')
                                        }}"
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
                                    @error('email')
                                    <p class="invalid-feedback">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="mb-2 mt-n5 position-relative">
                                    <img
                                        class="image-password"
                                        src="{{
                                            asset('admin-assets/password.png')
                                        }}"
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
                                    @error('password')
                                    <p class="invalid-feedback">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="mb-5">
                                    <button
                                        type="submit"
                                        class="button-login btn btn-primary mb-4 w-100 rounded-4"
                                    >
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
