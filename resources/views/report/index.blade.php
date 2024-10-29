@extends('layouts.app')

@section('title')
Laporan Profit / Los
@endsection

@section('breadcrumb')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">Laporan</li>
    <li class="breadcrumb-item active">Profit / Los</li>
</ol>
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tabel Laporan</span>
        <a href="{{ route('master_chart.create') }}" class="btn btn-primary">Create</a>
    </div>

    <div class="card-body">
        <table class="custom-table">
            <thead>
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">Category</th>
                    @foreach($dates as $date)
                        <th class="text-center">{{ $date }}</th>
                    @endforeach
                    <th rowspan="2">Total</th>
                </tr>
                <tr>
                    @foreach($dates as $date)
                        <th>Amount</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($groupedProfits as $category => $profits)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $category }}</td>
                        @php $categoryTotal = 0; @endphp
                        @foreach($dates as $date)
                            <td class="text-center">
                                {{ $profits[$date]['profit'] ?? 0 }}
                            </td>
                            @php $categoryTotal += ($profits[$date]['profit'] ?? 0); @endphp
                        @endforeach
                        <td class="text-center">{{ $categoryTotal }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-center">Total Pendapatan Bersih</th>
                    @foreach($dates as $date)
                        <td class="text-center">
                            {{ $totalProfits[$date]['total_profit'] ?? 0 }}
                        </td>
                    @endforeach
                    <td class="text-center">
                        {{ array_sum(array_column($totalProfits, 'total_profit')) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection