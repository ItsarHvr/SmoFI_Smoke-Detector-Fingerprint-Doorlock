<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
</head>
<body>

    <h1>Create a New Post</h1>

    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br>

        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="4" required></textarea>
        <br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        <br>

        <button type="submit">Submit</button>
    </form>

</body>
</html>
