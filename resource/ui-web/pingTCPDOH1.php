<?php
putenv("dohNUM=1");
system('sudo /usr/local/bin/ui-pingTCPDOH $dohNUM');
die();
?>
