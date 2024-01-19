<!-- resources/views/users/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <h2>Edit User</h2>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" value="{{ $user->password }}" required>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal Lahir:</label>
            <input type="text" name="tanggal" class="form-control" value="{{ $user->tanggal }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
@endsection
