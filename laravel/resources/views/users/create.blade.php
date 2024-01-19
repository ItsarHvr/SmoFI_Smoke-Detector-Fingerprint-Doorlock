<!-- resources/views/users/create.blade.php -->

@extends('layouts.app')

@section('content')
    <h2>Tambah User Baru</h2>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal Lahir:</label>
            <input type="text" name="tanggal" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
