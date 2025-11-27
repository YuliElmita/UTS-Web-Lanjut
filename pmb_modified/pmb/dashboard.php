<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard <?php echo ucfirst($_SESSION['role']); ?></title>

  <!-- Google Font & Icon -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">

  <style>
    /* minimal overrides for this page to work with shared light theme */
    .navbar { padding: 14px 20px; border-radius: 10px; background: var(--card); border:1px solid rgba(15,23,42,0.03); box-shadow:0 4px 12px rgba(15,23,42,0.03); }
    .navbar h1 { font-size: 20px; margin:0 }
    .user-info { font-size:15px; background: rgba(0,0,0,0.03); padding:6px 12px; border-radius:8px }
    .dashboard-container { max-width:1140px; margin: 28px auto; padding: 0 20px; }
    .welcome-card{ background:var(--card); border-radius:12px; padding:24px; box-shadow:0 6px 18px rgba(15,23,42,0.03) }
    .menu-card{ background:var(--card); border-radius:12px; padding:24px; box-shadow:0 6px 12px rgba(15,23,42,0.03); cursor:pointer }
    .menu-card.logout{ background:#ff4d4d; color:#fff }
  </style>
</head>
<body class="theme-white">

  <!-- Navbar -->
  <div class="navbar">
    <h1><i class="fa-solid fa-gauge"></i> Dashboard <?php echo ucfirst($_SESSION['role']); ?></h1>
    <div class="user-info">
      <i class="fa-solid fa-user"></i> <?php echo $_SESSION['username']; ?>
    </div>
  </div>

  <!-- Content -->
  <div class="dashboard-container">
    <div class="welcome-card">
      <h2>Selamat Datang, <?php echo $_SESSION['username']; ?> 👋</h2>
      <p>Anda login sebagai <strong><?php echo ucfirst($_SESSION['role']); ?></strong>. Silakan pilih menu di bawah.</p>
    </div>

    <div class="menu-grid">
      <div class="menu-card" onclick="location.href='data_pendaftaran.php'">
        <i class="fa-solid fa-users" style="font-size:42px;color:var(--primary)"></i>
        <h3 style="color:var(--primary);">Lihat Data Pendaftar</h3>
        <p>Menampilkan data seluruh pendaftar yang sudah terdaftar.</p>
      </div>

      <div class="menu-card logout" onclick="location.href='logout.php'">
        <i class="fa-solid fa-right-from-bracket" style="font-size:42px;color:inherit"></i>
        <h3>Logout</h3>
        <p>Keluar dari sistem dengan aman.</p>
      </div>
    </div>
  </div>

</body>
</html>
