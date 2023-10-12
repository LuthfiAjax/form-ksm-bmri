<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Success</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/'); ?>success.css">
</head>

<body>
    <div class="container">
        <div class="message" id="pop">
            <a href="#" class="close">&times;</a>
            <i class="fa fa-cloud-upload fa-5x"></i>
            <h2>Success &#33;</h2>
            <p>Data Berhasil di Simpan</p>
            <div class="loading-container">
                <div class="loader"></div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "<?= base_url(''); ?>";
        }, 2000);
    </script>
</body>

</html>