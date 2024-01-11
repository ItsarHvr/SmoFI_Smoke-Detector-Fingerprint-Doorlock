<form action="/input-data" method="POST">
    @csrf
    <input type="text" name="id" placeholder="ID"><br>
    <input type="text" name="nama" placeholder="Nama"><br>
    <input type="text" name="kelas" placeholder="Kelas"><br>
    <input type="text" name="nim" placeholder="NIM"><br>
    <button type="submit">Submit</button>
</form>
