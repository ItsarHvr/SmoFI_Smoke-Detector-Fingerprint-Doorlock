<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/userlist.css') }}">
    <title>User List - Smart Door Lock Using Fingerprint & Smoke Detector</title>
</head>

<body>
    <div class="container">
        <h1>User List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>UID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Fingerprint ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->id_fingerprint }}</td>
                        <td>
                            <a href="{{ route('enroll.enroll', ['id' => $user->id]) }}"
                                class="btn btn-primary">Enroll</a>

                            <a href="{{ route('userlist.edit', $user->id) }}"
                                class="btn btn-warning">Edit</a>

                            <form action="{{ route('userlist.destroy', $user->id) }}" method="post"
                                class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
        <a href="{{ url('/home') }}" class="btn btn-primary">Back to Dashboard</a>
    </div>
</body>

</html>
