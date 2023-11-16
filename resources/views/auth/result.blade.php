@extends('layouts.base')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Election Results</h1>
        
    </div>
    <!-- Page body -->
    <a href="{{ url('/export-pdf') }}" class="btn btn-secondary m-4">
        <i class="fa fa-download" aria-hidden="true"></i> Export to PDF
    </a>
    <div class="row d-flex justify-content-center align-items-center h-100">
    
        @foreach($chartsData as $chartData)
        <div class="card shadow m-4 col-md-5">
            <div style="width: 80%; margin: auto;">
                <canvas id="{{ $chartData['position'] }}Chart"></canvas>

            </div>
        </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var ctx = document.getElementById('{{ $chartData['position'] }}Chart').getContext('2d');
                    var candidatesData = @json($candidatesData);
                    var candidates = @json($chartData['candidates']);
                    var votes = @json($chartData['votes']);

                    var labels = candidates.map(candidateId => candidatesData[candidateId]);

                    var chartData = {
                        labels: candidates.map(String),
                        datasets: [{
                            label: '{{ $chartData['position'] }}',
                            data: votes,
                            backgroundColor: getRandomColorArray(candidates.length),
                            barPercentage: 1,
                            barThickness: 50,
                        }],
                    };

                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: {
                            layout: {
                                padding: {
                                    top: 20, // Adjust the top padding value as needed
                                    bottom:20,
                                },
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Votes',
                                    },
                                },
                            },
                            maintainAspectRatio: false, // Disable the default aspect ratio
            aspectRatio: 1, // Set the aspect ratio to control the height

                        },
                    });

                    function getRandomColorArray(count) {
                        var colors = [];
                        for (var i = 0; i < count; i++) {
                            colors.push(getRandomColor());
                        }
                        return colors;
                    }

                    function getRandomColor() {
                        var letters = '0123456789ABCDEF';
                        var color = '#';
                        for (var i = 0; i < 6; i++) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }
                        return color;
                    }
                    
                    
                });
            //     

            </script>
        @endforeach

    </div>
</div>
<!-- /.container-fluid -->

@endsection

