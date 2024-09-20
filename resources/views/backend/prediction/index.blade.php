@extends('layouts.master')

@push('css')
<link rel="stylesheet" href="/lte/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<style>
    #image-preview {
        max-width: 100%;
        max-height: 200px;
        margin-top: 10px;
        display: block; /* Menampilkan gambar dengan tepi yang lebih baik */
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Tabel Angka Meter Air</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Tabel</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="predictionsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Angka Meter Air</th>
                                        <th>Tanggal Angka Masuk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (array_reverse($predictions) as $prediction)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $prediction->prediction }}</td>  
                                        <td>{{ $prediction->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@push('js')

<script src="/lte/plugins/datatables/jquery.dataTables.js"></script>
<script src="/lte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
    $(function () {
        var predictions = @json($predictions); // Ambil data predictions dari controller

        // Datatables
        $('#predictionsTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });
    });
</script>
@endpush
