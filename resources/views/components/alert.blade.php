<div>
    @if ($message = session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ $message }}',
            confirmButtonText: 'OK'
        });
    </script>
    @elseif ($message = session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ $message }}',
            confirmButtonText: 'OK'
        });
    </script>
    @elseif ($message = session('warning'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: '{{ $message }}',
            confirmButtonText: 'OK'
        });
    </script>
    @elseif ($message = session('info'))
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: '{{ $message }}',
            confirmButtonText: 'OK'
        });
    </script>
    @endif
</div>