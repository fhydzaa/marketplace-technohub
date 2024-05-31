<!-- Main Sidebar Container -->
        <div class="d-flex flex-column align-items-center" style="min-width: 20%">
          <div class="d-flex flex-column align-items-center justify-content-center">
            <img class="mt-3" src="{{ asset('dashboard-assets/gambar.png') }}" alt="logo" width="100px" height="100px" />
            <h2>TechNohub</h2>
          </div>
          <nav class="h-100 d-flex align-items-start navbar w-100">
            <ul class="h-100 mt-2 d-flex flex-column align-items-center navbar-nav w-100 position-relative">
              <li class="w-100 nav-item d-flex justify-content-center">
                <a class="w-100 d-flex align-items-center nav-link fs-5" href="#">
                  <div class="col-4 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('dashboard-assets/dashboard.png') }}" alt="dashboard image" width="30px" height="30px" />
                  </div>
                  <div class="col-8">Dashboard</div>
                </a>
              </li>
              <li class="w-100 nav-item d-flex justify-content-center">
                <a class="w-100 d-flex align-items-center nav-link fs-5" href="{{ route('product.page') }}">
                  <div class="col-4 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('dashboard-assets/dashboard.png') }}" alt="dashboard image" width="30px" height="30px" />
                  </div>
                  <div class="col-8">Product</div>
                </a>
              </li>
              <li class="w-100 nav-item d-flex justify-content-center">
                <a class="w-100 d-flex align-items-center nav-link fs-5" href="#">
                  <div class="col-4 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('dashboard-assets/dashboard.png') }}" alt="dashboard image" width="30px" height="30px" />
                  </div>
                  <div class="col-8">Transaksi</div>
                </a>
              </li>
              <li class="w-100 nav-item d-flex justify-content-center position-absolute bottom-0 start-50 translate-middle-x">
                <a class="w-100 d-flex align-items-center nav-link fs-5" href="{{ route('admin.logout') }}">
                  <div class="col-4 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('dashboard-assets/keluar.png') }}" alt="dashboard image" width="30px" height="30px" />
                  </div>
                  <div class="col-8">Keluar</div>
                </a>
              </li>
            </ul>
          </nav>
        </div>