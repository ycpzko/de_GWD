<?php require_once('auth.php'); ?>
<?php if (isset($auth) && $auth) {?>
<?php
$listB = $_GET['listB'];
$listW = $_GET['listW'];
$listBlan = $_GET['listBlan'];
$listWlan = $_GET['listWlan'];

$data = json_decode(file_get_contents('/usr/local/bin/0conf'), true);
$arr = explode("\n",$listB);
$arr = array_filter($arr);
$data['listB'] = array();
$data['listB'] = $arr;
$newJsonString = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents('/usr/local/bin/0conf', $newJsonString);

$data = json_decode(file_get_contents('/usr/local/bin/0conf'), true);
$arr = explode("\n",$listW);
$arr = array_filter($arr);
$data['listW'] = array();
$data['listW'] = $arr;
$newJsonString = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents('/usr/local/bin/0conf', $newJsonString);

$data = json_decode(file_get_contents('/usr/local/bin/0conf'), true);
$arr = explode("\n",$listBlan);
$arr = array_filter($arr);
$data['listBlan'] = $arr;
$newJsonString = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents('/usr/local/bin/0conf', $newJsonString);

$data = json_decode(file_get_contents('/usr/local/bin/0conf'), true);
$arr = explode("\n",$listWlan);
$arr = array_filter($arr);
$data['listWlan'] = $arr;
$newJsonString = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents('/usr/local/bin/0conf', $newJsonString);

exec('sudo /usr/local/bin/ui-saveListBW');
exec('sudo systemctl restart iptables-proxy');

?>
<?php }?>