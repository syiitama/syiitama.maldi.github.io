document.addEventListener('DOMContentLoaded', function () {
    // Add Penyakit modal elements
    const modalBgAddPenyakit = document.getElementById('modal-bg-penyakit');
    const addFormPenyakit = document.getElementById('add-penyakit-form');
    const cancelBtnAddPenyakit = document.getElementById('cancel-btn-add-penyakit');
    const btnAddPenyakit = document.getElementById('btnAddPenyakit');

    // Add Gejala modal elements
    const modalBgAddGejala = document.getElementById('modal-bg-gejala');
    const addFormGejala = document.getElementById('add-gejala-form');
    const cancelBtnAddGejala = document.getElementById('cancel-btn-add-gejala');
    const btnAddGejala = document.getElementById('btnAddGejala');

    // Add Rule modal elements
    const modalBgAddRule = document.getElementById('modal-bg-rule');
    const addFormRule = document.getElementById('add-rule-form');
    const cancelBtnAddRule = document.getElementById('cancel-btn-add-rule');
    const btnAddRule = document.getElementById('btnAddRule');

    // Edit Penyakit modal elements
    const modalBgEditPenyakit = document.getElementById('modal-bg-edit-penyakit');
    const editFormPenyakit = document.getElementById('edit-penyakit-form');
    const cancelBtnEditPenyakit = document.getElementById('cancel-btn-edit-penyakit');

    // Edit Gejala modal elements
    const modalBgEditGejala = document.getElementById('modal-bg-edit-gejala');
    const editFormGejala = document.getElementById('edit-gejala-form');
    const cancelBtnEditGejala = document.getElementById('cancel-btn-edit-gejala');

    // Edit Rule modal elements
    const modalBgEditRule = document.getElementById('modal-bg-edit-rule');
    const editFormRule = document.getElementById('edit-rule-form');
    const cancelBtnEditRule = document.getElementById('cancel-btn-edit-rule');

    // Delete Penyakit modal elements
    const modalBgDeletePenyakit = document.getElementById('modal-bg-delete-penyakit');
    const deleteFormPenyakit = document.getElementById('delete-penyakit-form');
    const cancelBtnDeletePenyakit = document.getElementById('cancel-btn-delete-penyakit');
    const deleteIdPenyakitInput = document.getElementById('delete-id-penyakit');

    // Delete Gejala modal elements
    const modalBgDeleteGejala = document.getElementById('modal-bg-delete-gejala');
    const deleteFormGejala = document.getElementById('delete-gejala-form');
    const cancelBtnDeleteGejala = document.getElementById('cancel-btn-delete-gejala');
    const deleteKdGejalaInput = document.getElementById('delete-kd-gejala');

    // Function to show modal
    function showModal(modal) {
        modal.style.display = 'block';
    }

    // Function to hide modal
    function hideModal(modal) {
        modal.style.display = 'none';
    }


    // Setup delete penyakit modal and form handlers
    function setupDeletePenyakitHandler() {
        // Handle delete penyakit button click
        document.querySelectorAll('.delete-penyakit-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const row = e.target.closest('tr');
                const idPenyakit = row.querySelector('td:nth-child(2)').textContent.trim();

                deleteIdPenyakitInput.value = idPenyakit;
                showModal(modalBgDeletePenyakit);
            });
        });

        // Handle cancel button click for delete penyakit
        cancelBtnDeletePenyakit.addEventListener('click', function () {
            hideModal(modalBgDeletePenyakit);
        });

        // Handle form submission for delete penyakit
        deleteFormPenyakit.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(deleteFormPenyakit);

            fetch('service/del-penyakit.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                        hideModal(modalBgDeletePenyakit);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
        });
    }

    // Setup delete gejala modal and form handlers
    function setupDeleteGejalaHandler() {
        // Handle delete gejala button click
        document.querySelectorAll('.delete-gejala-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const row = e.target.closest('tr');
                const kdGejala = row.querySelector('td:nth-child(2)').textContent.trim();

                deleteKdGejalaInput.value = kdGejala;
                showModal(modalBgDeleteGejala);
            });
        });

        // Handle cancel button click for delete gejala
        cancelBtnDeleteGejala.addEventListener('click', function () {
            hideModal(modalBgDeleteGejala);
        });

        // Handle form submission for delete gejala
        deleteFormGejala.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(deleteFormGejala);

            fetch('service/del-gejala.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                        hideModal(modalBgDeleteGejala);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
        });
    }

    // Call the delete penyakit setup function
    setupDeletePenyakitHandler();

    // Call the delete gejala setup function
    setupDeleteGejalaHandler();

    // Delete Rule modal elements
    const modalBgDeleteRule = document.getElementById('modal-bg-delete-rule');
    const deleteFormRule = document.getElementById('delete-rule-form');
    const cancelBtnDeleteRule = document.getElementById('cancel-btn-delete-rule');
    const deleteKdRuleInput = document.getElementById('delete-kd-rule');

    // Setup delete rule modal and form handlers
    function setupDeleteRuleHandler() {
        // Handle delete rule button click
        document.querySelectorAll('.delete-rule-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const row = e.target.closest('tr');
                const kdRule = row.querySelector('td:nth-child(2)').textContent.trim();

                deleteKdRuleInput.value = kdRule;
                showModal(modalBgDeleteRule);
            });
        });

        // Handle cancel button click for delete rule
        cancelBtnDeleteRule.addEventListener('click', function () {
            hideModal(modalBgDeleteRule);
        });

        // Handle form submission for delete rule
        deleteFormRule.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(deleteFormRule);

            fetch('service/del-rule.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                        hideModal(modalBgDeleteRule);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
        });
    }

    // Call the delete rule setup function
    setupDeleteRuleHandler();


    // Handle add penyakit button click
    btnAddPenyakit.addEventListener('click', function (e) {
        e.preventDefault();
        showModal(modalBgAddPenyakit);
    });

    // Handle cancel button click for add penyakit
    cancelBtnAddPenyakit.addEventListener('click', function () {
        hideModal(modalBgAddPenyakit);
    });

    // Handle form submission for add penyakit
    addFormPenyakit.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(addFormPenyakit);

        fetch('service/add-penyakit.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                    hideModal(modalBgAddPenyakit);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
    });

    // Handle add gejala button click
    btnAddGejala.addEventListener('click', function (e) {
        e.preventDefault();
        showModal(modalBgAddGejala);
    });

    // Handle cancel button click for add gejala
    cancelBtnAddGejala.addEventListener('click', function () {
        hideModal(modalBgAddGejala);
    });

    // Handle form submission for add gejala
    addFormGejala.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(addFormGejala);

        fetch('service/add-gejala.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                if (data === 'Sukses') {
                    alert('Data gejala berhasil disimpan.');
                    location.reload();
                    hideModal(modalBgAddGejala);
                } else {
                    alert('Error: ' + data);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
    });

    // Handle add rule button click
    btnAddRule.addEventListener('click', function (e) {
        e.preventDefault();
        showModal(modalBgAddRule);
    });

    // Handle cancel button click for add rule
    cancelBtnAddRule.addEventListener('click', function () {
        hideModal(modalBgAddRule);
    });

    // Handle form submission for add rule
    addFormRule.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(addFormRule);

        fetch('service/add-rule.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                if (data === 'Sukses') {
                    alert('Data rule berhasil disimpan.');
                    location.reload();
                    hideModal(modalBgAddRule);
                } else {
                    alert('Error: ' + data);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
    });

    // Handle edit penyakit button click
    document.querySelectorAll('.edit-penyakit-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const row = e.target.closest('tr');
            const idPenyakit = row.querySelector('td:nth-child(2)').textContent.trim();
            const namaPenyakit = row.querySelector('td:nth-child(3)').textContent.trim();

            document.getElementById('edit-id-penyakit').value = idPenyakit;
            document.getElementById('edit-nama-penyakit').value = namaPenyakit;

            showModal(modalBgEditPenyakit);
        });
    });

    // Handle cancel button click for edit penyakit
    cancelBtnEditPenyakit.addEventListener('click', function () {
        hideModal(modalBgEditPenyakit);
    });

    // Handle form submission for edit penyakit
    editFormPenyakit.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(editFormPenyakit);

        fetch('service/edit-penyakit.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                    hideModal(modalBgEditPenyakit);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
    });

    // Handle edit gejala button click
    document.querySelectorAll('.edit-gejala-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const row = e.target.closest('tr');
            const kdGejala = row.querySelector('td:nth-child(2)').textContent.trim();
            const namaGejala = row.querySelector('td:nth-child(3)').textContent.trim();

            document.getElementById('edit-kd-gejala').value = kdGejala;
            document.getElementById('edit-nama-gejala').value = namaGejala;

            showModal(modalBgEditGejala);
        });
    });

    // Handle cancel button click for edit gejala
    cancelBtnEditGejala.addEventListener('click', function () {
        hideModal(modalBgEditGejala);
    });

    // Handle form submission for edit gejala
    editFormGejala.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(editFormGejala);

        fetch('service/edit-gejala.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                    hideModal(modalBgEditGejala);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
    });

    // Handle edit rule button click
    document.querySelectorAll('.edit-rule-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const row = e.target.closest('tr');
            const kdRule = row.querySelector('td:nth-child(2)').textContent.trim();
            const kdGejala = row.querySelector('td:nth-child(3)').textContent.trim();
            const kdPenyakit = row.querySelector('td:nth-child(4)').textContent.trim();

            document.getElementById('edit-kd-rule').value = kdRule;
            document.getElementById('edit-kd-gejala').value = kdGejala;
            document.getElementById('edit-kd-penyakit').value = kdPenyakit;

            showModal(modalBgEditRule);
        });
    });

    // Handle cancel button click for edit rule
    cancelBtnEditRule.addEventListener('click', function () {
        hideModal(modalBgEditRule);
    });

    // Handle form submission for edit rule
    editFormRule.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(editFormRule);

        fetch('service/edit-rule.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                    hideModal(modalBgEditRule);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
    });

    // Call the delete penyakit setup function
    setupDeletePenyakitHandler();

    // Setup delete penyakit modal and form handlers
    function setupDeletePenyakitHandler() {
        // Handle delete penyakit button click
        document.querySelectorAll('.delete-penyakit-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const row = e.target.closest('tr');
                const idPenyakit = row.querySelector('td:nth-child(2)').textContent.trim();

                deleteIdPenyakitInput.value = idPenyakit;
                showModal(modalBgDeletePenyakit);
            });
        });

        // Handle cancel button click for delete penyakit
        cancelBtnDeletePenyakit.addEventListener('click', function () {
            hideModal(modalBgDeletePenyakit);
        });

        // Handle form submission for delete penyakit
        deleteFormPenyakit.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(deleteFormPenyakit);

            fetch('service/del-penyakit.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                        hideModal(modalBgDeletePenyakit);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
        });
    }
});
