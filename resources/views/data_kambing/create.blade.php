@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Tambah Data Kambing</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('data_kambing.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('data_kambing.form')
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('data_kambing.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
