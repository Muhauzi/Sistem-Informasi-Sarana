<div>
    <script>
        // Fungsi ini dipanggil dari tombol "Hapus"
        function confirmDelete(slug) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Merah untuk tombol hapus
                cancelButtonColor: '#3085d6', // Biru untuk tombol batal
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                // Jika pengguna mengklik "Ya, hapus!"
                if (result.isConfirmed) {
                    // Cari form berdasarkan ID yang unik dan submit form tersebut
                    document.getElementById('delete-form-' + slug).submit();
                }
            });
        }
    </script>
</div>