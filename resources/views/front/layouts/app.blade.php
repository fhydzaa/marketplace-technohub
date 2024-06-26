<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Technohub</title>
        <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-...="anonymous" />
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
            rel="stylesheet"
        />
      
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css"/>
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
        />
        <link rel="stylesheet" href="{{ asset('front-assets/style.css') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta
            name="description"
            content="Temukan dan beli berbagai permainan terbaru dan terpopuler di situs e-commerce game kami. Dapatkan penawaran terbaik dan ulasan dari pengguna."
        />
        <meta
            name="keywords"
            content="beli game, game terbaru, game populer, e-commerce game, toko game online"
        />
        
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-light fixed-top">
            <div class="container">
                <h1 class="navbar-brand">TechnoHub</h1>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                aria-current="page"
                                href="{{ route('front.home') }}"
                                >Home</a
                            >
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="{{ route('front.product') }}"
                                >Product</a
                            >
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="{{ route('front.about') }}"
                                >About</a
                            >
                        </li>
                    </ul>
                </div>
                @if(!empty($user))
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="navbarDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            @if ($userdetails->isNotEmpty())
                            <img
                                src="{{ $userdetails->first()->image }}"
                                class="img-circle elevation-2"
                                width="40"
                                height="40"
                                alt=""
                            />
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <h4 class="dropdown-item mb-0">
                                    <strong>{{ $user->name }}</strong>
                                </h4>
                            </li>
                            <li>
                                <div class="dropdown-item mb-3">
                                    {{ $user->email }}
                                </div>
                            </li>
                            <li><hr class="dropdown-divider" /></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('account.profileEdit', $user->id) }}">
                                    <i class="fa-solid fa-user" style="color: #123159;"></i> My Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('front.cart') }}">
                                    <i class="fa-solid fa-cart-shopping" style="color: #123159;"></i> Keranjang
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('front.transaksi') }}">
                                    <i class="fa-solid fa-money-bill" style="color: #123159;"></i> Transaksi
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('account.logout') }}">
                                    <i class="fa-solid fa-right-from-bracket" style="color: #123159;"></i> Logout
                                </a>
                            </li>
                        </ul>                        
                    </li>
                </ul>
                @else
                <div>
                    <a
                        href="{{ route('account.login') }}"
                        class="btn btn-primary"
                        >MASUK</a
                    >
                </div>
                @endif
            </div>
        </nav>

        <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Modal title
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">...</div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                        <button type="button" class="btn btn-primary">
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        @yield('content')

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"
        ></script>
        <script src="https://kit.fontawesome.com/f715660651.js" crossorigin="anonymous"></script>        <script src="{{ asset('front-assets/script.js') }}"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });
        </script>
        @yield('customJs')
    </body>
</html>
