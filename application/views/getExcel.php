<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Lapor KSM Whitelist Cabang - Pusat</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRseiFWEHrVjZAmLE4jg4A7J7LJ_FtD20-qSbn5vYv07Ot05uV7Q6nTrBb_1J9d_Y7UJGU&usqp=CAU" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>assets/css/demo.css" />
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>assets/vendor/css/pages/page-auth.css" />
    <link href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/9.17.4/sweetalert2.min.css" integrity="sha512-4FabU3ouqCMpENU5CMTjtg4JvaOn4Z87muTEkVrmPZ00ZFbvsUij58CSr+58DHmhARlgTxFtraVMlz1ovXumpw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/style.css" />

    <style>
        .step {
            display: none;
        }

        /* Sembunyikan elemen checkbox */
        .swal2-checkbox input[type="checkbox"],
        .swal2-checkbox label[for="swal2-checkbox"] {
            display: none !important;
        }
    </style>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WHRM6NMBSN"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-WHRM6NMBSN');
    </script>
</head>

<body>

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                            <a href="#" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <img src="https://bankmandiri.co.id/image/layout_set_logo?img_id=31567&t=1696784611939" alt="logo mandiri" width="200" />
                                </span>
                            </a>
                        </div>

                        <h4 class="mb-2 text-center">Form KSM Whitelist - BMRI</h4>

                        <p class="mb-4 text-justify">Form ini adalah alat untuk memperbarui data dalam Dataset Form Whitelist Kredit Serbaguna Mandiri (KSM)</p>
                        <form id="formAuthentication" class="mb-3" action="<?= base_url('post-update-data'); ?>" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="cabangSelect" class="form-label">Pilih Data Excel<span class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="excel" id="excel" accept=".xlsx, .xls" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Kode</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" required placeholder="##########" aria-label="kode" id="kode" name="kode" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button type="button" class="input-group-text btn btn-primary" id="konfirm">
                                            <span id="countdown">Kirim Kode</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">
                                    Upload
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="<?= base_url('assets/'); ?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url('assets/'); ?>assets/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url('assets/'); ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?= base_url('assets/'); ?>assets/vendor/js/menu.js"></script>
    <script src="<?= base_url('assets/'); ?>assets/js/main.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="<?= base_url('assets/'); ?>js/step.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/9.17.4/sweetalert2.min.js" integrity="sha512-PN1w3VSzamxPiYUkOI0W8zkHSFQ357fYfHaglVMFNEjWbbBy+kj9rLULjvqcRoqG4B/wconjvgLlYNQhyAzDQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var baseUrl = '<?= base_url('send-code-data'); ?>';
        var isButtonDisabled = false; // Menyimpan status tombol
        var cooldownTimer = null; // Timer untuk cooldown
        var cooldownDuration = 60; // Durasi cooldown dalam detik

        // Mengatur timer countdown
        var countdownElement = document.getElementById("countdown");

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("konfirm").addEventListener("click", function(event) {
                if (isButtonDisabled) return; // Tidak melakukan apa-apa jika tombol dinonaktifkan

                event.preventDefault();
                isButtonDisabled = true; // Menonaktifkan tombol
                countdownElement.textContent = cooldownDuration; // Menampilkan durasi awal

                cooldownTimer = setInterval(function() {
                    cooldownDuration--;
                    if (cooldownDuration <= 0) {
                        // Countdown berakhir, aktifkan tombol kembali
                        clearInterval(cooldownTimer);
                        isButtonDisabled = false;
                        countdownElement.textContent = "Kirim Kode";
                    } else {
                        countdownElement.textContent = cooldownDuration;
                    }
                }, 1000);

                var key = 'bmri';
                var data = new URLSearchParams();
                data.append('key', key);

                fetch(baseUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: data.toString()
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        Swal.fire({
                            icon: data.status === 'success' ? 'success' : 'error',
                            title: data.status === 'success' ? 'Success' : 'Error',
                            text: data.status === 'success' ? '' : '',
                            showCancelButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            toast: true,
                            position: 'top-end',
                        });
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                    });
            });
        });
    </script>

    <?php if ($this->session->flashdata('error')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: '<?= $this->session->flashdata('error'); ?>.'
            });
        </script>
    <?php endif; ?>
    <?php if ($this->session->flashdata('message')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'SUCCESS',
                text: '<?= $this->session->flashdata('message'); ?>.'
            });
        </script>
    <?php endif; ?>

</body>

</html>