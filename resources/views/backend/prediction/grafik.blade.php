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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Grafik Angka Meter Air (Line Chart)</h3>
                           
                        </div>
                        <div>
                         <select id="lineChartDropdown" class="form-control form-control-sm" style="width: auto;">
                            <option value="0">Semua Device</option>
                            @php $i = 1 @endphp
                            @foreach($device as $dev)
                                <option value="{{$i++}}">{{ $dev->device_name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="card-body">
                            <canvas id="predictionLineChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Angka Meter Air (Bar Chart)</h3>
                        </div>
                        
                        <div class="card-body">
                            <canvas id="predictionBarChart"></canvas>
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
                        beginAtZero: false
                    }
                }]
            }
        }
    });

    // Fungsi untuk memperbarui grafik berdasarkan index
    function updateCharts(index) {
        if (index < predictions.length) {
            var data = predictions[index]['prediction'];
            console.log(data);
            var labels = predictions[index]['created_at'];

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
