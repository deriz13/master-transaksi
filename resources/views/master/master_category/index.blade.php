@extends('layouts.app')
@section('title')
Master Kategori
@endsection

@section('breadcrumb')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="#">Master</a></li>
    <li class="breadcrumb-item active">Kategori</li>
</ol>
@endsection
@section('content')
@if (Session::has('success'))
<div id="alert-message" class="alert alert-success alert-dismissible fade show" role="alert">
    {{ Session::get('success') }}
</div>
@endif
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tabel Kategori COA</span>
        <a href="{{ route('master_category.create') }}" class="btn btn-primary">Create</a>
    </div>

    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($master_categories as $mc)
                <tr>
                    <th>{{ $loop->index + 1 }}</th>
                    <td>{{ $mc->name }}</td>
                    <th>
                        <a href="{{ route('master_category.edit', ['id' => $mc->id]) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="deleteItem('{{ $mc->id }}')" type="button" class="btn btn-danger btn-sm">
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
                var url = '{{ route("master_category.destroy", ":id") }}';
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

@endsection