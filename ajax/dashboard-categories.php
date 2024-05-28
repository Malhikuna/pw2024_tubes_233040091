<?php 
require "../functions/functions.php";
$keyword = $_GET["keyword"];

$jumlahDataPerHalaman = 5;
$jumlahData = count(query("SELECT * FROM categories"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$query = "SELECT * FROM categories
          WHERE 
          category_name LIKE '%$keyword%'
          ORDER BY id DESC
          LIMIT $dataAwal, $jumlahDataPerHalaman
";
$category = query($query);

?>

<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Category Name</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; ?>
    <?php foreach($category as $ctg) : ?>
    <tr>
      <td><?= $i++; ?></td>
      <td><?= $ctg["category_name"]; ?></td>
      <td>
        <a href="update-category.php?id=<?= $ctg["id"]; ?>"><button name="update" class="update">Update</button></a>
        <a href="delete-category.php?id=<?= $ctg["id"]; ?>"><button name="delete" class="delete">Delete</button></a>
      </td>
    </tr>
    <?php endforeach ; ?>
  </tbody>
</table>

<?php require "../layouts/pagination.php" ?>