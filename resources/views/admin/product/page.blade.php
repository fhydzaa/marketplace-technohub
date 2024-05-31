@extends('admin.layouts.app')
@section('content')
        <div class="container d-flex align-items-center justify-content-center">
          <form class="d-flex flex-row justify-content-center align-items-center gap-4">
            <div class="py-4" style="width: 500px">
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" />
            </div>
            <div class="py-4">
              <button type="submit" class="btn btn-primary rounded-4 px-4">Submit</button>
            </div>
          </form>
        </div>

        <div class="container bg-light h-100 mb-3 rounded-4">
          <div class="py-3">
            <a href="{{ route('product.buat') }}" class="ms-5 btn btn-primary rounded-4 px-4">Add Product</a>
          </div>
          <table class="table text-center">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Product</th>
                <th scope="col">Harga</th>
                <th scope="col">Gambar</th>
                <th scope="col">Jenis</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Mantap</td>
                <td class="d-flex flex-row gap-3 justify-content-center">
                  <div>
                    <button type="button" class="btn btn-success rounded-4 px-5">Edit</button>
                  </div>
                  <div>
                    <button type="button" class="btn btn-danger rounded-4 px-5">Hapus</button>
                  </div>
                  <div>
                    <button type="button" class="btn rounded-4 px-5" style="background-color: #032D64; color: white;">Detail</button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
@endsection