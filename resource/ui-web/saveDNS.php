<?php require_once('auth.php'); ?>
<?php if (isset($auth) && $auth) {?>
<?php
$DoH1 = $_GET['DoH1'];
$DoH2 = $_GET['DoH2'];
$dnsChina = $_GET['dnsChina'];

$hostsCustomize = $_GET['hostsCustomize'];
$hostsCustomize = str_replace("\t", ' ', $hostsCustomize);
$hostsCustomize = preg_replace("/\s(?=\s)/", "\\1", $hostsCustomize);
$hostsCustomize = str_replace(" ", ",", $hostsCustomize);
$arr = explode("\n",$hostsCustomize);
$arr = array_filter($arr);
foreach($arr as $k=>$v){
        $arr = explode(',',$v);
        $hosts[$arr[1]] = $arr[0];
}

$data = json_decode(file_get_contents('/usr/local/bin/0conf'), true);
$dnsChinaLine = str_replace(PHP_EOL, ' ', $dnsChina);
$data['dns']['china'] = $dnsChinaLine;
$newJsonString = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents('/usr/local/bin/0conf', $newJsonString);

$data = json_decode(file_get_contents('/usr/local/bin/0conf'), true);
$data['dns']['doh1'] = $DoH1;
$data['dns']['doh2'] = $DoH2;
$newJsonString = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents('/usr/local/bin/0conf', $newJsonString);

$data = json_decode(file_get_contents('/usr/local/bin/0conf'), true);
$data['dns']['hosts'] = array();
$data['dns']['hosts'] = $hosts;
$newJsonString = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents('/usr/local/bin/0conf', $newJsonString);

exec('sudo /usr/local/bin/ui-saveDNSChina');
exec('sudo systemctl restart smartdns');
exec('sudo systemctl restart doh-client');

$data = json_decode(file_get_contents('/usr/local/bin/0conf'), true);
if ( $data['DNSsplit'] === "gfw" ){
	exec('sudo /usr/local/bin/ui-dnsGFW');
} else {
	exec('sudo /usr/local/bin/ui-dnsCHNW');
}

exec('sudo /usr/local/bin/ui-saveListBW');
exec('sudo systemctl restart iptables-proxy');
exec('sudo systemctl restart v2dns');
?>
<?php }?>
