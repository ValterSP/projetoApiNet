<!-- resources/views/estatistica/index.blade.php -->
@extends('template.layout')

@section('main')
    <style>
        .chart-container {
            width: 80%;
            margin: 0 auto;
        }

        .summary {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .summary-item {
            text-align: center;
        }

        .summary-item h2 {
            font-size: 20px;
        }

        .summary-item p {
            font-size: 16px;
            font-weight: bold;
        }
    </style>
    <div class="summary">
        <div class="summary-item">
            <h2>Total T-Shirts Vendidas:</h2>
            <p>{{ $totalTshirts }}</p>
        </div>
        <div class="summary-item">
            <h2>Tshirt Mais Vendida:</h2>
            @if(!Storage::disk('tshirt_images_private')->exists($tshirtMaisVendida->tshirtImage->image_url))
                <img src="{{ asset('storage/tshirt_images/' . $tshirtMaisVendida->tshirtImage->image_url) }}" alt="" width="100px">
            @else
                <img src="data:image/png;base64, {{ base64_encode(Storage::disk('tshirt_images_private')->get($tshirtMaisVendida->tshirtImage->image_url)) }}" alt="" width="100px">
            @endif
        </div>
        <div class="summary-item">
            <h2>Cor Mais Vendida:</h2>
            <img src="{{ asset('storage/tshirt_base/' . $corMaisVendida->color_code .".jpg") }}" alt="" width="100px">
        </div>
        <div class="summary-item">
            <h2 style="margin-right: 20px">Total Ganho:</h2>
            <p>{{ $totalGanho }}€</p>
        </div>
    </div>
    <div class="chart-container">
        <canvas id="grafico"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('grafico').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Dinheiro Ganho (em €)',
                    data: {!! json_encode($valores) !!},
                    backgroundColor: 'rgba(67,173,34,0.2)',
                    borderColor: 'rgb(74,208,70)',
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
    </script>
@endsection
