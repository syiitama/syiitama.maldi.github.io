<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title class="no-print">MALDI || DIAGNOSA</title>
    <link rel="stylesheet" href="styles.css">

    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>

    
</head>

<body>
    <div class="no-print">
        <?php
        session_start(); // Start the session

        include "layout/header.php";
        include "service/database.php"; // Include the database connection
        ?>
    </div>

    <main>

        <?php if (isset($_SESSION["is_login"])): ?> <!-- Check if user is logged in -->
            <!-- form diagnosa -->
            <form id="diagnosa-malaria" class="no-print" method="post" action="diagnosa.js">
                <h2>Diagnosa Penyakit Malaria</h2>

                <table class="data-pasien ">
                    <tr>
                        <td><label for="nama">Nama Pasien</label></td>
                        <td>:</td>
                        <td> <input required type="text" id="nama" name="nama" placeholder="Nama Pasien"></td>
                    </tr>
                    <tr>
                        <td><label required for="umur">Umur</label></td>
                        <td>:</td>
                        <td><input required type="text"  id="umur" name="umur" placeholder="Umur Pasien"></td>
                    </tr>
                    <tr>
                        <td><label for="alamat">Alamat</label></td>
                        <td>:</td>
                        <td><input required type="text" id="alamat" name="alamat" placeholder="Alamat Pasien"></td>
                    </tr>
                    <tr>
                        <td><label for="tanggal-periksa">Tanggal Periksa</label></td>
                        <td>:</td>
                        <td><?php echo date('Y-m-d'); ?></td>
                    </tr>
                </table>
<!--  tanggal melakukan pemeriksaan/tanggal periksa -->
                <!-- <p>Tanggal periksa: </p>  -->
                <p>Silakan jawab pertanyaan-pertanyaan berikut untuk membantu kami mendiagnosa penyakit malaria:</p>

                <?php
                // Fetch all symptoms from the database
                $query = "SELECT  kd_gejala, gejala FROM tb_gejala";
                $result = mysqli_query($db, $query);
                $index = 1; // Initialize index for numbering
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<label  class="check-container" >';
                    echo '<h3>' . $index . '. Pasien mengalami ' . $row['gejala'] . '.</h3>';
                    echo '<input  type="checkbox" class="cekcontainer"  value= ' . $row['kd_gejala'] . '>';
                    echo '<span class="checkmark"></span>';
                    echo '</label>';
                    $index++; // Increment index for next symptom
                }
                ?>

            


                <button type="submit" id="tombol-diagnosa">Diagnosa</button>
            </form>

        
<!--  -->

            <!-- form hasil diagnosa -->
            <form action="" id="diagnosa-malaria" class=" ">
                <div id="print-div" class="print-only">
                    <h3 class="kop-rs">RUMAH SAKIT UMUM DAERAH SERUI</h3>

                </div>
                <div>

                </div>

                <section>
                   
                    <!-- tampil data pasien -->
                    <table id="tabel-hasil" class="b">
                        <tr>
                            <td>
                                <p>Nama Pasien</p>
                            </td>
                            <td>:</td>
                            <td>
                                <p id="nama-pasien"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Umur Pasien</p>
                            </td>
                            <td>:</td>
                            <td>
                                <p id="umur-pasien"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Alamat pasien</p>
                            </td>
                            <td>: </td>
                            <td>
                                <p id="alamat-pasien"></p>
                            </td>
                        </tr>

                    </table>
                    <hr>

                    <p id="daftar-gejala"></p>
                    <br>
                    <h3>Hasil Diagnosa</h3>

                    <p><span id="centang data"></span></p>

                    <p><span id="solusi-malaria"></span></p>

                    <p><span id="hasil-diagnosa"></span></p>

                    <table class="a" id="hasil-diagnosa">
                        <tr class="a">
                            <th class="a">No</th>

                            <th>Diagnosa penyakit</th>
                            <th>Persentase</th>
                            <th>Solusi</th>

                        </tr>
                        <tr>
                            <td>
                                <p>1</p>
                            </td>
                            <td>
                                <p>Malaria Tertiana</p>
                            </td>
                            <td>
                                <p id="persentase-tertiana"></p>
                            </td>
                            <td>
                                <p id="solusi-malaria-tertiana"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>2</p>
                            </td>
                            <td>
                                <p>Malaria Tropika</p>
                            </td>
                            <td>
                                <p id="persentase-tropika"></p>
                            </td>
                            <td>
                                <p id="solusi-malaria-tropika"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>3</p>
                            </td>
                            <td>
                                <p>Malaria Quartana</p>
                            </td>
                            <td>
                                <p id="persentase-quartana"></p>
                            </td>
                            <td>
                                <p id="solusi-malaria-quartana"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>4</p>
                            </td>
                            <td>
                                <p>Malaria Ovale</p>
                            </td>
                            <td>
                                <p id="persentase-ovale"></p>
                            </td>
                            <td>
                                <p id="solusi-malaria-ovale"></p>
                            </td>

                        </tr>
                    </table> 
                    <hr>

                    <div class="print-only ttd">
                        <div></div>
                        <label for="" class="ttd">Petugas</label>
                        <div></div>
                        <label for="">__________</label>
                    </div>

                </section>

                <button type="submit" onclick="window.print()" id="btn" value="cetak" class="no-print">Cetak Hasil</button>
            </form>

        <?php else: ?>
            <h2 class="no-print">Silakan login terlebih dahulu untuk melakukan diagnosa.</h2>
            <a href="login.php" class="cta-button no-print">Login</a>
        <?php endif; ?>
        </section>
        <script src="solusi.js"></script>
        <script src="ambilKodeGejala.js"></script>
        <script src="ambilKodeGejala.js"></script>
        <script src="service/hitungBobotGejala.js"></script>
        <!-- <script src="diagnosa.js"></script> -->


        
    </main>
    <?php include "layout/footer.php" ?>
    
</body>

</html>