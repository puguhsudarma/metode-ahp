<?php
include 'algoritma_ahp.php';

//Input
//3. Nilai Perbandingan Kriteria
$nilaiPerbandinganKriteria = array(
  array(1,      3,      3,    4,  9,),
  array(0.3333, 1,      3,    4,  3,),
  array(0.3333, 0.3333, 1,    5,  2,),
  array(0.25,   0.25,   0.2,  1,  1,),
  array(0.1111, 0.3333, 0.5,  1,  1,),
);

//4. Nilai Perbandingan Alternatif setiap kriteria
$nilaiPerbandinganAlternatif = array(
  array(23, 12, 34, 45, 12,),
  array(4, 5, 10, 20, 10,),
  array(2, 10, 5, 45, 12,),
  array(3, 5, 9, 5, 1,),
  array(5, 2, 1, 4, 2,),
);

// Testing fungsi
//---------------------------------
//versi hitung"an
$vektor = vektorKriteria($nilaiPerbandinganKriteria);
$CR = CR($nilaiPerbandinganKriteria, $vektor);
$vektorAlternatif = vektorAlternatif($nilaiPerbandinganAlternatif);
$rangking = rangkingAlternatif($vektorAlternatif, $vektor);

//versi simple
$ahp = ahp($nilaiPerbandinganKriteria, $nilaiPerbandinganAlternatif);

echo '<pre>';
print_r($ahp);
echo '</pre>';