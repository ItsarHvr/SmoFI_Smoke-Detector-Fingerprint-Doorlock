<form action="{{ route('process.form') }}" method="post">
    @csrf
    <label for="id">ID:</label>
    <input type="text" name="id" id="id">
    <button type="submit">Submit</button>
</form>
