<?php
putenv("nodeNUM=1");
echo shell_exec('/usr/local/bin/ui-pingNODE $nodeNUM');
die();
?>