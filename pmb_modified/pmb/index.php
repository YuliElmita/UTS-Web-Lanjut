<?php
// index.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PMB Universitas Nusantara</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- AOS (Animate On Scroll) -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Optional icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
    :root {
      --primary: #0d6efd;
      --primary-dark: #0a58d6;
      --bg: #f5f7fa;
      --muted: #6c757d;
      --accent: #1877ff;
    }
    * { box-sizing: border-box; }
    body {
      font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, Arial;
      background: var(--bg);
      margin: 0;
      padding-top: 70px;
      -webkit-font-smoothing: antialiased;
    }

    /* NAV */
    .navbar { padding: 10px 0 !important; }
    .navbar .navbar-brand img {
      height: 60px;
      width: auto;
      background: #fff;
      border-radius: 50%;
      padding: 4px;
    }

    .nav-login {
      border-radius: 8px;
      padding: 6px 14px;
    }

    /* HERO */
    .hero-section {
      position: relative;
      min-height: 65vh;
      display: flex;
      align-items: center;
      text-align: center;
      color: #fff;
      background-image: url('assets/img/hero.jpg'); /* ganti jika file beda */
      background-size: cover;
      background-position: center;
    }
    /* overlay */
    .hero-section::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(10,85,255,0.82) 0%, rgba(13,110,253,0.72) 60%);
      z-index: 1;
    }
    .hero-inner {
      position: relative;
      z-index: 2;
      width: 100%;
      padding: 60px 20px;
    }
    .hero-title {
      font-size: clamp(28px, 6vw, 64px);
      font-weight: 800;
      margin-bottom: 12px;
      letter-spacing: -0.02em;
    }
    .hero-subtitle {
      font-size: clamp(14px, 2.2vw, 20px);
      color: rgba(255,255,255,0.92);
      margin-bottom: 28px;
      max-width: 980px;
      margin-left: auto;
      margin-right: auto;
    }

    /* CTA button */
    .btn-cta{
      background: linear-gradient(90deg,var(--accent), var(--primary));
      border: none;
      padding: 12px 34px;
      font-size: 1.05rem;
      border-radius: 14px;
      color: #fff;
      box-shadow: 0 12px 30px rgba(13,110,253,0.16);
      transition: transform .12s ease, box-shadow .12s ease;
    }
    .btn-cta:hover { transform: translateY(-3px); box-shadow: 0 18px 40px rgba(13,110,253,0.18); }

    /* Features cards */
    .features { padding: 60px 20px; }
    .feature-card {
      border-radius: 12px;
      padding: 24px;
      background: #fff;
      transition: transform .12s ease, box-shadow .12s ease;
      text-align: center;
      height: 100%;
    }
    .feature-card:hover { transform: translateY(-6px); box-shadow: 0 14px 40px rgba(0,0,0,0.06); }

    /* Counters */
    .counters {
      padding: 36px 20px;
      background: linear-gradient(180deg, rgba(255,255,255,0.6), rgba(255,255,255,0.8));
      margin-top: 12px;
      margin-bottom: 12px;
    }
    .counter-value { font-size: 2.2rem; font-weight: 700; color: var(--primary); }
    .counter-label { color: var(--muted); }

    /* Testimonials */
    .testimonials { padding: 50px 20px; }
    .testimonial-card {
      background: #fff;
      padding: 22px;
      border-radius: 12px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.06);
    }

    /* Footer */
    footer {
      background: var(--primary);
      color: white;
      padding: 18px 20px;
      text-align: center;
      font-size: 16px;
      margin-top: 40px;
      min-height: 56px;
      display:flex;
      align-items:center;
      justify-content:center;
    }

    /* back-to-top button */
    #backToTop {
      position: fixed;
      right: 18px;
      bottom: 18px;
      z-index: 9999;
      width: 46px;
      height: 46px;
      border-radius: 50%;
      display: none;
      align-items: center;
      justify-content: center;
      background: var(--primary);
      color: #fff;
      border: none;
      box-shadow: 0 6px 18px rgba(13,110,253,0.18);
    }

    /* small responsive */
    @media (max-width: 768px){
      .hero-inner{ padding: 40px 16px; }
      .hero-title { font-size: clamp(22px, 10vw, 42px); }
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
      <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
        <img src="img/logo.png" class="me-2" alt="logo" style="height:45px;">
        PMB Universitas Nusantara
      </a>


      <div>
        <a href="login.php" class="btn btn-light btn-sm nav-login">Login</a>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section class="hero-section">
    <div class="hero-inner text-center">
      <h1 class="hero-title" data-aos="fade-up" data-aos-delay="50">
        Pendaftaran Mahasiswa Baru 2025
      </h1>
      <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="150">
        Mari bergabung menjadi bagian dari Universitas Nusantara. Daftar sekarang untuk tahun akademik 2025/2026!
      </p>

      <div data-aos="zoom-in" data-aos-delay="250">
        <a href="daftar.php" class="btn btn-cta">
          Daftar Sekarang <i class="bi bi-arrow-right-short fs-4 ms-2"></i>
        </a>
      </div>
    </div>
  </section>

  <!-- FEATURES -->
  <section class="features">
    <div class="container">
      <div class="row g-4 justify-content-center">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="feature-card">
            <div class="mb-3"><i class="bi bi-mortarboard-fill fs-1 text-primary"></i></div>
            <h5 class="mb-2">Program Studi Unggul</h5>
            <p class="text-muted">Berbagai program studi dengan kurikulum modern dan dosen berkualitas.</p>
          </div>
        </div>

        <div class="col-md-4" data-aos="fade-up" data-aos-delay="180">
          <div class="feature-card">
            <div class="mb-3"><i class="bi bi-people-fill fs-1 text-primary"></i></div>
            <h5 class="mb-2">Beasiswa & Dukungan</h5>
            <p class="text-muted">Skema beasiswa dan bantuan finansial untuk mahasiswa berprestasi.</p>
          </div>
        </div>

        <div class="col-md-4" data-aos="fade-up" data-aos-delay="260">
          <div class="feature-card">
            <div class="mb-3"><i class="bi bi-globe2 fs-1 text-primary"></i></div>
            <h5 class="mb-2">Jaringan Global</h5>
            <p class="text-muted">Kerjasama internasional untuk program pertukaran & riset.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- COUNTERS -->
  <section class="counters">
    <div class="container">
      <div class="row text-center">
        <div class="col-sm-4 mb-3" data-counter data-aos="fade-up">
          <div class="counter-value" data-target="1532">0</div>
          <div class="counter-label">Pendaftar</div>
        </div>
        <div class="col-sm-4 mb-3" data-counter data-aos="fade-up" data-aos-delay="120">
          <div class="counter-value" data-target="28">0</div>
          <div class="counter-label">Program Studi</div>
        </div>
        <div class="col-sm-4 mb-3" data-counter data-aos="fade-up" data-aos-delay="240">
          <div class="counter-value" data-target="12">0</div>
          <div class="counter-label">Kampus Cabang</div>
        </div>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section class="testimonials">
    <div class="container">
      <h3 class="text-center mb-4" data-aos="fade-up">Apa Kata Alumni</h3>

      <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-aos="fade-up" data-aos-delay="80">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="testimonial-card mx-auto" style="max-width:800px;">
              <p class="mb-2">"Pengajaran yang aplikatif dan fasilitas mendukung membuat saya siap bekerja."</p>
              <div class="d-flex align-items-center gap-3">
                <img src="img/alumni1.png" alt="" style="width:56px;height:56px;border-radius:50%;object-fit:cover;">
                <div>
                  <strong>Rina S.</strong><br>
                  <small class="text-muted">Alumni 2022 - Teknik Informatika</small>
                </div>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="testimonial-card mx-auto" style="max-width:800px;">
              <p class="mb-2">"Dosen supportif, kuliah praktikal, dapat beasiswa penuh."</p>
              <div class="d-flex align-items-center gap-3">
                <img src="img/alumni2.png" alt="" style="width:56px;height:56px;border-radius:50%;object-fit:cover;">
                <div>
                  <strong>Rizal K.</strong><br>
                  <small class="text-muted">Alumni 2021 - Manajemen</small>
                </div>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="testimonial-card mx-auto" style="max-width:800px;">
              <p class="mb-2">"Kesempatan magang dan kerja sama industri sangat membantu karier."</p>
              <div class="d-flex align-items-center gap-3">
                <img src="img/alumni3.png" alt="" style="width:56px;height:56px;border-radius:50%;object-fit:cover;">
                <div>
                  <strong>Fatimah L.</strong><br>
                  <small class="text-muted">Alumni 2020 - Desain</small>
                </div>
              </div>
            </div>
          </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    © 2025 Universitas Nusantara — Sistem PMB
  </footer>

  <!-- Back to top -->
  <button id="backToTop" aria-label="Back to top"><i class="bi bi-arrow-up"></i></button>

  <!-- SCRIPTS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

  <script>
    // Init AOS
    AOS.init({ once: true, duration: 700 });

    // Back to top button
    const backBtn = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) backBtn.style.display = 'flex';
      else backBtn.style.display = 'none';
    });
    backBtn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Simple counters: animate number when visible
    const counters = document.querySelectorAll('[data-counter]');
    const options = { root: null, rootMargin: '0px', threshold: 0.5 };

    const runCounter = (el) => {
      const valueElem = el.querySelector('.counter-value');
      if (!valueElem) return;
      const target = +valueElem.getAttribute('data-target') || 0;
      let current = 0;
      const duration = 1600;
      const step = Math.max(1, Math.floor(target / (duration / 16)));

      const timer = setInterval(() => {
        current += step;
        if (current >= target) {
          valueElem.textContent = target.toLocaleString();
          clearInterval(timer);
        } else {
          valueElem.textContent = current.toLocaleString();
        }
      }, 16);
    };

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          runCounter(entry.target);
          obs.unobserve(entry.target);
        }
      });
    }, options);

    counters.forEach(c => observer.observe(c));

    // Optional: light reveal for elements not handled by AOS (fallback)
    document.querySelectorAll('.feature-card, .testimonial-card, .hero-title').forEach(el => {
      el.style.opacity = 0;
    });
    const revealObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.transition = 'opacity .6s ease, transform .6s ease';
          entry.target.style.opacity = 1;
          entry.target.style.transform = 'translateY(0)';
          revealObserver.unobserve(entry.target);
        } else {
          entry.target.style.transform = 'translateY(12px)';
        }
      });
    }, { threshold: 0.15 });

    document.querySelectorAll('.feature-card, .testimonial-card, .hero-title').forEach(el => revealObserver.observe(el));
  </script>
</body>
</html>
