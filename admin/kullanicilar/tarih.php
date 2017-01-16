<?php echo date('d.m.Y - H:i:s') ?>
<?php echo date('d.m.Y - H:i:s', strtotime($row_detay['giriszaman'])) ;?>

<p>MYSQL'den veri çekerken</p>
<p> SELECT *, DATE_FORMAT(giriszaman, '%d.%m.%y - %H:%i') AS gzf</p>
