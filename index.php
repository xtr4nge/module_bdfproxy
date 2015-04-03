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
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>FruityWifi</title>
<script src="../js/jquery.js"></script>
<script src="../js/jquery-ui.js"></script>
<link rel="stylesheet" href="../css/jquery-ui.css" />
<link rel="stylesheet" href="../css/style.css" />
<link rel="stylesheet" href="../../../style.css" />

<script>
$(function() {
    $( "#action" ).tabs();
    $( "#result" ).tabs();
});

</script>

</head>
<body>

<? include "../menu.php"; ?>

<br>

<?
include "../../config/config.php";
include "../../login_check.php";
include "_info_.php";
include "../../functions.php";


// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_POST["newdata"], "msg.php", $regex_extra);
    regex_standard($_GET["logfile"], "msg.php", $regex_extra);
    regex_standard($_GET["action"], "msg.php", $regex_extra);
    regex_standard($_POST["service"], "msg.php", $regex_extra);
}

$newdata = $_POST['newdata'];
$logfile = $_GET["logfile"];
$action = $_GET["action"];
$tempname = $_GET["tempname"];
$service = $_POST["service"];


// DELETE LOG
if ($logfile != "" and $action == "delete") {
    $exec = "rm ".$mod_logs_history.$logfile.".log";
    exec_fruitywifi($exec);
}

// SET MODE
if ($_POST["change_mode"] == "1") {
    $ss_mode = $service;
    $exec = "/bin/sed -i 's/ss_mode.*/ss_mode = \\\"".$ss_mode."\\\";/g' includes/options_config.php";
    exec_fruitywifi($exec);
}

include "includes/options_config.php";

?>

<div class="rounded-top" align="left"> &nbsp; <b><?=$mod_alias?></b> </div>
<div class="rounded-bottom">

    &nbsp;&nbsp;version <?=$mod_version?><br>
    <?
    if (file_exists("$bin_mitmproxy")) { 
        echo "mitmproxy <font style='color:lime'>installed</font><br>";
    } else {
        echo "mitmproxy <a href='includes/module_action.php?install=install_$mod_name' style='color:red'>install</a><br>";
    } 
    ?>
    <?
    if (file_exists("$bin_bdfproxy")) { 
        echo "&nbsp;$mod_alias <font style='color:lime'>installed</font><br>";
    } else {
        echo "&nbsp;$mod_alias <a href='includes/module_action.php?install=install_$mod_name' style='color:red'>install</a><br>";
    } 
    ?>
    <?
    $exec = $mod_isup;
    $ismoduleup = exec_fruitywifi($exec);
    if ($ismoduleup[0] != "") {
        echo "&nbsp;$mod_alias  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"includes/module_action.php?service=$mod_name&action=stop&page=module\"><b>stop</b></a>";
    } else { 
        echo "&nbsp;$mod_alias  <font color=\"red\"><b>disabled</b></font>. | <a href=\"includes/module_action.php?service=$mod_name&action=start&page=module\"><b>start</b></a>"; 
    }
    ?>
    
</div>

<br>

<div id="msg" style="font-size:largest;">
Loading, please wait...
</div>

<div id="body" style="display:none;">

    <div id="result" class="module">
        <ul>
            <li><a href="#result-1">Output</a></li>
            <li><a href="#result-2">Config</a></li>
            <li><a href="#result-3">History</a></li>
            <li><a href="#result-4">About</a></li>
        </ul>
        <div id="result-1">
            <form id="formLogs-Refresh" name="formLogs-Refresh" method="POST" autocomplete="off" action="index.php">
            <input type="submit" value="refresh">
            <br><br>
            <?
                if ($logfile != "" and $action == "view") {
                    $filename = $mod_logs_history.$logfile.".log";
                } else {
                    $filename = $mod_logs;
                }
            
                $data = open_file($filename);
                
                // REVERSE
                //$data_array = explode("\n", $data);
                //$data = implode("\n",array_reverse($data_array));
                
            ?>
            <textarea id="output" class="module-content" style="font-family: courier;"><?=htmlspecialchars($data)?></textarea>
            <input type="hidden" name="type" value="logs">
            </form>
            
        </div>
        
        <!-- CONFIG -->
        
        <div id="result-2" >
            <form id="formInject" name="formInject" method="POST" autocomplete="off" action="includes/save.php">
            <input type="submit" value="save">
            <br><br>
            
            <div class="module-content" style="font-family: courier;" >
            
            <br><b> Metasploit Listener</b><br><br>
            <table>
                <!-- // OPTION WindowsIntelx86 --> 
                <tr>
                    <? $opt = "WindowsIntelx86_ip"; ?>
                    <td style="padding-right:10px" align="right">WindowsIntelx86 [LHOST]</td>
                    <td><input type="input" name="<?=$opt?>" value="<?=$opt_WindowsIntelx86_ip?>"> [LPORT] 6662</td>
                    <td nowrap></td>
                </tr>
                <!-- // OPTION WindowsIntelx64 --> 
                <tr>
                    <? $opt = "WindowsIntelx64_ip"; ?>
                    <td style="padding-right:10px" align="right">WindowsIntelx64 [LHOST]</td>
                    <td><input type="input" name="<?=$opt?>" value="<?=$opt_WindowsIntelx64_ip?>"> [LPORT] 6663</td>
                    <td nowrap></td>
                </tr>
				<!-- // OPTION LinuxIntelx86 --> 
                <!-- 
                <tr>
                    <? $opt = "LinuxIntelx86_ip"; ?>
                    <td style="padding-right:10px" align="right">LinuxIntelx86</td>
                    <td><input type="input" name="<?=$opt?>" value="<?=$opt_LinuxIntelx86_ip?>"></td>
                    <td nowrap></td>
                </tr>
                -->
				<!-- // OPTION LinuxIntelx64 --> 
                <!-- 
                <tr>
                    <? $opt = "LinuxIntelx64_ip"; ?>
                    <td style="padding-right:10px" align="right">LinuxIntelx64</td>
                    <td><input type="input" name="<?=$opt?>" value="<?=$opt_LinuxIntelx64_ip?>"></td>
                    <td nowrap></td>
                </tr>
                -->
                <!-- // OPTION MachoIntelx86 -->
                <!-- 
                <tr>
                    <? $opt = "MachoIntelx86_ip"; ?>
                    <td style="padding-right:10px" align="right">MachoIntelx86</td>
                    <td><input type="input" name="<?=$opt?>" value="<?=$opt_MachoIntelx86_ip?>"></td>
                    <td nowrap></td>
                </tr>
                -->
                <!-- // OPTION MachoIntelx64 -->
                <!--
                <tr>
                    <? $opt = "MachoIntelx64_ip"; ?>
                    <td style="padding-right:10px" align="right">MachoIntelx64</td>
                    <td><input type="input" name="<?=$opt?>" value="<?=$opt_MachoIntelx64_ip?>"></td>
                    <td nowrap></td>
                </tr>
                -->
            </table>
            </div>

            <input type="hidden" name="type" value="opt_<?=$mod_name?>">
            </form>
            
            <br>
            
        </div>

        <!-- HISTORY -->

        <div id="result-3" class="history">
            <input type="submit" value="refresh">
            <br><br>
            
            <?
            $logs = glob($mod_logs_history.'*.log');
            print_r($a);

            for ($i = 0; $i < count($logs); $i++) {
                $filename = str_replace(".log","",str_replace($mod_logs_history,"",$logs[$i]));
                echo "<a href='?logfile=".str_replace(".log","",str_replace($mod_logs_history,"",$logs[$i]))."&action=delete&tab=2'><b>x</b></a> ";
                echo $filename . " | ";
                echo "<a href='?logfile=".str_replace(".log","",str_replace($mod_logs_history,"",$logs[$i]))."&action=view'><b>view</b></a>";
                echo "<br>";
            }
            ?>
            
        </div>
        
        <!-- ABOUT -->

        <div id="result-4" class="history">
            <? include "includes/about.php"; ?>
        </div>
        
        <!-- END ABOUT -->
        
    </div>

    <div id="loading" class="ui-widget" style="width:100%;background-color:#000; padding-top:4px; padding-bottom:4px;color:#FFF">
        Loading...
    </div>

    <script>

    //$('#output').html('');
    $('#loading').show()
    
    $('#loading').hide();

    </script>

    <?
    if ($_GET["tab"] == 1) {
        echo "<script>";
        echo "$( '#result' ).tabs({ active: 1 });";
        echo "</script>";
    } else if ($_GET["tab"] == 2) {
        echo "<script>";
        echo "$( '#result' ).tabs({ active: 2 });";
        echo "</script>";
    } else if ($_GET["tab"] == 3) {
        echo "<script>";
        echo "$( '#result' ).tabs({ active: 3 });";
        echo "</script>";
    } else if ($_GET["tab"] == 4) {
        echo "<script>";
        echo "$( '#result' ).tabs({ active: 4 });";
        echo "</script>";
    } 
    ?>

</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#body').show();
    $('#msg').hide();
});
</script>

</body>
</html>
