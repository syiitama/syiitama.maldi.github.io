<?php

include "service/database.php"; // Include the database connection
include "service/database-master.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MALDI || DATA MASTER</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="style-master.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include "layout/header.php"; ?>

    <main>
        <section class="feature-card">
            <h2 class="header-section">Data Master</h2>

            <!-- Tabel Penyakit -->
            <div class="master-section">
                <h3>Tabel Data Penyakit</h3>
                <a href="#" class="master-cta" id="btnAddPenyakit">Tambah Data Penyakit</a>

                <table class="  master-table" id="penyakit-table">
                    <tr>
                        <th>No</th>
                        <th>Kode Penyakit</th>
                        <th>Nama Penyakit</th>
                        <th>Pengaturan Data</th>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM tb_penyakit";
                    $result = $db->query($sql);
                    if (!$result) {
                        die("Query error: " . $db->error);
                    }
                    $no = 1;
                    while ($row = $result->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['id_penyakit']) ?></td>
                            <td><?= htmlspecialchars($row['nama_penyakit']) ?></td>
                            <td class="action-links">
                                <a href="#" class="delete-penyakit-btn">Hapus</a>
                                <a href="#" class="edit-penyakit-btn">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>

            <!-- Tabel Gejala -->
            <div class="master-section">
                <h3>Tabel Data Gejala</h3>
                <a href="#" class="master-cta" id="btnAddGejala">Tambah Data Gejala</a>


                <table class="master-table" id="gejala-table">
                    <tr>
                        <th>No</th>
                        <th>Kode Gejala</th>
                        <th>Nama Gejala</th>
                        <th>Pengaturan Data</th>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM tb_gejala";
                    $result = $db->query($sql);
                    if (!$result) {
                        die("Query error: " . $db->error);
                    }
                    $no = 1;
                    while ($row = $result->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['kd_gejala']) ?></td>
                            <td><?= htmlspecialchars($row['gejala']) ?></td>
                            <td class="action-links">
                                <a href="#" class="delete-gejala-btn">Hapus</a>
                                <a href="#" class="edit-gejala-btn">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>

            <!-- Tabel Rule -->
            <div class="master-section">
                <h3>Tabel Data Aturan/Rule</h3>
                <a href="#" class="master-cta" id="btnAddRule">Tambah Data Rule</a>

                <table class="master-table" id="rule-table">
                    <tr>
                        <th>No</th>
                        <th>Kode Rule</th>
                        <th>Rule</th>
                        <th>Kode Penyakit</th>
                        <th>Pengaturan Data</th>
                    </tr>
                    <?php
                    $grouprule = [];
                    $sql = "SELECT kd_rule, GROUP_CONCAT(kd_gejala) AS kd_gejala, kd_penyakit FROM tb_rule GROUP BY kd_rule, kd_penyakit";
                    $result = $db->query($sql);
                    if (!$result) {
                        die("Query error: " . $db->error);
                    }
                    $no = 1;
                    while ($row = $result->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['kd_rule']) ?></td>
                            <td><?= htmlspecialchars($row['kd_gejala']) ?></td>
                            <td><?= htmlspecialchars($row['kd_penyakit']) ?></td>
                            <td class="action-links">
                                <a href="#" class="delete-rule-btn">Hapus</a>
                                <a href="#" class="edit-rule-btn">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>

        </section>



   

    <!-- Modal Popup for Adding Penyakit -->
    <div id="modal-bg-penyakit" class="modal-bg" style="display:none;">
        <div id="modal-content-penyakit" class="modal-content">
            <h3>Tambah Data Penyakit</h3>
            <form id="add-penyakit-form">
                <label for="add-id-penyakit">ID Penyakit</label>
                <input type="text" id="add-id-penyakit" name="id_penyakit" required />

                <label for="add-nama-penyakit">Nama Penyakit</label>
                <input type="text" id="add-nama-penyakit" name="nama_penyakit" required />

                <div class="buttons">
                    <button type="button" id="cancel-btn-add-penyakit" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Popup for Adding Gejala -->
    <div id="modal-bg-gejala" class="modal-bg" style="display:none;">
        <div id="modal-content-gejala" class="modal-content">
            <h3>Tambah Data Gejala</h3>
            <form id="add-gejala-form">
                <label for="add-kd-gejala">Kode Gejala</label>
                <input type="text" id="add-kd-gejala" name="kd_gejala" required />

                <label for="add-nama-gejala">Nama Gejala</label>
                <input type="text" id="add-nama-gejala" name="gejala" required />

                <div class="buttons">
                    <button type="button" id="cancel-btn-add-gejala" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Popup for Adding Rule -->
    <div id="modal-bg-rule" class="modal-bg" style="display:none;">
        <div id="modal-content-rule" class="modal-content">
            <h3>Tambah Data Rule</h3>
            <form id="add-rule-form">
                <label for="add-kd-rule">Kode Rule</label>
                <input type="text" id="add-kd-rule" name="kd_rule" required />

                <label for="add-kd-penyakit">Kode Penyakit</label>
                <input type="text" id="add-kd-penyakit" name="kd_penyakit" required />

                <label for="add-kd-gejala-rule">Kode Gejala (pisahkan dengan koma)</label>
                <input type="text" id="add-kd-gejala-rule" name="kd_gejala" placeholder="s01,s02,s03" required />

                <div class="buttons">
                    <button type="button" id="cancel-btn-add-rule" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Popup for Editing Rule -->
    <div id="modal-bg-edit-rule" class="modal-bg" style="display:none;">
        <div id="modal-content-edit-rule" class="modal-content">
            <h3>Edit Data Rule</h3>
            <form id="edit-rule-form">
                <label for="edit-kd-rule">Kode Rule</label>
                <input type="text" id="edit-kd-rule" name="kd_rule" readonly />

                <label for="edit-kd-penyakit">Kode Penyakit</label>
                <input type="text" id="edit-kd-penyakit" name="kd_penyakit" required />

                <label for="edit-kd-gejala">Kode Gejala (pisahkan dengan koma)</label>
                <input type="text" id="edit-kd-gejala" name="kd_gejala" placeholder="G001,G002,G003" required />

                <div class="buttons">
                    <button type="button" id="cancel-btn-edit-rule" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-submit">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Popup for Editing Gejala -->
    <div id="modal-bg-edit-gejala" class="modal-bg" style="display:none;">
        <div id="modal-content-edit-gejala" class="modal-content">
            <h3>Edit Data Gejala</h3>
            <form id="edit-gejala-form">
                <label for="edit-kd-gejala">Kode Gejala</label>
                <input type="text" id="edit-kd-gejala" name="kd_gejala" readonly />

                <label for="edit-nama-gejala">Nama Gejala</label>
                <input type="text" id="edit-nama-gejala" name="gejala" required />

                <div class="buttons">
                    <button type="button" id="cancel-btn-edit-gejala" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-submit">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Popup for Editing Penyakit -->
    <div id="modal-bg-edit-penyakit" class="modal-bg" style="display:none;">
        <div id="modal-content-edit-penyakit" class="modal-content">
            <h3>Edit Data Penyakit</h3>
            <form id="edit-penyakit-form">
                <label for="edit-id-penyakit">ID Penyakit</label>
                <input type="text" id="edit-id-penyakit" name="id_penyakit" readonly />

                <label for="edit-nama-penyakit">Nama Penyakit</label>
                <input type="text" id="edit-nama-penyakit" name="nama_penyakit" required />

                <div class="buttons">
                    <button type="button" id="cancel-btn-edit-penyakit" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-submit">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Popup for Deleting Penyakit -->
    <div id="modal-bg-delete-penyakit" class="modal-bg" style="display:none;">
        <div id="modal-content-delete-penyakit" class="modal-content">
            <h3>Hapus Data Penyakit</h3>
            <p>Apakah Anda yakin ingin menghapus data penyakit ini?</p>
            <form id="delete-penyakit-form">
                <input type="hidden" id="delete-id-penyakit" name="id_penyakit" />
                <div class="buttons">
                    <button type="button" id="cancel-btn-delete-penyakit" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-submit">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Popup for Deleting Gejala -->
    <div id="modal-bg-delete-gejala" class="modal-bg" style="display:none;">
        <div id="modal-content-delete-gejala" class="modal-content">
            <h3>Hapus Data Gejala</h3>
            <p>Apakah Anda yakin ingin menghapus data gejala ini?</p>
            <form id="delete-gejala-form">
                <input type="hidden" id="delete-kd-gejala" name="kd_gejala" />
                <div class="buttons">
                    <button type="button" id="cancel-btn-delete-gejala" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-submit">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Popup for Deleting Rule -->
    <div id="modal-bg-delete-rule" class="modal-bg" style="display:none;">
        <div id="modal-content-delete-rule" class="modal-content">
            <h3>Hapus Data Rule</h3>
            <p>Apakah Anda yakin ingin menghapus data rule ini?</p>
            <form id="delete-rule-form">
                <input type="hidden" id="delete-kd-rule" name="kd_rule" />
                <div class="buttons">
                    <button type="button" id="cancel-btn-delete-rule" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-submit">Hapus</button>
                </div>
            </form>
        </div>
    </div>

  
    <script src="master.js"></script>

    <?php include "layout/footer.php"; ?>    
</body>


</html>
