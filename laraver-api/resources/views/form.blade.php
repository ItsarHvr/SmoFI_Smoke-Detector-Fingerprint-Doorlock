<!-- resources/views/form.blade.php -->

<form action="{{ route('kirimdata') }}" method="post">
    @csrf
    <label for="data">Data:</label>
    <input type="text" name="data" id="data">
    <button type="submit">Kirim</button>
</form>
