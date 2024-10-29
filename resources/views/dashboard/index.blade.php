@extends('layouts.app')

@section('title')
Dashboard
@endsection

@section('breadcrumb')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    <li class="breadcrumb-item active">Index</li>
</ol>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-xl-4">
            <div class="card mb-4 text-center">
                <div class="card-header">
                    <i class="fas fa-chart-circle me-1"></i>
                    Total Transaksi
                </div>
                <div class="card-body">
                    <canvas id="totalTransactionsChart" width="100%" height="100"></canvas>
                    <h3 id="totalTransactionsCount">{{ $transactions->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card mb-4 text-center">
                <div class="card-header">
                    <i class="fas fa-chart-circle me-1"></i>
                    Total Debit
                </div>
                <div class="card-body">
                    <canvas id="totalDebitChart" width="100%" height="100"></canvas>
                    <h3 id="totalDebitAmount">Rp {{ number_format($totalDebit, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card mb-4 text-center">
                <div class="card-header">
                    <i class="fas fa-chart-circle me-1"></i>
                    Total Credit
                </div>
                <div class="card-body">
                    <canvas id="totalCreditChart" width="100%" height="100"></canvas>
                    <h3 id="totalCreditAmount">Rp {{ number_format($totalCredit, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalTransactions = {{ $transactions->count() }};
        const totalTransactionsCtx = document.getElementById('totalTransactionsChart').getContext('2d');
        new Chart(totalTransactionsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Total Transaksi', 'Sisa'],
                datasets: [{
                    data: [totalTransactions, 0],
                    backgroundColor: ['#36A2EB', '#E4E4E4'],
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        const totalDebit = {{ $totalDebit }};
        const totalDebitCtx = document.getElementById('totalDebitChart').getContext('2d');
        new Chart(totalDebitCtx, {
            type: 'doughnut',
            data: {
                labels: ['Total Debit', 'Sisa'],
                datasets: [{
                    data: [totalDebit, 0],
                    backgroundColor: ['#4BC0C0', '#E4E4E4'],
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        const totalCredit = {{ $totalCredit }};
        const totalCreditCtx = document.getElementById('totalCreditChart').getContext('2d');
        new Chart(totalCreditCtx, {
            type: 'doughnut',
            data: {
                labels: ['Total Credit', 'Sisa'],
                datasets: [{
                    data: [totalCredit, 0],
                    backgroundColor: ['#FF6384', '#E4E4E4'],
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });
    });
</script>
@endsection