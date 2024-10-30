@extends('layouts.app')
@section('title')
Transaksi
@endsection

@section('breadcrumb')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">Transaksi</li>
    <li class="breadcrumb-item active">Edit</li>
</ol>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if (Session::has('error'))
        <div id="alert-message" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('error') }}
        </div>
        @endif
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-left font-weight-light my-">Edit Transaksi</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaction.update', $transactions->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('transaction._form')
                        <div class="mt-4 mb-0">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('transaction.index') }}" class="btn btn-danger w-50 text-center">Cancel</a>
                                <button type="submit" class="btn btn-primary w-50">Edit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection