<?php
include "service/database.php"; // Include the database connection

// Function to create a new symptom
function createSymptom($name) {
    global $db;
    $query = "INSERT INTO tb_gejala (gejala) VALUES ('$name')";
    return mysqli_query($db, $query);
}

// Function to read all symptoms
function readSymptoms() {
    global $db;
    $query = "SELECT * FROM tb_gejala";
    return mysqli_query($db, $query);
}

// Function to update a symptom
function updateSymptom($id, $name) {
    global $db;
    $query = "UPDATE tb_gejala SET gejala = '$name' WHERE id = $id";
    return mysqli_query($db, $query);
}

// Function to delete a symptom
function deleteSymptom($id) {
    global $db;
    $query = "DELETE FROM tb_gejala WHERE id = $id";
    return mysqli_query($db, $query);
}

// Example usage
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        createSymptom($_POST['name']);
    } elseif (isset($_POST['update'])) {
        updateSymptom($_POST['id'], $_POST['name']);
    } elseif (isset($_POST['delete'])) {
        deleteSymptom($_POST['id']);
    }
}

// Fetch symptoms for display
$symptoms = readSymptoms();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Symptoms</title>
</head>
<body>
    <h1>Manage Symptoms</h1>
    <form method="POST">
        <input type="text" name="name" placeholder="Symptom Name" required>
        <button type="submit" name="create">Add Symptom</button>
    </form>

    <h2>Existing Symptoms</h2>
    <ul>
        <?php while ($row = mysqli_fetch_assoc($symptoms)): ?>
            <li>
                <?php echo $row['nama_gejala']; ?>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="text" name="name" placeholder="New Name">
                    <button type="submit" name="update">Update</button>
                </form>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
