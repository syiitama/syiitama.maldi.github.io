let penyakitData = {};
let gejalaData = {};
let rulesData = [];

function fetchDiagnosisData() {
    return fetch('service/api-diagnosa.php')
        .then(response => response.json())
        .then(data => {
            penyakitData = data.penyakit || {};
            gejalaData = data.gejala || {};
            rulesData = data.rules || [];

        })
        .catch(error => {
            alert('Gagal mengambil data diagnosa.');
        });
}


function calculateDiagnosis(selectedSymptoms) {
    // Initialize total bobot per jenis penyakit
    const totalBobotPerJenis = {
        'Tertiana': 0,
        'Tropika': 0,
        'Quartana': 0,
        'Ovale': 0
    };

    // Sum bobot for selected gejala per jenis penyakit based on tb_rule
    selectedSymptoms.forEach(kd_gejala => {
        rulesData.forEach(rule => {
            if (rule.kd_gejala === kd_gejala) {
                const penyakit = penyakitData[rule.kd_penyakit];
                if (penyakit) {
                    const jenis = penyakit.jenis;
                    const bobot = parseFloat(penyakit.bobot);
                    if (totalBobotPerJenis.hasOwnProperty(jenis)) {
                        totalBobotPerJenis[jenis] += bobot;
                    }
                }
            }
        });
    });

    // Calculate total bobot all jenis for percentage calculation
    let totalBobotAll = Object.values(totalBobotPerJenis).reduce((a, b) => a + b, 0);
    if (totalBobotAll === 0) totalBobotAll = 1; // avoid division by zero

    // Calculate percentages
    const persentase = {};
    for (const jenis in totalBobotPerJenis) {
        persentase[jenis] = ((totalBobotPerJenis[jenis] / totalBobotAll) * 100).toFixed(2);
    }

    // Determine diagnosis utama
    let maxJenis = 'Tertiana';
    let maxPersentase = 0;
    for (const jenis in persentase) {
        if (parseFloat(persentase[jenis]) > maxPersentase) {
            maxPersentase = parseFloat(persentase[jenis]);
            maxJenis = jenis;
        }
    }

    // Prepare solusi per jenis
    const solusi = {};
    for (const jenis in totalBobotPerJenis) {
        solusi[jenis] = '';
        for (const id in penyakitData) {
            if (penyakitData[id].jenis === jenis) {
                solusi[jenis] = penyakitData[id].solusi;
                break;
            }
        }
    }

    return {
        hasil_diagnosa: `Diagnosa utama: Malaria ${maxJenis}`,
        persentase,
        solusi
    };
}



document.addEventListener('DOMContentLoaded', () => {
    fetchDiagnosisData().then(() => {
        document.getElementById('diagnosa-malaria').addEventListener('submit', (e) => {
            e.preventDefault();

            const nama = document.getElementById('nama').value;
            const umur = document.getElementById('umur').value;
            const alamat = document.getElementById('alamat').value;

            // Display patient data in the results table
            document.getElementById('nama-pasien').innerHTML = nama;
            document.getElementById('umur-pasien').innerHTML = umur + " tahun";
            document.getElementById('alamat-pasien').innerHTML = alamat;

            // Collect selected symptoms
            const selectedSymptoms = [];
            document.querySelectorAll('input[name="gejala[]"]:checked').forEach((checkbox) => {
                selectedSymptoms.push(checkbox.value);
            });

            if (selectedSymptoms.length === 0) {
                alert('Silakan pilih minimal satu gejala.');
                return;
            }

            // Calculate diagnosis client-side
            const diagnosisResult = calculateDiagnosis(selectedSymptoms);

            // Update diagnosis result spans
            document.getElementById('hasil-diagnosa').innerText = diagnosisResult.hasil_diagnosa || '';
            document.getElementById('persentase-tertiana').innerText = diagnosisResult.persentase['Tertiana'] + '%';
            document.getElementById('persentase-tropika').innerText = diagnosisResult.persentase['Tropika'] + '%';
            document.getElementById('persentase-quartana').innerText = diagnosisResult.persentase['Quartana'] + '%';
            document.getElementById('persentase-ovale').innerText = diagnosisResult.persentase['Ovale'] + '%';

            document.getElementById('solusi-malaria-tertiana').innerText = diagnosisResult.solusi['Tertiana'] || '';
            document.getElementById('solusi-malaria-tropika').innerText = diagnosisResult.solusi['Tropika'] || '';
            document.getElementById('solusi-malaria-quartana').innerText = diagnosisResult.solusi['Quartana'] || '';
            document.getElementById('solusi-malaria-ovale').innerText = diagnosisResult.solusi['Ovale'] || '';
        });
    });
});



$(document).ready(function () {
    $('#diagnosa-malaria').submit(function (e) {
        e.preventDefault();

        // Ambil data pasien
        const nama = $('#nama').val();
        const umur = $('#umur').val();
        const alamat = $('#alamat').val();

        // Ambil gejala yang dicentang
        let gejala = [];
        $('input[name="gejala[]"]:checked').each(function () {
            gejala.push($(this).val());
        });

        if (gejala.length === 0) {
            alert('Silakan pilih minimal satu gejala.');
            return;
        }

        $.ajax({
            url: 'diagnosa.php',
            method: 'POST',
            dataType: 'json',
            data: {
                nama: nama,
                umur: umur,
                alamat: alamat,
                gejala: gejala
            },
            success: function (response) {
                if (response.error) {
                    alert(response.error);
                    return;
                }

                // Tampilkan data pasien
                // $('#nama-pasien').text(nama);
                // $('#umur-pasien').text(umur);
                // $('#alamat-pasien').text(alamat);

                // Tampilkan hasil diagnosa
                // Misal response.hasil = [{penyakit: 'Malaria Tertiana', skor: 1.8, solusi: '...'}, ...]
                let hasilHtml = '';
                response.hasil.forEach(function (item, index) {
                    hasilHtml += `<tr>
                        <td>${index + 1}</td>
                        <td>${item.penyakit}</td>
                        <td>${(item.skor * 100).toFixed(2)}%</td>
                        <td>${item.solusi}</td>
                    </tr>`;
                });
                $('#hasil-diagnosa').html(hasilHtml);
            },
            error: function () {
                alert('Terjadi kesalahan saat memproses diagnosa.');
            }
        });
    });
});
