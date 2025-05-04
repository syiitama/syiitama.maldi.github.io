let k_rule = {};
let k_gejala = {};
let k_penyakit = [];

function kodeDb() {
    return fetch('service/api-diagnosa.php')
        .then(response => response.json())
        .then(data => {
            console.log(data); 
            const grupData = {};

            data.forEach(item=> {
                const penyakit = item.penyakit;
                if (!grupData [penyakit]){
                    grupData [penyakit]= [];
                }
                grupData[penyakit].push(item.gejala);
            });
                       
        })
        .catch(error => {
            // alert('Gagal mengambil data diagnosa.');
        });
}
kodeDb();

///////////
const bobotTertiana = ['s02', 's21', 's19', 's18', 's15', 's11', 's05', 's04']
const bobotTropika = ['s17', 's18', 's19', 's20', 's21', 's23', 's27', 's15', 's11', 's01', 's03', 's06', 's07', 's08', 's09', 's10']
const bobotQuartana = ['s27', 's25', 's24', 's22', 's21', 's16', 's15', 's14', 's12', 's11', 's10', 's09', 's04']
const bobotOvale = ['s19', 's20', 's21', 's24', 's26', 's16', 's13', 's11', 's09', 's05', 's02', 's01', 's27']

let arrayNames = ["Tertiana", "Tropika", "Quartana", "Ovale"];


// Fungsi untuk memeriksa setiap elemen dalam array1 apakah ada di array2, array3, dan array4

// Array yang ingin diperiksa
let allArrays = [bobotTertiana, bobotTropika, bobotQuartana, bobotOvale];
// Cek setiap elemen array apakah ada di objek
let bobotGejala = 0;

let k_Tertana
let k_Tropika
let k_quartana
let k_ovale

let tt = []

// Variabel untuk menyimpan bobot persentase untuk tiap elemen
bobotNilai = {
    'tertiana': 0, // bobot default untuk tertiana
    'tropika': 0, // bobot default untuk tropika
    'quartana': 0, // bobot default untuk quartana
    'ovale': 0 // bobot default untuk ovale
}

function checkElementCounts(arr1, arrays, names) {

    // Variabel untuk menyimpan bobot persentase untuk tiap elemen
    const bobotAwal = {
        'tertiana': 0, // bobot default untuk tertiana
        'tropika': 0, // bobot default untuk tropika
        'quartana': 0, // bobot default untuk quartana
        'ovale': 0 // bobot default untuk ovale
    }


    for (let key in bobotAwal) {
        if (bobotNilai.hasOwnProperty(key)) {
            bobotNilai[key] += bobotAwal[key]

        }
    }
    // console.log(bobotNilai);



    arr1.forEach((element, index) => {
        let totalCount = 0;  // Variabel untuk jumlah total kemunculan per elemen array1
        let counts = {};  // Objek untuk menyimpan jumlah kemunculan elemen di setiap array

        console.log(`Memeriksa elemen ${element} dari array1 (indeks ${index}):`);

        // Cek setiap array lainnya
        arrays.forEach((arr, idx) => {
            let count = arr.filter(item => item === element).length;
            counts[names[idx]] = count;
            totalCount += count;  // Jumlahkan kemunculannya ke totalCount

        });


        // Output jumlah kemunculan di setiap array
        for (let arrayName in counts) {
            console.log(`  Elemen ${element} muncul ${counts[arrayName]} kali di ${arrayName}.`);
            // k_Tertana = `${ counts[arrayName]}`
            // console.log(counts[arrays]);
            // tt.push(counts[arrayName]);


            if (arrayName === 'Tertiana') {
                bobotAwal.tertiana += counts[arrayName];  // Menambah nilai ke bobotTertiana
            } else if (arrayName === 'Tropika') {
                bobotAwal.tropika += counts[arrayName];  // Menambah nilai ke bobotTropika
            } else if (arrayName === 'Quartana') {
                bobotAwal.quartana += counts[arrayName];  // Menambah nilai ke bobotQuartana
            } else if (arrayName === 'Ovale') {
                bobotAwal.ovale += counts[arrayName];  // Menambah nilai ke bobotOvale
            }

        }
        // menentukan bobot berdasarkan total count/jumlah kemunculan
        if (totalCount > 3) {
            bobotGejala += 0.5
        }
        else if (totalCount > 2) {
            bobotGejala += 0.6
        } else if (totalCount > 1) {
            bobotGejala += 0.7
        } else {
            bobotGejala += 0.8
        }
        console.log("Jumlah bobot " + bobotGejala);


        // Output jumlah total kemunculan elemen di semua array
        console.log(`  Total kemunculan elemen ${element} di semua array: ${totalCount}`);

        let botHasilTertiana = (bobotAwal.tertiana / bobotTertiana.length) * 100;
        // let botHasilTertiana  = (bobotGejala / 4.9) * 100; //tertiana

        let botHasilTropika = (bobotAwal.tropika / bobotTropika.length) * 100; //tropika
        let botHasilQuartana = (bobotAwal.quartana / bobotQuartana.length) * 100; //quartana
        let botHasilOvale = (bobotAwal.ovale / bobotOvale.length) * 100; //ovale

        console.log("hasil tertiana " + botHasilTertiana);
        console.log("hasil ovale    " + botHasilOvale);
        console.log("hasil Quartana " + botHasilQuartana);
        console.log("hasil Tropika  " + botHasilTropika);


        /// display tertiana
        if (bobotAwal.tertiana == 0) {
            document.getElementById('persentase-tertiana').innerHTML = 0 + "%";
            console.log(`Bobot Tertiana: ${bobotNilai.tertiana}%`);
        } else {
            document.getElementById('persentase-tertiana').innerHTML = botHasilTertiana.toFixed(2) + "%";
            console.log(`Bobot Tertiana: ${botHasilTertiana}%`);
        }

        /// display Tropika
        if (bobotAwal.tropika == 0) {
            document.getElementById('persentase-tropika').innerHTML = 0 + "%";
            console.log(`Bobot Tropika: ${bobotNilai.tropika.toFixed(2)}%`);
        } else {
            document.getElementById('persentase-tropika').innerHTML = botHasilTropika.toFixed(2) + "%";
            console.log(`Bobot Tropika: ${botHasilTropika.toFixed(2)}%`);
        }
        /// display Quartana
        if (bobotAwal.quartana == 0) {
            document.getElementById('persentase-quartana').innerHTML = 0 + "%";
            console.log(`Bobot Quartana: ${bobotNilai.quartana.toFixed(2)}%`);
        } else {
            document.getElementById('persentase-quartana').innerHTML = botHasilQuartana.toFixed(2) + "%";
            console.log(`Bobot Quartana: ${botHasilQuartana.toFixed(2)}%`);
        }
        /// display Ovale
        if (bobotAwal.ovale == 0) {
            document.getElementById('persentase-ovale').innerHTML = 0 + "%";
            console.log(`Bobot Ovale: ${bobotNilai.ovale.toFixed(2)}%`);
        } else {
            document.getElementById('persentase-ovale').innerHTML = botHasilOvale.toFixed(2) + "%";
            console.log(`Bobot Ovale: ${botHasilOvale.toFixed(2)}%`);
        }

        // Tampilkan total bobot gejala yang dihitung

        console.log(`Total Bobot Gejala yang dipilih: ${bobotGejala.toFixed(2)}`);

    });

}

const checkboxes = document.querySelectorAll('.cekcontainer');

function AmbilKodeGejala() {
    let listGejala = []
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('click', function () {
            const value = this.value;
            const index = listGejala.indexOf(value);
            if (index === -1) {
                listGejala.push(value)
            } else {
                listGejala.splice(index, 1);
            }
            // console.log(listGejala);
        })
    })
    return listGejala
}
listGejala = AmbilKodeGejala();
// console.log(listGejala);


// Button Diagnosa
document.getElementById('diagnosa-malaria').addEventListener('submit', (e) => {
    e.preventDefault();
    // Bersih Bersih
    bobotGejala = 0
    // totalCount = 0
    document.getElementById('persentase-tertiana').innerHTML = "0%";
    document.getElementById('persentase-tropika').innerHTML = "0%";
    document.getElementById('persentase-quartana').innerHTML = "0%";
    document.getElementById('persentase-ovale').innerHTML = "0%";

    //

    checkElementCounts(listGejala, allArrays, arrayNames);
    console.log(bobotNilai);

    const nama = document.getElementById('nama').value;
    const umur = document.getElementById('umur').value;
    const alamat = document.getElementById('alamat').value;
    ///
    if (listGejala.length !== 0) {
        document.getElementById('daftar-gejala').innerHTML = listGejala;
        document.getElementById('nama-pasien').innerHTML = nama;
        document.getElementById('umur-pasien').innerHTML = umur + " tahun";
        document.getElementById('alamat-pasien').innerHTML = alamat;
    } else {
        alert('Silakan pilih minimal satu gejala.');
    }
    // 
})