@extends('layouts.app')
@section('title')
Transaksi
@endsection

@section('breadcrumb')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">Transaksi</li>
    <li class="breadcrumb-item active">Data</li>
</ol>
@endsection
@section('content')
@if (Session::has('success'))
<div id="alert-message" class="alert alert-success alert-dismissible fade show" role="alert">
    {{ Session::get('success') }}
</div>
@endif
<div class="card mb-4">
    <form id="filter-form" class="d-flex gap-2">
        <select name="coa_name" id="coa-name-filter" class="form-select form-select-sm">
            <option value="">Pilih COA Nama</option>
            @foreach($coaNames as $coaName)
            <option value="{{ $coaName }}">{{ $coaName }}</option>
            @endforeach
        </select>
        <select name="category" id="category-filter" class="form-select form-select-sm">
            <option value="">Pilih Kategori</option>
            @foreach($categories as $category)
            <option value="{{ $category }}">{{ $category }}</option>
            @endforeach
        </select>
        <button type="button" id="reset-filter" class="btn btn-outline-secondary btn-sm">Reset</button>
    </form>
</div>
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tabel Transaksi</span>
        <a href="{{ route('transaction.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Create</a>
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>COA Kode</th>
                    <th>COA Nama</th>
                    <th>Kategori</th>
                    <th>Desc</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>COA Kode</th>
                    <th>COA Nama</th>
                    <th>Kategori</th>
                    <th>Desc</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <th>{{ $loop->index + 1 }}</th>
                    <td>{{ \Carbon\Carbon::parse($transaction->date)->translatedFormat('d F Y') }}</td>
                    <td>{{ $transaction->masterChart->code }}</td>
                    <td>{{ $transaction->masterChart->name }}</td>
                    <td>{{ $transaction->masterChart->category->name }}</td>
                    <td>{{ $transaction->desc }}</td>
                    <td>Rp. {{ number_format($transaction->debit ?? 0, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($transaction->credit ?? 0, 0, ',', '.') }}</td>
                        <th>
                    <a href="{{ route('transaction.edit', ['id' => $transaction->id]) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button onclick="deleteItem('{{ $transaction->id }}')" type="button" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i>
                    </button>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script>
    function deleteItem(id) {
        swal({
            title: "Apakah Anda yakin?",
            text: "Anda tidak dapat mengembalikan ini setelah dihapus!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
            closeOnConfirm: false
        }, function(isConfirm) {
            if (isConfirm) {
                var url = '{{ route("transaction.destroy", ":id") }}';
                url = url.replace(':id', id);
                fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Gagal menghapus kategori');
                        }
                        return response.json();
                    })
                    .then(result => {
                        swal("Dihapus!", result.message, "success");
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    })
                    .catch(error => {
                        swal("Gagal!", error.message, "error");
                    });
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        function fetchFilteredData() {
            let coaName = $('#coa-name-filter').val();
            let category = $('#category-filter').val();

            $.ajax({
                url: '{{ route("transaction.index") }}',
                type: 'GET',
                data: {
                    coa_name: coaName,
                    category: category,
                },
                success: function(response) {
                    let tbody = '';
                    response.transactions.forEach((transaction, index) => {
                        tbody += `<tr>
                            <th>${index + 1}</th>
                            <td>${transaction.date}</td>
                            <td>${transaction.master_chart.code}</td>
                            <td>${transaction.master_chart.name}</td>
                            <td>${transaction.master_chart.category.name}</td>
                            <td>${transaction.desc}</td>
                            <td>${transaction.debit}</td>
                            <td>${transaction.credit}</td>
                            <th>
                                <a href="{{ route('transaction.edit', '') }}/${transaction.id}" class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="deleteItem('${transaction.id}')" type="button" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </th>
                        </tr>`;
                    });
                    $('#datatablesSimple tbody').html(tbody);
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }
        $('#coa-name-filter, #category-filter').change(function() {
            fetchFilteredData();
        });
        $('#reset-filter').click(function() {
            $('#coa-name-filter').val('');
            $('#category-filter').val('');
            fetchFilteredData();
        });
    });
</script>
@endsection