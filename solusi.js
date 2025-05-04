function tampilkanPengobatanPencegahanMalaria() {
    const persentase = {
        tertiana: parseFloat(document.getElementById('persentase-tertiana')?.textContent.replace('%', '')) || 0,
        tropika: parseFloat(document.getElementById('persentase-tropika')?.textContent.replace('%', '')) || 0,
        quartana: parseFloat(document.getElementById('persentase-quartana')?.textContent.replace('%', '')) || 0,
        ovale: parseFloat(document.getElementById('persentase-ovale')?.textContent.replace('%', '')) || 0,
    };

    const pengobatanContent = `
        <ul>
            <li>Periksa Ke Dokter</li>
            <li>Dihydroartemisinin-Piperaquine (DHP)</li>
            <li>Primaquine</li>
        </ul>
    `;

    const malariaTypes = ['tertiana', 'tropika', 'quartana', 'ovale'];

    malariaTypes.forEach(function(type) {
        const value = persentase[type];
        const elem = document.getElementById('solusi-malaria-' + type);

        if (elem) {
            if (value >= 5) {
                elem.innerHTML = pengobatanContent;
            } else {
                elem.innerHTML = '';
            }
        }
    });
}

document.getElementById('tombol-diagnosa')?.addEventListener('click', function() {
    tampilkanPengobatanPencegahanMalaria();
});
