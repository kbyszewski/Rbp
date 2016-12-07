<?php

$cmd = "";
switch ($_REQUEST['command']) {
    case "ping":
        $cmd = "ping -c 4 127.0.0.1";
        break;
    case "memory_status":
        $cmd = "free -m";
        break;
    default:
        echo "ERROR: unknown command";
}


ob_implicit_flush(true);					// turn off output buffering
ob_end_flush();

$descriptorspec = array(					// create an array for stdin std out 
   0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
   1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
   2 => array("pipe", "w")    // stderr is a pipe that the child will write to
);

if (!empty($cmd)) {
flush();
$process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());	// execute process
echo "<pre>";
if (is_resource($process)) {
    while ($s = fgets($pipes[1])) {
        print $s;
        flush();
    }
}
echo "</pre>";
}
?>
