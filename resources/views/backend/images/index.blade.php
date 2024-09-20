@extends('layouts.master')

@push('css')
<link rel="stylesheet" href="/lte/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="/lte/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
@endpush

@section('content')
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Daftar Gambar</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Gambar yang Tersimpan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped table-sm">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Devices</th>
                        <th>Gambar</th>
                        <th>Angka Meter Air</th>
                        <th>Base64</th>
                        <th>Tanggal Upload</th>
                        <th>Hapus</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($images->reverse() as $image)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $image->device_name }}</td>
                          <td>
                            <div class="d-flex justify-content-center align-items-center">
                              <img src="data:image/jpeg;base64,{{ $image->image }}" alt="Image" class="img-fluid" style="max-width: 320px; max-height: 240px;">
                            </div>
                          </td>
                          <td>{{ $image->prediction }}</td>
                          <td>
                            <textarea readonly class="form-control" style="width: 100%; height: 100px;">{{ $image->image }}</textarea>
                          </td>
                          <td>{{ $image->created_at }}</td>
                          <td>
                            <form action="{{ route('images.destroy', $image->id) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Hapus</button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>  
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection

@push('js')
<script src="/lte/plugins/jquery/jquery.min.js"></script>
<script src="/lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/lte/plugins/datatables/jquery.dataTables.js"></script>
<script src="/lte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "pageLength": 10 // Set the number of records per page
    });
  });
</script>
@endpush
