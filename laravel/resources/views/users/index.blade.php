<!-- resources/views/users/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h2>Daftar Users</h2>

    <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah User Baru</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->password }}</td>
                    <td>{{ $user->tanggal }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
