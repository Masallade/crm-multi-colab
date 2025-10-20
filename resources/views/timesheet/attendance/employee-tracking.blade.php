@extends('layout.main')
@section('content')

    <!-- External Dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    
    <style>
        .header {
            margin-bottom: 25px;
            text-align: center;
        }
        .header h4 {
            color: #1e40af;
            font-weight: 600;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
            margin-bottom: 25px;
            overflow: hidden;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 16px 20px;
        }
        .chart-container {
            height: 320px;
            padding: 20px;
            background-color: #fff;
        }
        .stats-container {
            padding: 0 10px;
        }
        .stats-box {
            background-color: #fff;
            border-radius: 10px;
            padding: 16px;
            height: 100%;
            box-shadow: 0 3px 10px rgba(0,0,0,0.04);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stats-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
        }
        .stats-label {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .stats-value {
            font-size: 22px;
            font-weight: 600;
        }
        .stats-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }
        .positive { color: #10b981; background-color: rgba(16, 185, 129, 0.1); }
        .negative { color: #ef4444; background-color: rgba(239, 68, 68, 0.1); }
        .neutral { color: #3b82f6; background-color: rgba(59, 130, 246, 0.1); }
        .gray { color: #6b7280; background-color: rgba(107, 114, 128, 0.1); }
        .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            font-size: 14px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }
    </style>

    <section>
        <div class="container-fluid">

        <div class="header">
            <h4>Employee Working Hours Dashboard</h4>
        </div>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold">Performance Overview</span>
                <div class="d-flex gap-3">
                    <select id="employeeSelect" class="form-select" style="width: 160px;">
                        @foreach($Employee as $key)
                        <option value="{{ $key->id }}">{{ $key->first_name.' '.$key->last_name }}</option>
                        @endforeach
                    </select>
                    <select id="timeframeSelect" class="form-select" style="width: 130px;">
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly" selected>Monthly</option>
                    </select>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="hoursChart"></canvas>
            </div>
        </div>
        
        <div class="row stats-container g-4">
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="stats-icon neutral">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                        </svg>
                    </div>
                    <div class="stats-label">Average Hours</div>
                    <div class="stats-value" id="avgHours">8.2</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="stats-icon positive">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5z"/>
                        </svg>
                    </div>
                    <div class="stats-label">Highest</div>
                    <div class="stats-value" id="highHours">9.5h</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="stats-icon negative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"/>
                        </svg>
                    </div>
                    <div class="stats-label">Lowest</div>
                    <div class="stats-value" id="lowHours">6.8h</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="stats-icon gray">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                    </div>
                    <div class="stats-label">Target Met</div>
                    <div class="stats-value" id="targetMet">70%</div>
                </div>
            </div>
        </div>

        </div>
    </section>


@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {
    // Chart initialization
    const ctx = document.getElementById('hoursChart').getContext('2d');

    const gradientFill = ctx.createLinearGradient(0, 0, 0, 300);
    gradientFill.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
    gradientFill.addColorStop(1, 'rgba(59, 130, 246, 0.02)');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Hours Worked',
                    data: [],
                    borderColor: '#3b82f6',
                    backgroundColor: gradientFill,
                    borderWidth: 2.5,
                    tension: 0.2,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Target',
                    data: [],
                    borderColor: 'rgba(107, 114, 128, 0.6)',
                    borderWidth: 1.5,
                    borderDash: [5, 5],
                    pointRadius: 0,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Hours',
                        font: { weight: '500' }
                    },
                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Day',
                        font: { weight: '500' }
                    },
                    grid: { display: false }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            let value = tooltipItem.raw;
                            let hours = Math.floor(value);
                            let minutes = Math.round((value - hours) * 60);
                            return ` ${hours}h ${minutes}m`;
                        }
                    },
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#334155',
                    bodyColor: '#334155',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6,
                    cornerRadius: 8,
                    displayColors: false
                },
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        boxWidth: 12,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        font: { size: 13 }
                    }
                }
            }
        }
    });

    function fetchEmployeeStats(employeeId, timeframe) {
        return $.ajax({
            url: "<?= url('/staff/get-employee-stats') ?>",
            type: "GET",
            data: { employee_id: employeeId, timeframe: timeframe },
            dataType: "json",
            success: function (response) {
                updateChart(response, timeframe);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }

    function updateChart(data, timeframe) {
        if (data) {
            document.getElementById('avgHours').textContent = data.stats.avg + 'h';
            document.getElementById('highHours').textContent = data.stats.high + 'h';
            document.getElementById('lowHours').textContent = data.stats.low + 'h';
            document.getElementById('targetMet').textContent = data.stats.target + '%';

            chart.data.labels = data.labels;
            chart.data.datasets[0].data = data.data.map(Number);

            let maxHours = timeframe === 'daily' ? 10 : timeframe === 'weekly' ? 70 : 300;
            chart.data.datasets[1].data = Array(data.labels.length).fill(maxHours);

            chart.update();
        }
    }

    // Event listeners using jQuery
    $('#employeeSelect, #timeframeSelect').on('change', function () {
        let employeeId = $('#employeeSelect').val();
        let timeframe = $('#timeframeSelect').val();
        if (employeeId) {
            fetchEmployeeStats(employeeId, timeframe);
        }
    });

    // Initial chart load
    $(document).ready(function () {
        let employeeId = $('#employeeSelect').val();
        let timeframe = $('#timeframeSelect').val();
        if (employeeId) {
            fetchEmployeeStats(employeeId, timeframe);
        }
    });

});

    </script>
@endpush 
