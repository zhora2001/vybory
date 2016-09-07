<?php

function csv_to_array($filename='', $delimiter=',')
{
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if(!$header)
                $header = ($row);
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    return $data;
}

$result = csv_to_array(__DIR__.'/diln.csv',';');
$kus = array();
$tmp_kus = array();
$temp_kus = array();
$dil = array();
$rayon = array();
$tmp_rayon = array();
//echo print_r($result);
foreach($result as $var11)
  {
//echo ($var11[1]); //
    array_push($tmp_kus, $var11['kusch']);
    array_push($tmp_rayon, $var11['rayon']);
    $temp_diln[0] = ['diln'=>$var11['diln'], 'n_diln'=>$var11['n_diln']];
    //$new_kusch[$i] = ['kusch'=>$var1, 'n_diln'=>$q];
    array_push($dil,$temp_kusch[0]);
  }
$tmp_kus = array_unique($tmp_kus);
$tmp_rayon = array_unique($tmp_rayon);
$temp_a = array();

foreach($kus as $var1)
    {
$q = ''; $i = 0;
    foreach ($result as $var11) {
      if ($var11['kusch'] == $var1)
      $q .= $var11['n_diln'].", ";
      }

echo  $var1;
echo  $q;
$temp_a[0] = ['kusch'=>$var1, 'n_diln'=>$q];
//$new_kusch[$i] = ['kusch'=>$var1, 'n_diln'=>$q];
array_push($new_kusch,$temp_a[0]);
$i += 1;
}

echo print_r($new_kusch);


?>
