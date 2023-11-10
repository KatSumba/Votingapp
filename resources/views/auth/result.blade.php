@extends('layouts.base')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Election Results</h1>
        
    </div>
    <!-- Page body -->
    <div class="row d-flex justify-content-center align-items-center h-100">
        
        @foreach($chartsData as $chartData)
        <div class="card shadow m-4 col-md-5">
            <div style="width: 80%; margin: auto;">
                <canvas id="{{ $chartData['position'] }}Chart"></canvas>

                <button onclick="exportToPDF('{{ $chartData['position'] }}', @json($chartData))" class="btn btn-link m-4">
                    <i class="fa fa-file" aria-hidden="true"></i> Export
                </button>
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
                        }],
                    };

                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Votes',
                                    },
                                },
                            },
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
                    function exportToPDF(position, chartData) {
                        var pdf = new jsPDF();
                        var canvas = document.getElementById('{{ $chartData['position'] }}Chart');

                        // Convert the canvas to an image
                        var dataURL = canvas.toDataURL('image/png');

                        // Add the image to the PDF
                        pdf.addImage(dataURL, 'PNG', 10, 10, 180, 100);

                        // Save or download the PDF
                        pdf.save(position + '_chart_export.pdf');
                    }
                    
                });
            </script>
        @endforeach

    </div>
</div>
<!-- /.container-fluid -->

@endsection

