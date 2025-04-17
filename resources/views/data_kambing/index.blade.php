@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-end mb-3">
            <a href="{{ route('data_kambing.create') }}" class="btn btn-primary mb-3">
                + Tambah Kambing
            </a>
        </div>
        <div class="row">
            @foreach ($kambings as $kambing)
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm border border-secondary rounded-4 px-3 py-2 d-flex flex-row align-items-center "
                        style="cursor: pointer;"
                        onclick="if(!event.target.closest('.dropdown')) { window.location='{{ route('data_kambing.show', $kambing->id) }}'; }">
                        {{-- KIRI: Icon dan Kode --}}
                        <div class="d-flex align-items-center me-3">
                            <div class="rounded-circle bg-light border border-secondary d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px; overflow: hidden;">
                                <img src="{{ asset('images/' . ($kambing->jenis_kelamin === 'betina' ? 'fgoat.png' : 'mgoat.png')) }}"
                                    alt="goat icon" width="60">
                            </div>
                        </div>
                        <div class="me-auto">
                            <h6 class="mb-0 fw-bold text-uppercase">{{ $kambing->kode }}</h6>
                        </div>

                        {{-- KANAN: Gender + Menu --}}
                        <div class="d-flex align-items-center">
                            <span class="me-3">{{ ucfirst($kambing->jenis_kelamin) }}</span>

                            <!-- Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="bi bi-list"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('data_kambing.show', $kambing->id) }}">Detail</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('data_kambing.edit', $kambing->id) }}">Edit</a></li>
                                    <li>
                                        <form action="{{ route('data_kambing.destroy', $kambing->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kambing ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
