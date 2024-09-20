<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PDAM Tugu Tirta - Landing Page</title>
    <link rel="stylesheet" href="landing/assets/css/bulma.min.css" />
    <link rel="stylesheet" href="landing/assets/css/style.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css" />
    
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
      integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <script src="landing/assets/js/jquery-3.6.0.js"></script>
  </head>
  <body>
    <!-- Back To Top Start -->
    <a id="backtotop" data-tippy-content="Back To Top.">
      <i class="fa-solid fa-angle-up has-text-white fa-2xl mt-5"></i>
    </a>
    <!-- Back To Top End -->

    <!-- Navbar Start -->
    <nav
      class="navbar is-fixed-top"
      role="navigation"
      aria-label="main navigation"
    >
      <div class="navbar-brand mt-2 mb-2">
        <a class="navbar-item" href="#">
          <strong>PDAM Tugu Tirta</strong>
        </a>

        <a
          role="button"
          class="navbar-burger has-text-white"
          data-target="navMenu"
          aria-label="menu"
          aria-expanded="false"
        >
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>

      <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
          <a href="#" class="navbar-item is-tab">
            Home
          </a>

          <a href="#features" class="navbar-item is-tab">
            Layanan
          </a>
        </div>

        <div class="navbar-end">
         

          <div class="navbar-item">
            <div class="buttons">
              <a href="{{ route('login') }}" class="button is-blurple">
                <strong>
                  <i class="fa-solid fa-right-to-bracket mr-2"></i>
                  Login
                </strong>
              </a>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- Navbar End -->

    <!-- Hero Section Start -->
    <section class="hero bg-base is-fullheight">
      <div class="hero-body">
        <div class="">
          <div class="columns">
            <div class="column mr-6 mt-12" data-aos="fade-up">
              <p class="title has-text-black has-text-weight-bold">
                PDAM Tugu Tirta - Pelayanan Air Bersih untuk Kota Malang
              </p>
              <p class="subtitle has-text-black is-size-6 mt-3">
                Akses air bersih adalah salah satu kebutuhan manusia di manapun. Di Indonesia, masyarakat bisa mendapatkan air bersih dengan menggali sumur sendiri atau melalui layanan air dari PDAM.
              </p>
              <div class="buttons">
                <a href="{{ route('login') }}" class="button is-info">
                  <strong>Masuk ke Dashboard</strong>
                </a>
              </div>
            </div>
            <div class="column mt-6" data-aos="fade-left">
              <img
                class="image has-image-centered vert-move mt-4"
                src="landing/assets/img/relaunch_day.svg"
                alt="hero image"
                style="width: 20rem;"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="has-text-centered" data-tippy-content="Scroll Down">
        <a href="#features"
          ><i
            class="fa-solid fa-circle-chevron-down fa-lg vert-move2 has-text-white"
          ></i
        ></a>
      </div>
    </section>
    <!-- Hero Section End -->

    <!-- Hero Waves Start -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
      <path
        fill="#82d8ef"
        fill-opacity="0.7"
        d="M0,288L24,261.3C48,235,96,181,144,154.7C192,128,240,128,288,149.3C336,171,384,213,432,202.7C480,192,528,128,576,133.3C624,139,672,213,720,213.3C768,213,816,139,864,101.3C912,64,960,64,1008,106.7C1056,149,1104,235,1152,240C1200,245,1248,171,1296,144C1344,117,1392,139,1416,149.3L1440,160L1440,0L1416,0C1392,0,1344,0,1296,0C1248,0,1200,0,1152,0C1104,0,1056,0,1008,0C960,0,912,0,864,0C816,0,768,0,720,0C672,0,624,0,576,0C528,0,480,0,432,0C384,0,336,0,288,0C240,0,192,0,144,0C96,0,48,0,24,0L0,0Z"
      ></path>
    </svg>
    <!-- Hero Waves End -->

    <!-- Features Section Start -->
   <section id="features" class="section mt-6">
      <div class="has-text-centered">
        <h1 class="title lined">Layanan</h1>
        <div class="line line-center blurple"></div>
      </div>

      <div class="single-feature">
        <div class="columns mt-6">
          <div class="column mr-6">
            <h4 class="title">Sejarah <span class="blurple">PDAM</span></h4>
            <p class="subtitle mt-3">
              Kegiatan pelayanan air minum untuk masyarakat Kota Malang sudah dimulai sejak era Kolonial Belanda, tepatnya pada 31 Maret 1915. Kala itu, distribusi air dilaksanakan oleh Waterleiding Verordingen Kota Besar Malang. Sumber air baku diambil dari Sumber Karangan.
            </p>
          </div>
          <div class="column" data-aos="fade-left">
            <img class="image has-image-centered" src="landing/assets/img/features1.svg" alt="feature1 img" style="width: 23rem;" />
          </div>
        </div>
      </div>

      <div class="single-feature">
        <div class="columns mt-6">
          <div class="column" data-aos="fade-right">
            <img class="image has-image-centered" src="landing/assets/img/features2.svg" alt="feature2 img" style="width: 23rem;" />
          </div>
          <div class="column">
            <h4 class="title">Area Pelayanan <span class="has-text-primary">PDAM</span></h4>
            <p class="subtitle mt-3">
              Area pelayanan Perumda Tugu Tirta mencakup keseluruhan luas wilayah Kota Malang dengan area pelayanan seluas 145,28 km2 dan jumlah pelanggan mencapai lebih dari 175 ribu rumah tangga. Produksi air mencapai hampir 1.500 liter/detik.
            </p>
          </div>
        </div>
      </div>

      <div class="single-feature">
        <div class="columns mt-6">
          <div class="column mr-6">
            <h4 class="title">Layanan <span class="has-text-warning">ZAMP</span></h4>
            <p class="subtitle mt-3">
              Perumda Tugu Tirta menyediakan Zona Air Minum Prima (ZAMP) untuk masyarakat Kota Malang. Kualitas air dari ZAMP memenuhi 4 aspek utama, yaitu dari segi kualitas, kuantitas, kontinuitas, dan keterjangkauan.
            </p>
          </div>
          <div class="column" data-aos="fade-left">
            <img class="image has-image-centered" src="landing/assets/img/features3.svg" alt="feature3 img" style="width: 23rem;" />
          </div>
        </div>
      </div>
    </section>
    <!-- Features Section End -->

    <!-- Stats Section Start -->
    <section id="stats" class="section has-bg-brown">
      <div class="has-text-centered">
        <h1 class="title lined has-text-white">Statistik PDAM Tugu Tirta</h1>
        <div class="line line-center blurple"></div>
      </div>

      <div class="content mt-6 has-text-white">
        <p>
          Beberapa data statistik penting dari PDAM Tugu Tirta Kota Malang:
        </p>
        <ul>
          <li>Jumlah Pelanggan: 175.000+ rumah tangga</li>
          <li>Produksi Air: 1.500 liter/detik</li>
          <li>Luas Area Pelayanan: 145,28 km²</li>
        </ul>
      </div>
    </section>
    <!-- Stats Section End -->

    <script src="landing/assets/js/bulma.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
    <script src="landing/assets/js/backtotop.js"></script>
    <script src="landing/assets/js/app.js"></script>
    <script>
      AOS.init({
        duration: 1000,
      });
    </script>
  </body>
</html>
