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

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #e8f0ff, #f5f7fa);
      margin: 0;
      padding: 0;
      color: #333;
    }

    /* Navbar */
    .navbar {
      background: #2b4eff;
      color: white;
      padding: 18px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .navbar h1 {
      font-size: 22px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .user-info {
      font-size: 15px;
      background: rgba(255,255,255,0.15);
      padding: 8px 15px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* Container */
    .dashboard-container {
      max-width: 1000px;
      margin: 60px auto;
      padding: 0 20px;
      text-align: center;
    }

    .welcome-card {
      background: white;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.05);
      margin-bottom: 40px;
    }

    .welcome-card h2 {
      color: #2b4eff;
      margin-bottom: 10px;
    }

    .menu-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 25px;
    }

    .menu-card {
      background: white;
      border-radius: 18px;
      padding: 35px 20px;
      text-align: center;
      box-shadow: 0 6px 18px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .menu-card i {
      font-size: 50px;
      color: #2b4eff;
      margin-bottom: 15px;
      transition: 0.3s;
    }

    .menu-card h3 {
      margin-bottom: 10px;
      color: #2b4eff;
    }

    .menu-card p {
      font-size: 14px;
      color: #555;
    }

    .menu-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .menu-card.logout {
      background: #ff4d4d;
      color: white;
    }

    .menu-card.logout i {
      color: white;
    }

    .menu-card.logout:hover {
      background: #cc2c23;
      transform: translateY(-5px);
    }

    .menu-card.logout h3,
    .menu-card.logout p {
      color: white;
    }
  </style>
</head>
<body>

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
        <i class="fa-solid fa-users"></i>
        <h3>Lihat Data Pendaftar</h3>
        <p>Menampilkan data seluruh pendaftar yang sudah terdaftar.</p>
      </div>

      <div class="menu-card logout" onclick="location.href='logout.php'">
        <i class="fa-solid fa-right-from-bracket"></i>
        <h3>Logout</h3>
        <p>Keluar dari sistem dengan aman.</p>
      </div>
    </div>
  </div>

</body>
</html>
