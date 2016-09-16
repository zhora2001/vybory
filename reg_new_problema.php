<?php

$nonce = $_REQUEST['nonce'];
//$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : ''; // сначала возьмем скрытое поле nonce

if (!wp_verify_nonce($nonce, 'problema'))
wp_send_json_error(array('message' => 'Данні відправлені з стороньої адреси', 'redirect' => false));

$title_p = isset($_POST['title_p']) ? $_POST['title_p'] : '';
$opys_p = isset($_POST['opys_p']) ? $_POST['opys_p'] : '';
$vyd_problemy = isset($_POST['vyd_problemy']) ? $_POST['vyd_problemy'] : '';
$status_p = isset($_POST['status_p']) ? $_POST['status_p'] : '';
$kontakt = isset($_POST['kontakt']) ? $_POST['kontakt'] : '';
$smi = isset($_POST['smi']) ? $_POST['smi '] : '';
$propos_v = isset($_POST['propos_v']) ? $_POST['propos_v'] : '';




$pod = pods( 'problemy');


$data = array(
                'post_title' => $title_p,
                'post_content' => $opys_p,
                'kontakt' => $kontakt,
                'smi' => $smi,
                'propos_v' => $propos_v
                );

if ($pod != '')
{
//                  $post_id = $pod->id();
//                if( $post_id != $n_prih)
                $post_id = $pod->add( $data );
//                else {
//                  $pod->save( $data );
                }


if ($post_id)
wp_send_json_success(array('message' => 'Записано.'.$post_id, 'redirect' => false));
//wp_send_json_success($data);
else {
  wp_send_json_success(array('message' => 'Трапилась помилка.', 'redirect' => false));
}
die();
 // говорим что все прошло ок, если нужен редирект то вместо false поставьте $redirect_to

?>
