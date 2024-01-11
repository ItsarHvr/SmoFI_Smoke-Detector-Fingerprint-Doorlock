<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/stylesmoke.css') }}">
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
						<td>{{ $user->id_fingerprint}}</td>
                        <td>
                        <a href="{{ route('enroll.edit', $user->id) }}" class="btn btn-warning">Enroll</a>
                            <a href="{{ route('userlist.edit', $user->id) }}" class="btn btn-warning">Edit</a>

							<form action="{{ route('userlist.destroy', $user->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            <!-- Since we don't have actual pagination data, I'm using a placeholder link -->
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
            </ul>
        </div>
        <a href="{{ url('/home') }}" class="btn btn-primary">Back to Dashboard</a>
    </div>
</body>
</html>
