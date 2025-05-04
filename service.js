$(document).ready(function () {
  $('#formTambahPenyakit').on('submit', function (e) {
      e.preventDefault(); // Mencegah reload halaman

      $.ajax({
          type: 'POST',
          url: 'insert-penyakit.php',
          data: $(this).serialize(),
          success: function (response) {
              alert(response);
              $('#tambahDataPenyakit').modal('hide');
              location.reload(); // Reload halaman agar tabel terupdate
          },
          error: function () {
              alert("Terjadi kesalahan saat menyimpan data.");
          }
      });
  });
});