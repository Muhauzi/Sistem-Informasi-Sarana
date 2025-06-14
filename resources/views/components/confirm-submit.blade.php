<div>
    <!-- <button type="button" onclick="confirmSubmit()">Submit</button> -->

    <script>
    function confirmSubmit($idform) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akan disimpan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, kirim!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Cari form berdasarkan ID yang unik dan submit form tersebut
                document.getElementById($idform).submit();
            }
        });
    }
    </script>
</div>