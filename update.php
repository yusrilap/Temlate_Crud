<!DOCTYPE html>
<html>
<head>
    <title>Form Update Produk</title>
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
    //Cek apakah ada nilai yang dikirim menggunakan methos GET dengan nama id_peserta
    if (isset($_GET['id_produk'])) {
        $id_produk=input($_GET["id_produk"]);

        $sql="select * from katalog where id_produk=$id_produk";
        $hasil=mysqli_query($kon,$sql);
        $data = mysqli_fetch_assoc($hasil);


    }

    //Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id_produk=htmlspecialchars($_POST["id_produk"]);
        $nama_produk=input($_POST["nama_produk"]);
        $deskripsi=input($_POST["deskripsi"]);
        $harga=input($_POST["harga"]);
        $gambar=input($_FILES["gambar"]);

        //Query update data pada tabel anggota
        $sql="update katalog set
			nama_produk='$nama_produk',
			deskripsi='$deskripsi',
			harga='$harga',
			gambar='$gambar',
			where id_produk=$id_produk";

        //Mengeksekusi atau menjalankan query diatas
        $hasil=mysqli_query($kon,$sql);

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            header("Location:index.php");
        }
        else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";

        }

    }

    ?>
    <h2>Update Data Produk</h2>


    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
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
        <div class="form-group">
            <label>Gambar :</label>
            <input type="file" name="gambar" class="form-control" placeholder="Masukan Gambar" required/>
        </div>
        <input type="hidden" name="id_produk" value="<?php echo $data['id_produk']; ?>" />

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>