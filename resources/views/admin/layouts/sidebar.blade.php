<!-- Main Sidebar Container -->
<div
    class="d-flex flex-column align-items-center"
    style="min-width: 20%; position: relative"
>
    <!-- Logout Button at the top left -->
    <br />
    <div class="position-absolute top-3 start-0 m-3" style="margin-top: 20px">
        <br />
        <a
            href="{{ route('admin.logout') }}"
            id="logoutButton"
            data-toggle="tooltip"
            title="Keluar dari akun"
            data-placement="right"
        >
            <img
                src="{{ asset('dashboard-assets/keluar.png') }}"
                alt="logout image"
                width="30px"
                height="30px"
            />
        </a>
    </div>

    <!-- Centered Logo and Title -->
    <div
        class="d-flex flex-column align-items-center justify-content-center mt-5"
    >
        <img
            class="mt-3"
            src="{{ asset('dashboard-assets/gambar.png') }}"
            alt="logo"
            width="100px"
            height="100px"
        />
        <h2>TechNohub</h2>
    </div>

    <!-- Navigation Menu -->
    <nav class="h-100 d-flex align-items-start navbar w-100 mt-5">
        <ul
            class="h-100 mt-2 d-flex flex-column align-items-center navbar-nav w-100"
        >
            <li class="w-100 nav-item d-flex justify-content-center">
                <a
                    class="w-100 d-flex align-items-center nav-link fs-5"
                    href="{{ route('admin.dashboard') }}"
                >
                    <div
                        class="col-4 d-flex align-items-center justify-content-center"
                    >
                        <img
                            src="{{ asset('dashboard-assets/dashboard.png') }}"
                            alt="dashboard image"
                            width="30px"
                            height="30px"
                        />
                    </div>
                    <div class="col-8">Dashboard</div>
                </a>
            </li>
            <li class="w-100 nav-item d-flex justify-content-center">
                <a
                    class="w-100 d-flex align-items-center nav-link fs-5"
                    href="{{ route('product.page') }}"
                >
                    <div
                        class="col-4 d-flex align-items-center justify-content-center"
                    >
                        <img
                            src="{{ asset('dashboard-assets/dashboard.png') }}"
                            alt="dashboard image"
                            width="30px"
                            height="30px"
                        />
                    </div>
                    <div class="col-8">Product</div>
                </a>
            </li>
            <li class="w-100 nav-item d-flex justify-content-center">
                <a
                    class="w-100 d-flex align-items-center nav-link fs-5"
                    href="{{ route('admin.transaksi') }}"
                >
                    <div
                        class="col-4 d-flex align-items-center justify-content-center"
                    >
                        <img
                            src="{{ asset('dashboard-assets/dashboard.png') }}"
                            alt="dashboard image"
                            width="30px"
                            height="30px"
                        />
                    </div>
                    <div class="col-8">Transaksi</div>
                </a>
            </li>
        </ul>
    </nav>
</div>
