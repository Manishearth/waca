<?php
if (isset($_SERVER['REQUEST_METHOD'])) {
    die();
} // Web clients die.
ini_set('display_errors', 1);
require_once 'config.inc.php';

mysql_pconnect($toolserver_host, $toolserver_username, $toolserver_password);
@ mysql_select_db($toolserver_database) or die(mysql_error());
mysql_query("UPDATE acc_pend SET pend_ip = '127.0.0.1', pend_proxyip = NULL, pend_email = 'acc@toolserver.org', `pend_useragent` = '' WHERE pend_date < DATE_SUB(curdate(), interval " . $dataclear_interval . ");");
mysql_close();

echo "Deletion complete.";
?>
