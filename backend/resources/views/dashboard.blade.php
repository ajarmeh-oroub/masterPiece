@extends('layouts.layoutAdmin')
@section('title' ,'Home page')
@section('content')

    <div class="container-fluid py-2">
    <div class="row">
    <canvas id="ordersChart" width="400" height="200"></canvas>

    </div>
           
       

    </div>
@endsection
    @section('scripts')
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Retrieve data from Blade
        const pharmacies = @json($pharmacies);
        const totalOrders = @json($totalOrders);

        // Get the canvas element
        const ctx = document.getElementById('ordersChart').getContext('2d');

        // Create the chart
        new Chart(ctx, {
            type: 'bar',  // You can change this to 'line', 'pie', etc.
            data: {
                labels: pharmacies,  // Pharmacy names
                datasets: [{
                    label: 'Total Orders',
                    data: totalOrders,  // Total orders for each pharmacy
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',  // Bar color
                    borderColor: 'rgba(54, 162, 235, 1)',  // Bar border color
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true  // Ensures the Y-axis starts at zero
                    }
                }
            }
        });
    });
</script>
    @endsection


