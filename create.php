<!DOCTYPE html>
<html>
<head>
    <title>Form Tambah Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php
    //Include file koneksi, untuk koneksikan ke database
    include "koneksi.php";

    //Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    //Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nama_produk=input($_POST["nama_produk"]);
        $deskripsi=input($_POST["deskripsi"]);
        $harga=input($_POST["harga"]);
        $gambar=input($_FILES["gambar"]);
        

        //Query input menginput data kedalam tabel anggota
        $sql="insert into katalog (nama_produk, deskripsi, harga, gambar) values
		('$nama_produk','$deskripsi','$harga','$gambar')";

        //Mengeksekusi/menjalankan query diatas
        $hasil=mysqli_query($kon,$sql);

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            header("Location:index.php");
        }
        else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";

        }

    }
    
    if (isset($_FILES['gambar'])) {
        $file = $_FILES['gambar'];
    
        // Mendapatkan informasi file gambar yang diupload
        $fileName = $file['name'];
        $fileTmp = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
    
        // Memeriksa apakah tidak ada error saat upload
        if ($fileError === UPLOAD_ERR_OK) {
            // Memeriksa ekstensi file
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = array('jpg', 'jpeg', 'png');
    
            if (in_array($fileExt, $allowedExtensions)) {
                // Memeriksa ukuran file (dalam contoh ini, maksimal 5MB)
                $maxFileSize = 5 * 1024 * 1024; // 5MB
                if ($fileSize <= $maxFileSize) {
                    // Membuat nama unik untuk file
                    $newFileName = uniqid('', true) . '.' . $fileExt;
    
                    // Tentukan direktori tujuan untuk menyimpan file
                    $uploadDir = 'uploads/';
                    $targetPath = $uploadDir . $newFileName;
    
                    // Pindahkan file gambar ke direktori tujuan
                    if (move_uploaded_file($fileTmp, $targetPath)) {
                        echo "File berhasil diupload.";
                    } else {
                        echo "Terjadi kesalahan saat mengupload file.";
                    }
                } else {
                    echo "Ukuran file terlalu besar. Maksimal 5MB.";
                }
            } else {
                echo "Ekstensi file tidak diizinkan. Hanya file JPG, JPEG, dan PNG yang diperbolehkan.";
            }
        } else {
            echo "Terjadi kesalahan saat mengupload file. Error code: " . $fileError;
        }
    }

    ?>
    <h2>Tambah Produk Baru</h2>


    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <div class="form-group">
            <label>Nama Produk :</label>
            <input type="text" name="nama_produk" class="form-control" placeholder="Masukan Nama Produk" required />

        </div>
        <div class="form-group">
            <label>Deskripsi :</label>
            <input type="text" name="deskripsi" class="form-control" placeholder="Masukan Deskripsi" required/>
        </div>
       <div class="form-group">
            <label>Harga :</label>
            <input type="text" name="harga" class="form-control" placeholder="Masukan Harga" required/>
        </div>
                </p>
        <div class="form-group">
            <label>Gambar : </label>
            <input type="file" name="gambar" class="form-control" placeholder="Masukan Gambar" required/>
        </div>     

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>