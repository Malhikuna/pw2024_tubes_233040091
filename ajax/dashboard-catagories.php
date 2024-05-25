<?php 
require "../functions/functions.php";
$keyword = $_GET["keyword"];

$jumlahDataPerHalaman = 5;
$jumlahData = count(query("SELECT * FROM catagories"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$query = "SELECT * FROM catagories
          WHERE 
          catagory_name LIKE '%$keyword%'
          ORDER BY id DESC
          LIMIT $dataAwal, $jumlahDataPerHalaman
";
$catagory = query($query);

?>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Catagory Name</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; ?>
      <?php foreach($catagory as $ctg) : ?>
        <tr>
          <td><?= $i++; ?></td>
          <td><?= $ctg["catagory_name"]; ?></td>
          <td>
            <a href="update-catagory.php?id=<?= $ctg["id"]; ?>"><button name="update" class="update">Update</button></a>
            <a href="delete-catagory.php?id=<?= $ctg["id"]; ?>"><button name="delete" class="delete">Delete</button></a>
          </td>
        </tr>
        <?php endforeach ; ?>
      </tbody>
  </table>

  <?php require "../layouts/pagination.php" ?>