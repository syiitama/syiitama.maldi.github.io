<!-- <?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_maldi";
// Buat koneksi
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query SQL
$sql = "SELECT * FROM tb_penyakit";
$result = mysqli_query($conn, $sql);

// Ambil data
$data = array();
while($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Encode ke JSON
$json = json_encode($data, JSON_PRETTY_PRINT);

// Cetak JSON (atau kirim sebagai respons HTTP)
echo $json;

// Tutup koneksi
mysqli_close($conn);
?> -->