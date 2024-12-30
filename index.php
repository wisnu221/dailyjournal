<?php
include "koneksi.php"; 
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dailyjournal</title>
    <link rel="icon" href="logo.png">
    <link rel="stylesheet" 
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
      rel="stylesheet" 
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
      crossorigin="anonymous">
      <style>
        .bb {
            width: 100%;
            height: max-content;
            display: flex;
            background-color:rgb(207, 169, 121);
            justify-content: center;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #c24b4b;
            color: #3d2e2e;
            
            transition: background-color 0.3s, color 0.3s;
        }

        /* Dark mode styling */
        body.dark-mode {
            background-color: #2c1414;
            color: #ffffff;
        }
        .theme-buttons button {
            background-color: #d0bdbd;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 1px 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.3s;
        }
        .dark-buttons button {
            background-color: #010101;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 1px 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.3s;
        }
        .theme-buttons button:hover {
            background-color: #f0f0f0;
        }

        
      </style>
</head>
  <body>
        <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top ">
            <div class="container">
              <a class="navbar-brand" href="#">Myjournal</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
                  <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#article">Article</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#gallery">gallery</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="login.php" target="_blank">Login</a>
                  </li>
                  <li>
                    <div class="dark-buttons">
                      <button id="dark-mode-btn" onclick="setDarkMode()">
                          <!-- Ikon Dark Mode -->
                          <i class="bi bi-moon h3 p-1 bg-dark text-white"></i>
                      </button>
                      
                  </div>
                  </li>
                  <li>
                    <div class="theme-buttons">
                      <button id="light-mode-btn" onclick="setLightMode()">
                        <!-- Ikon Light Mode -->
                       <i class="bi bi-brightness-high h3 p-1 text-dark"></i>
                      </button>
                    </div>
                  </li>  
                </ul>
              </div>
            </div>
          </nav>
    
  <div class="bb">
    <section id="hero" class="text-center p-5 bg-subtle text-sm-start">
      <div class="container">
        <div class="d-sm-flex flex-sm-row-reverse align-items-center">
            <img src="me.jpg" class="img-fluid" width="350">
            <div>
                <h1 class="fw-bold display-4">Perjalanan Kuliahku</h1>
                <h4 class="lead display-6">Semua tentang kegiatan kuliahku di Udinus mulai dari berangkat kuliah hingga pulang kuliah</h4>
                <h6>
                  <span id="tanggal" ></span>
                  <span id="jam" ></span>
                </h6>
              </div>
        </div>
      </div>
    </section>
  </div>
   
   <!-- article begin -->
<section id="article" class="text-center p-5">
  <div class="container">
    <h1 class="fw-bold display-4 pb-3">article</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
      <?php
      $sql = "SELECT * FROM article ORDER BY tanggal DESC";
      $hasil = $conn->query($sql); 

      while($row = $hasil->fetch_assoc()){
      ?>
        <div class="col">
          <div class="card h-100">
            <img src="img/<?= $row["gambar"]?>" class="card-img-top" alt="..." />
            <div class="card-body">
              <h5 class="card-title"><?= $row["judul"]?></h5>
              <p class="card-text">
                <?= $row["isi"]?>
              </p>
            </div>
            <div class="card-footer">
              <small class="text-body-secondary">
                <?= $row["tanggal"]?>
              </small>
            </div>
          </div>
        </div>
        <?php
      }
      ?> 
    </div>
  </div>
</section>
<!-- article end -->

    
  <div class="bb">  
    <section id="gallery" class="text-center p-5 bg--subtle">
        <div class="container">
            <h1>gallery</h1><br>
            <div>
              <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="Cheeese!.jpeg" class="d-block w-100" 
                    alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="Cheeese!.jpeg" class="d-block w-100" 
                    alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="Cheeese!.jpeg" class="d-block w-100" 
                    alt="...">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
            </div>
        </div>
    
    </section>
  </div>
    
    <footer class="text-center p-5">
      <div>
        <a href="https://www.instagram.com/"><i class="bi bi-instagram h2 p-2 text-dark"></i></a>
        <a href="https://twitter.com/?lang=en"><i class="bi bi-twitter-x  h2 p-2 text-dark"></i></a>
        <a href="https://web.whatsapp.com/"><i class="bi bi-whatsapp h2 p-2 text-dark"></i></a>
      </div>
      <div>
        Adhitya Wisnu Priambadha 2024
      </div>
    </footer>
  
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
    <script type="text/javascript">
      window.setTimeout("tampilWaktu()", 1000);
  
      function tampilWaktu() {
          var waktu = new Date();
          var bulan = waktu.getMonth() + 1;
  
          setTimeout("tampilWaktu()", 1000);
          document.getElementById("tanggal").innerHTML =
              waktu.getDate() + "/" + bulan + "/" + waktu.getFullYear();
          document.getElementById("jam").innerHTML =
              waktu.getHours() + ":" +
              waktu.getMinutes() + ":" +
              waktu.getSeconds();
      }
  </script>
  <script>
    //  mengaktifkan Dark Mode
    function setDarkMode() {
        document.body.classList.add("dark-mode");
        localStorage.setItem("theme", "dark");
    }

    //  mengaktifkan Light Mode
    function setLightMode() {
        document.body.classList.remove("dark-mode");
        localStorage.setItem("theme", "light");
    }

    function loadTheme() {
        const theme = localStorage.getItem("theme");
        if (theme === "dark") {
            document.body.classList.add("dark-mode");
        }
    }

    loadTheme();
</script>

  </body>
</html>