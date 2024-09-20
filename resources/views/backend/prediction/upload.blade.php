@extends('layouts.master')

@push('css')
<link rel="stylesheet" href="/lte/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<style>
    #image-preview {
        max-width: 100%;
        max-height: 200px;
        margin-top: 10px;
        display: block;
    }
    .sample-images a {
        display: inline-block;
        margin: 5px;
    }
    .sample-images img {
        max-width: 100%;
        height: auto;
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Angka Meter Air dan Unggah Gambar</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Unggah Gambar</h3>
                        </div>
                        <div class="card-body">
                            <form id="uploadForm" action="http://192.168.43.200:8000/upload_image" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="image">Pilih Gambar</label>
                                    <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                                    <img id="image-preview" src="#" alt="Preview" style="display: none;">
                                </div>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Hasil Prediksi Terbaru</h3>
                        </div>
                        <div class="card-body">
                            <p id="prediction-result" style="font-size: 67px; font-weight: bold;">{{ $prediksi }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Sample Gambar</h3>
                        </div>
                        <div class="card-body sample-images">
                            <a href="https://ibb.co.com/Pz0T33Y">
                                <img src="https://i.ibb.co.com/pr5WGGP/1.jpg" alt="Sample Image 1" border="0">
                            </a>
                            <a href="https://ibb.co.com/p3BhWDV">
                                <img src="https://i.ibb.co.com/fCzD8R6/2.jpg" alt="Sample Image 2" border="0">
                            </a>
                            <a href="https://ibb.co.com/3SRJjVs">
                                <img src="https://i.ibb.co.com/5sK7SC9/3.jpg" alt="Sample Image 3" border="0">
                            </a>
                            <a href="https://ibb.co.com/dLY6G1q">
                                <img src="https://i.ibb.co.com/P9H4w3n/4.jpg" alt="Sample Image 4" border="0">
                            </a>
                            <a href="https://ibb.co.com/jg0zZ7T">
                                <img src="https://i.ibb.co.com/f469Gm2/5.jpg" alt="Sample Image 5" border="0">
                            </a>
                            <a href="https://ibb.co.com/82bVLzJ">
                                <img src="https://i.ibb.co.com/6b857v2/6.jpg" alt="Sample Image 6" border="0">
                            </a>
                            <a href="https://ibb.co.com/82bVLzJ">
                                <img src="https://i.ibb.co.com/6b857v2/6.jpg" alt="Sample Image 7" border="0">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(function () {
    var predictions = @json($predictions);

    // Inisialisasi grafik garis
    var ctxLine = document.getElementById('predictionLineChart').getContext('2d');
    var predictionLineChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: [], // Label akan diperbarui berdasarkan dropdown
            datasets: [{
                label: 'Nilai Prediksi',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: [], // Data akan diperbarui berdasarkan dropdown
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            }
        }
    });

    // Inisialisasi grafik batang
    var ctxBar = document.getElementById('predictionBarChart').getContext('2d');
    var predictionBarChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: [], // Label akan diperbarui berdasarkan dropdown
            datasets: [{
                label: 'Nilai Prediksi',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                data: [], // Data akan diperbarui berdasarkan dropdown
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    // Fungsi untuk memperbarui grafik berdasarkan index
    function updateCharts(index) {
        if (index < predictions.length) {
            var data = predictions[index];
            console.log(data);
            var labels = data.map((_, i) => i + 1);

            // Update grafik garis
            predictionLineChart.data.labels = labels;
            predictionLineChart.data.datasets[0].data = data;
            predictionLineChart.update();

            // Update grafik batang
            predictionBarChart.data.labels = labels;
            predictionBarChart.data.datasets[0].data = data;
            predictionBarChart.update();
        }
    }

    // Event listener untuk dropdown
    $('#lineChartDropdown').change(function () {
        var selectedOption = $(this).val();
        var index = parseInt(selectedOption); // Konversi nilai dropdown ke integer
        console.log('Selected option:', index);
        updateCharts(index);
    });

    // Menginisialisasi grafik dengan pilihan default
    updateCharts(0);

    $('#image').change(function () {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image-preview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#image-preview').hide();
        }
    });
});

</script>
@endpush
