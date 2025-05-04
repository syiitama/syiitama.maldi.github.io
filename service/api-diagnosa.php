<?php
header('Content-Type: application/json');
include "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Ambil data penyakit
    $penyakit_data = [];
    $result = $db->query("SELECT id_penyakit, nama_penyakit FROM tb_penyakit");
    while ($row = $result->fetch_assoc()) {
        $penyakit_data[$row['id_penyakit']] = [
            'nama' => $row['nama_penyakit']
            // 'solusi' => $row['solusi'] // jika perlu
        ];
    }

    // Ambil data gejala
    $gejala_data = [];
    $result = $db->query("SELECT kd_gejala, gejala FROM tb_gejala");
    while ($row = $result->fetch_assoc()) {
        $gejala_data[$row['kd_gejala']] = $row['gejala'];
    }

    // Ambil data rule
    $rules = [];
    $result = $db->query("SELECT kd_rule, kd_gejala, kd_penyakit FROM tb_rule");
    while ($row = $result->fetch_assoc()) {
        $rules[] = [
            'kd_rule' => $row['kd_rule'],
            'kd_gejala' => $row['kd_gejala'],
            'kd_penyakit' => $row['kd_penyakit']
        ];
    }

    echo json_encode([
        'penyakit' => $penyakit_data,
        'gejala' => $gejala_data,
        'rules' => $rules
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_gejala = $_POST['gejala'] ?? [];
    if (!is_array($selected_gejala) || count($selected_gejala) === 0) {
        echo json_encode(['error' => 'No symptoms selected']);
        exit;
    }

    // Cast semua gejala ke string agar konsisten
    $selected_gejala = array_map('strval', $selected_gejala);

    // Ambil data penyakit
    $penyakit_data = [];
    $result = $db->query("SELECT id_penyakit, nama_penyakit, jenis, bobot, solusi FROM tb_penyakit");
    while ($row = $result->fetch_assoc()) {
        $penyakit_data[$row['id_penyakit']] = [
            'nama' => $row['nama_penyakit'],
            'jenis' => $row['jenis'],
            'bobot' => floatval($row['bobot']),
            'solusi' => $row['solusi']
        ];
    }

    // Ambil data rule
    $rules = [];
    $result = $db->query("SELECT kd_rule, kd_gejala, kd_penyakit FROM tb_rule");
    while ($row = $result->fetch_assoc()) {
        $rules[] = [
            'kd_rule' => $row['kd_rule'],
            'kd_gejala' => $row['kd_gejala'],
            'kd_penyakit' => $row['kd_penyakit']
        ];
    }

    // Inisialisasi total bobot per jenis penyakit
    $total_bobot_per_jenis = [
        'Tertiana' => 0,
        'Tropika' => 0,
        'Quartana' => 0,
        'Ovale' => 0
    ];

    // Hitung bobot total per jenis berdasarkan gejala yang dipilih
    foreach ($selected_gejala as $kd_gejala) {
        foreach ($rules as $rule) {
            if ($rule['kd_gejala'] === $kd_gejala) {
                $id_penyakit = $rule['kd_penyakit'];
                if (isset($penyakit_data[$id_penyakit])) {
                    $jenis = $penyakit_data[$id_penyakit]['jenis'];
                    $bobot = $penyakit_data[$id_penyakit]['bobot'];
                    if (isset($total_bobot_per_jenis[$jenis])) {
                        $total_bobot_per_jenis[$jenis] += $bobot;
                    }
                }
            }
        }
    }

    //group rules

    $sql = "SELECT kd_penyakit, kd_gejala FROM tb_rule ORDER BY kd_penyakit, kd_gejala DESC";
    $result = $db->query($sql);

    $data = [];

    while ($row = $result->fetch_assoc()) {
        $penyakit = strtolower($row['kd_penyakit']); // biar aman lowercase
        $gejala = $row['kd_gejala'];

        if (!isset($data[$penyakit])) {
            $data[$penyakit] = [];
        }

        $data[$penyakit][] = $gejala;
    }

    header('Content-Type: application/json');
    echo json_encode($data);



    // Hitung total bobot keseluruhan untuk persentase
    $total_bobot_all = array_sum($total_bobot_per_jenis);
    if ($total_bobot_all == 0) {
        $total_bobot_all = 1; // agar tidak divisi nol
    }

    // Hitung persentase per jenis
    $persentase = [];
    foreach ($total_bobot_per_jenis as $jenis => $bobot) {
        $persentase[$jenis] = round(($bobot / $total_bobot_all) * 100, 2);
    }

    // Ambil solusi per jenis (ambil solusi penyakit pertama yang sesuai jenis)
    $solusi = [];
    foreach ($total_bobot_per_jenis as $jenis => $bobot) {
        $solusi[$jenis] = '';
        foreach ($penyakit_data as $penyakit) {
            if ($penyakit['jenis'] === $jenis) {
                $solusi[$jenis] = $penyakit['solusi'];
                break;
            }
        }
    }

    // Urutkan persentase descending untuk diagnosa utama
    arsort($persentase);
    $top_jenis = key($persentase);
    $hasil_diagnosa = "Diagnosa utama: Malaria " . $top_jenis;

    echo json_encode([
        'hasil_diagnosa' => $hasil_diagnosa,
        'persentase_tertiana' => $persentase['Tertiana'] ?? 0,
        'persentase_tropika' => $persentase['Tropika'] ?? 0,
        'persentase_quartana' => $persentase['Quartana'] ?? 0,
        'persentase_ovale' => $persentase['Ovale'] ?? 0,
        'solusi_tertiana' => $solusi['Tertiana'] ?? '',
        'solusi_tropika' => $solusi['Tropika'] ?? '',
        'solusi_quartana' => $solusi['Quartana'] ?? '',
        'solusi_ovale' => $solusi['Ovale'] ?? ''
    ]);
    exit;
}

echo json_encode(['error' => 'Invalid request method']);
exit;
