@extends('layouts.master')

@push('css')
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endpush

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Selamat Datang Di Sistem Informasi Monitoring Perangkat Smart Water PDAM</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalImages }}</h3>
                            <p>Total Gambar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="/images" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
 <div class="row">
                <div class="col-12">
                    <div style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1975.8845471239445!2d112.62121554207503!3d-7.919171157046053!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd62b0047d37b55%3A0xa9ba0fdce60c9e6!2sSambel%20Babat%20Ceria!5e0!3m2!1sid!2sid!4v1718955268469!5m2!1sid!2sid" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <canvas id="imageChart"></canvas>
                </div>
            </div>

           
        </div>
    </section>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('imageChart').getContext('2d');
        var labels = {!! $labels !!};
        var data = {!! $data !!};

        var imageChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Gambar',
                    data: data,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endpush
