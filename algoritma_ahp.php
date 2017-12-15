<?php
//function
//1. Prioritas Vektor Kriteria
function vektorKriteria($nilaiBandingKriteria){
  //init var sum
  $sumCol = array();
  foreach($nilaiBandingKriteria[0] as $val){
    $sumCol[] = 0;
  }

  //operasi sum kolom
  foreach($nilaiBandingKriteria as $row){
    foreach($row as $key => $col){
      $sumCol[$key] += $col;
    }
  }

  //operasi normalisasi
  $normalisasi = array();
  foreach($nilaiBandingKriteria as $keyRow => $row){
    foreach($row as $keyCol => $col){
      $normalisasi[$keyRow][$keyCol] = $col/$sumCol[$keyCol];
    }
  }

  //operasi prioritas vektor
  $vektor = array();
  $totalCol = count($nilaiBandingKriteria[0]);
  foreach($normalisasi as $row){
    $vektor[] = array_sum($row)/$totalCol;
  }

  return $vektor;
}

//2. CR
function CR($nilaiBandingKriteria, $nilaiVektor){
  //init var ax
  $Ax = array();
  foreach($nilaiBandingKriteria[0] as $val){
    $Ax[] = 0;
  }

  $IR = array(
    1 => 0.00,
    2 => 0.00,
    3 => 0.58,
    4 => 0.90,
    5 => 1.12,
    6 => 1.24,
    7 => 1.32,
    8 => 1.41,
    9 => 1.45,
    10 => 1.49,
    11 => 1.51,
    12 => 1.48,
    13 => 1.56,
    14 => 1.57,
    15 => 1.59,
  );
  $totalKriteria = count($nilaiBandingKriteria[0]);
  if($totalKriteria > 15) return 0;

  //operasi Ax
  foreach($nilaiBandingKriteria as $keyRow => $row){
    foreach($row as $keyCol => $col){
      $Ax[$keyRow] += $col*$nilaiVektor[$keyCol]; 
    }
  }

  //operasi Ax/x
  $AxNorm = array();  
  foreach($Ax as $key => $val){
    $AxNorm[] = $val/$nilaiVektor[$key];
  }

  $lambdaMax = array_sum($AxNorm)/$totalKriteria;
  $CI = ($lambdaMax-$totalKriteria)/($totalKriteria-1);
  $CR = $CI/$IR[$totalKriteria];


  return array(
    'CR' => $CR,
    'konsisten' => $CR <= 0.1,
  );
}

//3. Prioritas Vektor Alternatif
function vektorAlternatif($nilaiAlternatif){
  //operasi sum
  $sum = array();
  foreach($nilaiAlternatif as $val){
    $sum[] = array_sum($val);
  }

  //operasi normalisasi
  $normalisasi = array();
  foreach($nilaiAlternatif as $keyRow => $row){
    foreach($row as $keyCol => $col){
      $normalisasi[$keyRow][$keyCol] = $col/$sum[$keyRow];
    }
  }

  $matrix = $normalisasi;
  $rows = count($matrix);
  $columns = count($matrix[0]);
  $transposed = array();
  for ($y = 0; $y < $rows; ++$y) {
      for ($x = 0; $x < $columns; ++$x) {
          $transposed[$x][$y] = $matrix[$y][$x];
      }
  }
  return $transposed;
}

//4. Nilai Rangking Alternatif
function rangkingAlternatif($vektorAlternatif, $vektorKriteria){
  //init var
  $hasil = array();
  foreach($vektorAlternatif as $val){
    $hasil[] = 0;
  }

  foreach($vektorAlternatif as $keyRow => $row){
    foreach($row as $keyCol => $col){
      $hasil[$keyRow] += $col*$vektorKriteria[$keyCol];
    }
  }
  arsort($hasil);

  return $hasil;
}

//5. bundle function
function ahp($nilaiPerbandinganKriteria, $nilaiPerbandinganAlternatif){
  $vektor = vektorKriteria($nilaiPerbandinganKriteria);
  $CR = CR($nilaiPerbandinganKriteria, $vektor);
  $vektorAlternatif = vektorAlternatif($nilaiPerbandinganAlternatif);
  $rangking = rangkingAlternatif($vektorAlternatif, $vektor);

  return $rangking;
}