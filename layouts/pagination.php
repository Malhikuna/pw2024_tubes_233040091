<div class="pagination">
  <?php if( $halamanAktif > 1 ) : ?>
    <a href="?page=<?= $halamanAktif - 1 ?>">&laquo;</a>
  <?php endif ; ?>

  <?php for($i = 1; $i <= $jumlahHalaman; $i++) : ?>
    <?php if( $i == $halamanAktif ) : ?>
    <div class="active">
      <a href="?page=<?= $i ?>"><?= $i; ?></a>
    </div>
    <?php else : ?>
    <a href="?page=<?= $i ?>"><?= $i; ?></a>
    <?php endif ; ?>
  <?php endfor ; ?>

  <?php if( $halamanAktif < $jumlahHalaman ) : ?>
    <a href="?page=<?= $halamanAktif + 1 ?>">&raquo;</a>
  <?php endif ; ?>
</div>