<?

include "../../../login_check.php";
include "../../../config/config.php";
include "../_info_.php";
include "../../../functions.php";

include "options_config.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_POST['type'], "../../../msg.php", $regex_extra);
    regex_standard($_POST['action'], "../../../msg.php", $regex_extra);
	regex_standard($_POST['WindowsIntelx86_ip'], "../../../msg.php", $regex_extra);
	regex_standard($_POST['WindowsIntelx64_ip'], "../../../msg.php", $regex_extra);
	regex_standard($_POST['LinuxIntelx86_ip'], "../../../msg.php", $regex_extra);
	regex_standard($_POST['LinuxIntelx64_ip'], "../../../msg.php", $regex_extra);
	regex_standard($_POST['MachoIntelx86_ip'], "../../../msg.php", $regex_extra);
	regex_standard($_POST['MachoIntelx64_ip'], "../../../msg.php", $regex_extra);
	
}

$type = $_POST['type'];
$action = $_POST['action'];

$WindowsIntelx86_ip = $_POST['WindowsIntelx86_ip'];
$WindowsIntelx64_ip = $_POST['WindowsIntelx64_ip'];
/*
$LinuxIntelx86_ip = $_POST['LinuxIntelx86_ip'];
$LinuxIntelx64_ip = $_POST['LinuxIntelx64_ip'];
$MachoIntelx86_ip = $_POST['MachoIntelx86_ip'];
$MachoIntelx64_ip = $_POST['MachoIntelx64_ip'];
*/
$LinuxIntelx86_ip = "10.0.0.1";
$LinuxIntelx64_ip = "10.0.0.1";
$MachoIntelx86_ip = "10.0.0.1";
$MachoIntelx64_ip = "10.0.0.1";

// ngrep options
if ($type == "opt_$mod_name") {
    $exec = "/bin/sed -i 's/opt_LinuxIntelx86_ip.*/opt_LinuxIntelx86_ip = \\\"$LinuxIntelx86_ip\\\";/g' options_config.php";
    $output = exec_fruitywifi($exec);
	
    $exec = "/bin/sed -i 's/opt_LinuxIntelx64_ip.*/opt_LinuxIntelx64_ip = \\\"$LinuxIntelx64_ip\\\";/g' options_config.php";
    $output = exec_fruitywifi($exec);
	
    $exec = "/bin/sed -i 's/opt_WindowsIntelx86_ip.*/opt_WindowsIntelx86_ip = \\\"$WindowsIntelx86_ip\\\";/g' options_config.php";
    $output = exec_fruitywifi($exec);

    $exec = "/bin/sed -i 's/opt_WindowsIntelx64_ip.*/opt_WindowsIntelx64_ip = \\\"$WindowsIntelx64_ip\\\";/g' options_config.php";
    $output = exec_fruitywifi($exec);	

    $exec = "/bin/sed -i 's/opt_MachoIntelx86_ip.*/opt_MachoIntelx86_ip = \\\"$MachoIntelx86_ip\\\";/g' options_config.php";
    $output = exec_fruitywifi($exec);
	
    $exec = "/bin/sed -i 's/opt_MachoIntelx64_ip.*/opt_MachoIntelx64_ip = \\\"$MachoIntelx64_ip\\\";/g' options_config.php";
    $output = exec_fruitywifi($exec);
	
    header('Location: ../index.php?tab=1');
    exit;
}

header('Location: ../index.php');

?>