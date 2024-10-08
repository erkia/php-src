--TEST--
mysqlnd.net_read_timeout limit check
--EXTENSIONS--
mysqli
--SKIPIF--
<?php
require_once 'skipifconnectfailure.inc';
?>
--INI--
default_socket_timeout=60
max_execution_time=60
mysqlnd.net_read_timeout=1
--FILE--
<?php
    include 'connect.inc';

    if (!$link = my_mysqli_connect($host, $user, $passwd, $db, $port, $socket)) {
        printf("[001] Connect failed, [%d] %s\n", mysqli_connect_errno(), mysqli_connect_error());
    }

    if (false === mysqli_query($link, "SELECT SLEEP(5)"))
        printf("[002] [%d] %s\n",  mysqli_errno($link), mysqli_error($link));

    mysqli_close($link);

    print "done!";
?>
--EXPECT--
[002] [2006] MySQL server has gone away
done!
