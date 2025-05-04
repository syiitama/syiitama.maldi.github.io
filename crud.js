document.addEventListener('DOMContentLoaded', function () {
    // Container to load modal content dynamically
    const modalContainer = document.createElement('div');
    document.body.appendChild(modalContainer);

    // Load modal content from modal-form-add.html once
    async function loadModalContent() {
        if (modalContainer.innerHTML.trim() !== '') return; // Already loaded
        try {
            const response1 = await fetch('modal/modal-form-add.html');
            const response2 = await fetch('modal/modal-form-edit.html');
            const response3 = await fetch('modal/modal-form-del.html');

            // Check if any of the responses failed
            if (!response1.ok || !response2.ok || !response3.ok) {
                throw new Error('Failed to load modal content');
            }

            // Combine modal HTML content
            const html = await response1.text() + await response2.text() + await response3.text();
            modalContainer.innerHTML = html;

            // Add cancel button event listeners for modals
            const cancelButtons = modalContainer.querySelectorAll('.btn-cancel');
            cancelButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const modalBg = btn.closest('.modal-bg');
                    if (modalBg) {
                        modalBg.style.display = 'none';
                    }
                });
            });

            // Add form submission handler for add-penyakit-form
            const addPenyakitForm = modalContainer.querySelector('#add-penyakit-form');
            const addGejalaForm = modalContainer.querySelector('#add-gejala-form');
            const addRuleForm = modalContainer.querySelector('#add-rule-form');

            if (addPenyakitForm) {
                addPenyakitForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const kodePenyakit = addPenyakitForm.querySelector('#add-kode-penyakit').value.trim();
                    const namaPenyakit = addPenyakitForm.querySelector('#add-nama-penyakit').value.trim();

                    if (!kodePenyakit || !namaPenyakit) {
                        alert('Kode Penyakit dan Nama Penyakit harus diisi.');
                        return;
                    }

                    try {
                        const formData = new FormData();
                        formData.append('kode_penyakit', kodePenyakit);
                        formData.append('nama_penyakit', namaPenyakit);

                        const response = await fetch('service/add-penyakit.php', {
                            method: 'POST',
                            body: formData
                        });

                        if (!response.ok) throw new Error('Gagal menyimpan data penyakit.');

                        const result = await response.json();

                        if (result.success) {
                            alert('Data penyakit berhasil disimpan.');
                            // Hide modal
                            const modalBg = modalContainer.querySelector('#modal-bg-penyakit');
                            if (modalBg) {
                                modalBg.style.display = 'none';
                            }
                            addPenyakitForm.reset();
                        } else {
                            alert('Gagal menyimpan data penyakit: ' + (result.message || 'Unknown error'));
                        }
                    } catch (error) {
                        console.error(error);
                        alert('Terjadi kesalahan saat menyimpan data penyakit.');
                    }
                });
            }

            if (addGejalaForm) {
                addGejalaForm.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    const kodeGejala = addGejalaForm.querySelector('#add-kode-gejala').value.trim();
                    const namaGejala = addGejalaForm.querySelector('#add-nama-gejala').value.trim();

                    if (!kodeGejala || !namaGejala) {
                        alert('Kode Gejala dan Nama Gejala harus diisi.');
                        return;
                    }

                    try {
                        const formData = new FormData();
                        formData.append('kode_gejala', kodeGejala);
                        formData.append('gejala', namaGejala);

                        const response = await fetch('service/add-gejala.php', {
                            method: 'POST',
                            body: formData
                        });

                        if (!response.ok) throw new Error('Gagal menyimpan data gejala.');

                        const result = await response.json();

                        if (result.success) {
                            alert('Data gejala berhasil disimpan.');
                            // Hide modal
                            const modalBg = modalContainer.querySelector('#modal-bg-gejala');
                            if (modalBg) {
                                modalBg.style.display = 'none';
                            }
                            addGejalaForm.reset();
                        } else {
                            alert('Gagal menyimpan data gejala: ' + (result.message || 'Unknown error'));
                        }
                    } catch (error) {
                        console.error(error);
                        alert('Terjadi kesalahan saat menyimpan data gejala.');
                    }
                });
            }

            if (addRuleForm) {
                // Similar event listener for rule form (if needed)
            }

        } catch (error) {
            console.error(error);
            alert('Error loading modal content.');
        }
    }

    // Show modal by id
    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
        }
    }

    // Button to open Add Penyakit modal
    const btnAddPenyakit = document.getElementById('btnAddPenyakit');
    if (btnAddPenyakit) {
        btnAddPenyakit.addEventListener('click', async (e) => {
            e.preventDefault();
            await loadModalContent();
            showModal('modal-bg-penyakit');
        });
    }

    // Button to open Add Gejala modal
    const btnAddGejala = document.getElementById('btnAddGejala');
    if (btnAddGejala) {
        btnAddGejala.addEventListener('click', async (e) => {
            e.preventDefault();
            await loadModalContent();
            showModal('modal-bg-gejala');
        });
    }

    // Button to open Add Rule modal (if needed)
    const btnAddRule = document.getElementById('btnAddRule');
    if (btnAddRule) {
        btnAddRule.addEventListener('click', async (e) => {
            e.preventDefault();
            await loadModalContent();
            showModal('modal-bg-rule');
        });
    }
});
