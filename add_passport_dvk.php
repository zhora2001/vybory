<?php

$nonce = $_REQUEST['nonce'];
//$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : ''; // сначала возьмем скрытое поле nonce

if (!wp_verify_nonce($nonce, 'add_passport')) wp_send_json_error(array('message' => 'Данні відправлені з стороньої адреси '.$nonce." ".$nonce1." ", 'redirect' => false));

if (!(is_user_logged_in() && ( current_user_can('manage_options') || is_user_role("raion"))))
   wp_send_json_error(array('message' => 'Реєстрація користувачів недоступна.', 'redirect' => false));


// теперь возьмем все поля и рассуем по переменным
$n_dbk = isset($_POST['dl']) ? $_POST['dl'] : '';
$nazva = isset($_POST['nazva']) ? $_POST['nazva'] : '';
$adresa = isset($_POST['adressa']) ? $_POST['adressa'] : '';
$vyd = isset($_POST['ksch']) ? $_POST['ksch'] : '';
$ustanovy = isset($_POST['ustanovy']) ? $_POST['ustanovy'] : '';
$mezhi = isset($_POST['mezhi']) ? $_POST['mezhi'] : '';
$pidpryems = isset($_POST['pidpryems'])? $_POST['pidpryems']:'';
$misce_zustr = isset($_POST['misce_zustr'])? $_POST['misce_zustr']: '';
$spysok_boss = isset($_POST['spysok_boss'])? $_POST['spysok_boss']:'';

$redirect_to = "http://vybory.el/?page_id=231";

// теперь проверим нужные поля на заполненность и валидность
if (!$n_dbk) wp_send_json_error(array('message' => 'Не вказано номер дільниці', 'redirect' => false));

/*if (!(($diln_r && $diln) || ($kusch_r && $kusch)))
{
wp_send_json_error(array('message' => 'Не вибрано дільницю або кущ.', 'redirect' => false));
}
else {
	if ($diln_r && $diln)
		$role = 'dilnich';
	else
		$role = 'kusch';

}
*/
$nazva = "Дільниця № ".$n_dbk;
$n_prih = trim(strip_tags($_POST['n_prih'])); // переданный id термина таксономии с вложенностью (родитель)

if ($n_prih != '-1' && $n_prih != '')
  $pod = pods( 'pasport_dvk' , $n_prih);
	else {
		$pod = pods( 'pasport_dvk');
	}

 	$data = array(
	'nazva' => $nazva,
	'title' => $nazva,
	'n_dbk' => $n_dbk,
	'adresa' => $adresa,
	'vyd' => $vyd,
	'ustanovy' => $ustanovy,
	'mezhi' => $mezhi,
	'pidpryems' => $pidpryems,
	'misce_zustr' => $misce_zustr,
	'spysok_boss' => $spysok_boss,
	'tochka_rostu' => $tochka_rostu

);


if ($pod != '')
  $post_id = $pod->id();
if( $post_id != $n_prih)
$post_id = $pod->add( $data );
else {
  $pod->save( $data );
}

wp_set_object_terms( $post_id, $n_diln, 'dvk', false );

wp_send_json_success(array('message' => 'Дані про дільницю успішно внесено!', 'redirect' => $redirect_to));
//wp_send_json_success($data);
?>
