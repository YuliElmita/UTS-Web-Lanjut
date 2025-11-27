<?php
// dashboard_admin.php
session_start();
include 'koneksi.php';

// Kalau belum login, lempar ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// ================== INISIALISASI ==================
$todayCount   = 0;
$pendingCount = 0;
$revenue      = 0;

// kita tahu struktur tb_pendaftaran
$tanggalField = 'tanggal_daftar';
$statusField  = 'status_pendaftaran';

$list_q       = null;   // query daftar pendaftar terbaru

// ================== HITUNG PENDAFTAR HARI INI (tb_pendaftaran) ==================
$qToday = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS cnt
     FROM tb_pendaftaran
     WHERE DATE($tanggalField) = CURDATE()"
);

if ($qToday && $rToday = mysqli_fetch_assoc($qToday)) {
    $todayCount = (int)$rToday['cnt'];
}

// ================== DAFTAR PENDAFTAR TERBARU (JOIN 3 TABEL) ==================
$sqlList = "
    SELECT d.id_pendaftaran,
           d.tanggal_daftar,
           d.status_pendaftaran,
           c.nama_lengkap,
           p.nama_prodi
    FROM tb_pendaftaran d
    LEFT JOIN tb_calon_mahasiswa c ON d.id_calon = c.id_calon
    LEFT JOIN tb_prodi           p ON d.id_prodi = p.id_prodi
    ORDER BY d.tanggal_daftar DESC, d.id_pendaftaran DESC
    LIMIT 10
";

$list_q = mysqli_query($koneksi, $sqlList);

// ================== PENDING & PENDAPATAN ==================

// 1) pembayaran pending di tb_pendaftaran (status_pendaftaran)
$q2 = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS cnt 
     FROM tb_pendaftaran 
     WHERE LOWER(status_pendaftaran) LIKE '%menunggu%' 
        OR LOWER(status_pendaftaran) LIKE '%pending%'"
);
if ($q2 && $r2 = mysqli_fetch_assoc($q2)) {
    $pendingCount = (int)$r2['cnt'];
}

// 2) total pendapatan (mencari kolom uang otomatis di tb_pendaftaran / tb_pembayaran)
$possible_cols = ['biaya','biaya_pendaftaran','tarif','uang','jumlah','nominal','harga','total_bayar','total'];
$found_col = null;

// cek dulu di tb_pendaftaran
$resCols = mysqli_query($koneksi, "SHOW COLUMNS FROM tb_pendaftaran");
if ($resCols) {
    while ($col = mysqli_fetch_assoc($resCols)) {
        $name = strtolower($col['Field']);
        if (in_array($name, $possible_cols)) {
            $found_col = $col['Field'];
            break;
        }
    }
}
if ($found_col) {
    $q3 = mysqli_query($koneksi, "SELECT SUM($found_col) AS s FROM tb_pendaftaran");
    if ($q3 && $r3 = mysqli_fetch_assoc($q3)) {
        $revenue = $r3['s'] ? (float)$r3['s'] : 0;
    }
} else {
    // kalau tidak ada di tb_pendaftaran, coba cek tb_pembayaran kalau tabelnya ada
    $qExists = mysqli_query($koneksi, "SHOW TABLES LIKE 'tb_pembayaran'");
    if ($qExists && mysqli_num_rows($qExists) > 0) {
        $res = mysqli_query($koneksi, "SHOW COLUMNS FROM tb_pembayaran");
        $pay_col = null;
        if ($res) {
            while ($c = mysqli_fetch_assoc($res)) {
                if (in_array(strtolower($c['Field']), $possible_cols)) {
                    $pay_col = $c['Field'];
                    break;
                }
            }
        }
        if ($pay_col) {
            $q4 = mysqli_query($koneksi, "SELECT SUM($pay_col) AS s FROM tb_pembayaran");
            if ($q4 && $r4 = mysqli_fetch_assoc($q4)) {
                $revenue = $r4['s'] ? (float)$r4['s'] : 0;
            }
        }
    }
}

// ================== 🔹 DATA GRAFIK PENDAFTARAN MINGGUAN ==================
$labels = [];
$dataPendaftar = [];

for ($i = 6; $i >= 0; $i--) {
    $tgl = date('Y-m-d', strtotime("-$i days"));
    // label ditampilkan dd/mm
    $labels[] = date('d/m', strtotime($tgl));

    $q = mysqli_query($koneksi, "
        SELECT COUNT(*) AS jml 
        FROM tb_pendaftaran 
        WHERE DATE($tanggalField) = '$tgl'
    ");
    $row = mysqli_fetch_assoc($q);
    $dataPendaftar[] = (int) ($row['jml'] ?? 0);
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin Dashboard — PMB</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">

  <!-- 🔹 CDN Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="app">
  <aside class="sidebar" id="sidebar">
    <div class="brand">
      <div class="logo">ADM</div>
      <div>
        <h1>Admin PMB</h1>
        <p class="muted">Panel kontrol</p>
      </div>
      <button class="collapse-btn" id="collapseBtn" title="Sembunyikan sidebar">☰</button>
    </div>

    <nav class="nav" aria-label="main navigation">
      <a class="active" href="dashboard_admin.php">🏠 <span class="label">Dashboard</span></a>
      <a href="data_pendaftaran.php">🧾 <span class="label">Pendaftar</span></a>
      <a href="kelola_berkas.php">📂 <span class="label">Berkas</span></a>
      <a href="data_user.php">👥 <span class="label">User</span></a>
      <a href="logout.php">🔒 <span class="label">Logout</span></a>
    </nav>

    <div style="margin-top:auto;display:flex;flex-direction:column;gap:8px">
      <div class="muted" style="font-size:12px">Tema</div>
      <div style="display:flex;gap:8px">
        <button class="btn" id="lightBtn">Light</button>
        <button class="btn" id="darkBtn">Dark</button>
      </div>
    </div>
  </aside>

  <main class="main">
    <div class="topbar">
      <div style="display:flex;gap:12px;align-items:center">
        <div class="search">
          🔎 <input placeholder="Cari pendaftar, pembayaran..." id="searchInput" />
        </div>
        <div class="muted">Selamat datang, Admin</div>
      </div>
      <div class="actions">
        <button class="btn" id="notifBtn">🔔</button>
        <button class="btn" id="addBtn" onclick="location.href='data_pendaftaran.php'">+ Tambah</button>
        <div style="display:flex;align-items:center;gap:8px">
          <img src="https://i.pravatar.cc/40" alt="avatar" style="width:36px;height:36px;border-radius:10px;object-fit:cover;border:2px solid rgba(255,255,255,0.03)">
        </div>
      </div>
    </div>

    <section class="grid">
      <div class="card">
        <h3>Pendaftar Hari Ini</h3>
        <div class="value" id="todayCount"><?= (int)$todayCount ?></div>
        <div class="muted">
          <?php if ($todayCount > 0): ?>
            Total calon mahasiswa terdaftar hari ini.
          <?php else: ?>
            Belum ada pendaftar yang tercatat hari ini.
          <?php endif; ?>
        </div>
      </div>

      <div class="card">
        <h3>Total Pendapatan</h3>
        <div class="value">Rp <span id="revenue"><?= number_format((float)$revenue,0,',','.') ?></span></div>
        <div class="muted">Perhitungan otomatis dari data pembayaran</div>
      </div>

      <div class="card">
        <h3>Pembayaran tertunda</h3>
        <div class="value" id="pending"><?= (int)$pendingCount ?></div>
        <div class="muted">Periksa segera pembayaran yang menunggu</div>
      </div>

      <div class="card big">
        <h3>Grafik Pendaftaran Mingguan</h3>
        <canvas id="chart" class="spark"></canvas>
      </div>

      <div class="card wide table-card">
        <h3 style="padding:16px 16px 0 16px">Daftar Pendaftar Terbaru</h3>
        <div style="padding:12px 16px">
          <table>
            <thead>
              <tr>
                <th>Nama</th>
                <th>Prodi</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="applicantsTable">
<?php
if ($list_q && mysqli_num_rows($list_q) > 0) {
    while ($row = mysqli_fetch_assoc($list_q)) {
        // NAMA
        if (!empty($row['nama_lengkap'])) {
            $name = $row['nama_lengkap'];
        } elseif (!empty($row['nama'])) {
            $name = $row['nama'];
        } else {
            $name = 'Calon#' . (isset($row['id_pendaftaran']) ? $row['id_pendaftaran'] : '');
        }

        // PRODI
        $prodi = '-';
        if (!empty($row['nama_prodi'])) {
            $prodi = $row['nama_prodi'];
        }

        // TANGGAL
        $tgl = '-';
        if (!empty($row[$tanggalField]) &&
            $row[$tanggalField] != '0000-00-00' &&
            $row[$tanggalField] != '0000-00-00 00:00:00') {

            if (strtotime($row[$tanggalField]) !== false) {
                $tgl = date('d-m-Y', strtotime($row[$tanggalField]));
            } else {
                $tgl = $row[$tanggalField];
            }
        }

        // STATUS
        $status = 'Baru';
        if (!empty($row[$statusField])) {
            $status = $row[$statusField];
        }

        // kelas status untuk warna
        $cls = 'status';
        if (stripos($status,'lunas') !== false || stripos($status,'terima') !== false) {
            $cls = 'status paid';
        } elseif (stripos($status,'menunggu') !== false || stripos($status,'pending') !== false) {
            $cls = 'status pending';
        }

        echo "<tr>";
        echo "<td>".htmlspecialchars($name)."</td>";
        echo "<td>".htmlspecialchars($prodi)."</td>";
        echo "<td>".htmlspecialchars($tgl)."</td>";
        echo "<td><span class='{$cls}'>".htmlspecialchars($status)."</span></td>";
        echo "<td><a class='btn' href='data_pendaftaran.php'>Detail</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5' class='muted' style='text-align:center'>Belum ada pendaftar yang tersimpan.</td></tr>";
}
?>
            </tbody>
          </table>
        </div>
      </div>

    </section>
  </main>
</div>

<!-- modal -->
<div class="modal-backdrop" id="modalBackdrop">
  <div class="modal" role="dialog" aria-modal="true">
    <h2 id="modalTitle">Detail</h2>
    <p id="modalBody">Informasi pendaftar...</p>
    <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
      <button class="btn" id="closeModal">Tutup</button>
    </div>
  </div>
</div>

<script>
// Sidebar collapse
const sidebar   = document.getElementById('sidebar');
const collapseBtn = document.getElementById('collapseBtn');
collapseBtn.addEventListener('click', ()=>{
  sidebar.classList.toggle('collapsed');
  collapseBtn.textContent = sidebar.classList.contains('collapsed') ? '➡' : '☰';
});

// Theme buttons
document.body.classList.add('theme-white');
document.getElementById('lightBtn').addEventListener('click', ()=>{
  document.body.classList.add('theme-white');
  document.body.classList.remove('theme-dark');
});
document.getElementById('darkBtn').addEventListener('click', ()=>{
  document.body.classList.remove('theme-white');
  document.body.classList.add('theme-dark');
});

// Modal
const modal = document.getElementById('modalBackdrop');
document.getElementById('closeModal').addEventListener('click', ()=> modal.style.display='none');
modal.addEventListener('click', (e)=>{ if(e.target===modal) modal.style.display='none'; });

// 🔹 GRAFIK PENDAFTARAN MINGGUAN (Chart.js)
const labels = <?= json_encode($labels); ?>;
const dataPendaftar = <?= json_encode($dataPendaftar); ?>;

const chartCanvas = document.getElementById('chart');
if (chartCanvas && window.Chart) {
    const ctx = chartCanvas.getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: dataPendaftar,
                fill: true,
                tension: 0.35,
                borderWidth: 2
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
}
</script>
</body>
</html>
