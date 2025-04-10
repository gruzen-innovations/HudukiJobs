@if (Session::has('AccessToken'))
    <?php $value = Session::get('AccessToken'); ?>
@else
    <script>
        window.location.href = "MyDashboard";
    </script>
@endif

@extends('templates.myadmin.layout')

@section('content')
    <div class="col-sm-6 col-lg-3" style="margin-bottom: 3%;">

        <a href="{{ url('wholesalers') }}">
            <div class="card text-white bg-flat-color-1" style="background:seagreen;">

                <div class="card-body pb-0">

                    <p class="text-light"><i class="fa fa-user"></i> &nbsp;Total Employer</p>

                    <h4 class="mb-0">

                        <span class="count">{{ $wholesaler_count }}</span>

                    </h4>

                </div>

            </div>
        </a>

    </div>
    <div class="col-sm-6 col-lg-3" style="margin-bottom: 3%;">

        <a href="{{ url('employee') }}">
            <div class="card text-white bg-flat-color-1" style="background:teal;">

                <div class="card-body pb-0">

                    <p class="text-light"><i class="fa fa-user"></i> &nbsp;Total Employee's</p>

                    <h4 class="mb-0">

                        <span class="count">{{ $employee_count }}</span>

                    </h4>

                </div>

            </div>
        </a>

    </div>
    <div class="col-sm-6 col-lg-3" style="margin-bottom: 3%;">

        <a href="{{ url('ecomm-plans') }}">
            <div class="card text-white bg-flat-color-1" style="background:slateblue;">

                <div class="card-body pb-0">

                    <p class="text-light"><i class="fa fa-user"></i> &nbsp;Total Subscription Plans</p>

                    <h4 class="mb-0">

                        <span class="count">{{ $enquiry_count }}</span>

                    </h4>

                </div>

            </div>
        </a>

    </div>

    <div class="col-sm-6 col-lg-3" style="margin-bottom: 3%;">

        <a href="{{ url('/employee?active=today') }}" style="text-decoration: none;">
            <div class="card text-white bg-flat-color-1" style="background:rgb(64, 141, 242);">

                <div class="card-body pb-0">

                    <p class="text-light"><i class="fa fa-user"></i> &nbsp;Total Active User's Today </p>

                    <h4 class="mb-0">

                        <span class="count">{{ $active_users_today_count }}</span>

                    </h4>

                </div>

            </div>
        </a>

    </div>

    <div class="text-center my-4">
        <div class="btn-group" role="group">
            <button class="btn btn-outline-primary" onclick="updateCharts('weekly')">Weekly</button>
            <button class="btn btn-outline-primary" onclick="updateCharts('monthly')" id="defaultView">Monthly</button>
            <button class="btn btn-outline-primary" onclick="updateCharts('yearly')">Yearly</button>
        </div>
    </div>

    {{-- Bar Charts --}}
    <div class="row">
        <div class="col-md-6">
            <canvas id="barChart1"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="barChart2"></canvas>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const chartData = @json($chartData, JSON_PRETTY_PRINT);
        let employerChart, employeeChart;

        function updateCharts(range) {
            if (!['weekly', 'monthly', 'yearly'].includes(range)) {
                console.error('Invalid range:', range);
                return;
            }

            const labels = chartData[range].labels;
            const employers = chartData[range].employers;
            const employees = chartData[range].employees;

            console.log('Range:', range);
            console.log('Labels:', labels);
            console.log('Employers:', employers);
            console.log('Employees:', employees);

            const employerCtx = document.getElementById('barChart1').getContext('2d');
            const employeeCtx = document.getElementById('barChart2').getContext('2d');

            if (employerChart) employerChart.destroy();
            if (employeeChart) employeeChart.destroy();

            employerChart = new Chart(employerCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Employers',
                        data: employers,
                        backgroundColor: 'rgba(0, 128, 0, 0.6)',
                        borderColor: 'rgba(0, 128, 0, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    onClick: (event, elements) => {
                        if (elements.length > 0) {
                            const index = elements[0].index;
                            const label = chartData[range].labels[index];
                            window.location.href = `/wholesalers?range=${range}&period=${label}`;
                        }
                    },
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: `Employer Registrations (${range.charAt(0).toUpperCase() + range.slice(1)})`
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            employeeChart = new Chart(employeeCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Employees',
                        data: employees,
                        backgroundColor: 'rgba(0, 0, 128, 0.6)',
                        borderColor: 'rgba(0, 0, 128, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    onClick: (event, elements) => {
                        if (elements.length > 0) {
                            const index = elements[0].index;
                            const label = chartData[range].labels[index];
                            window.location.href = `/employee?range=${range}&period=${label}`;
                        }
                    },
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: `Employee Signups (${range.charAt(0).toUpperCase() + range.slice(1)})`
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        window.onload = function() {
            updateCharts('monthly');
        };
    </script>
@endsection
