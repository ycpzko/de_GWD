<?php require_once('../auth.php'); ?>
<?php if (isset($auth) && $auth) {?>
<?php
shell_exec('sudo rm -rf /etc/nginx/conf.d/forward0.conf');
shell_exec('sudo jq "del(.inbounds[1])" /usr/local/bin/vtrui/config.json >/tmp/vtrui_tmp && sudo mv -f /tmp/vtrui_tmp /usr/local/bin/vtrui/config.json');
shell_exec('sudo systemctl restart vtrui');

$data = json_decode(file_get_contents('/usr/local/bin/0conf'), true);
$data['FORWARD']['FWD0']['status'] = "off";
$newJsonString = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents('/usr/local/bin/0conf', $newJsonString);

$nginx = "/lib/systemd/system/nginx.service";
$docker = "/lib/systemd/system/docker.service";

if (file_exists($nginx)) {
    shell_exec('sudo systemctl reload nginx');
}
elseif (file_exists($docker)) {
    shell_exec('sudo docker container exec nginx nginx -s reload');
}
?>
<?php }?>
