@extends('layouts.app')
@section('title')
Master Kategori
@endsection

@section('breadcrumb')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.html">Master</a></li>
    <li class="breadcrumb-item active">Kategori COA</li>
    <li class="breadcrumb-item active">Tambah</li>
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
                    <h3 class="text-left font-weight-light my-">Tambah Kategori</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('master_category.store') }}" method="POST">
                        @csrf
                        @include('master.master_category._form')
                        <div class="mt-4 mb-0">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('master_category.index') }}" class="btn btn-danger w-50 text-center">Cancel</a>
                                <button type="submit" class="btn btn-primary w-50">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection