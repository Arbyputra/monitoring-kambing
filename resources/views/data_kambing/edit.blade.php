@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Data Kambing</h3>

    <form action="{{ route('data_kambing.update', $kambing->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('data_kambing.form', ['kambing' => $kambing])
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('data_kambing.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
