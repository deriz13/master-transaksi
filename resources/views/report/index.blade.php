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
        <button class="btn btn-success btn-round ml-2" id="exportExcel">
            <i class="fa fa-file-excel"></i>
            Export Excel
        </button>
    </div>
    <div class="card-body">
        <table class="custom-table">
            <thead>
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">Category</th>
                    @foreach($dates as $date)
                    <th class="text-center">{{ \Carbon\Carbon::parse($date)->translatedFormat('F Y') }}</th>
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
                        Rp. {{ number_format($profits[$date]['profit'] ?? 0, 0, ',', '.') }}
                    </td>
                    @php $categoryTotal += ($profits[$date]['profit'] ?? 0); @endphp
                    @endforeach
                    <td class="text-center">Rp. {{ number_format($categoryTotal, 0, ',', '.') }}</td>
                </tr>

                @if(in_array($category, ['Other Income', 'Meal Expense']))
                <tr>
                    <td></td>
                    <td><strong>Total {{ $category }}</strong></td>
                    @php $subtotal = 0; @endphp
                    @foreach($dates as $date)
                    @php $subtotal += ($profits[$date]['profit'] ?? 0); @endphp
                    <td class="text-center">
                        <strong>Rp. {{ number_format($profits[$date]['profit'] ?? 0, 0, ',', '.') }}</strong>
                    </td>
                    @endforeach
                    <td class="text-center">
                        <strong>Rp. {{ number_format($subtotal, 0, ',', '.') }}</strong>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-center">Net Income</th>
                    @foreach($dates as $date)
                    <td class="text-center">
                        Rp. {{ number_format($totalProfits[$date]['total_profit'] ?? 0, 0, ',', '.') }}
                    </td>
                    @endforeach
                    <td class="text-center">
                        Rp. {{ number_format(array_sum(array_column($totalProfits, 'total_profit')), 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    document.getElementById('exportExcel').addEventListener('click', function() {
        window.location.href = "{{ route('report.export-excel') }}";
    });
</script>
@endsection