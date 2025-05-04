<!-- <?php
session_start();
?> -->
<header class="head">
    <h1>MALDI</h1>
    <nav class="nav-menu">
        <ul>
            <li><a href="<?php echo isset($_SESSION['is_login']) && $_SESSION['is_login'] ? 'dashboard.php' : 'index.php'; ?>">Home</a></li>
            <?php if (isset($_SESSION['is_login']) && $_SESSION['is_login'] && isset($_SESSION['level']) && $_SESSION['level'] === 'admin'): ?>
                <li><a href="master.php">Data Master</a></li>
            <?php endif; ?>
            <li><a href="diagnosa.php">Diagnosa</a></li>
            <li><a href="tentang.php">Tentang</a></li>
            <li><a href="pengguna.php">User</a></li>
        </ul>
    </nav>
</header>
