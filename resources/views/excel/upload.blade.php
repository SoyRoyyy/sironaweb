<!DOCTYPE html>
<html>
<head>
    <title>Upload Excel</title>
</head>
<body>
    <h2>Upload Excel</h2>

    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('excel.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
