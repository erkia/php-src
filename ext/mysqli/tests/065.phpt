--TEST--
set character set
--EXTENSIONS--
mysqli
--SKIPIF--
<?php
require_once 'skipifconnectfailure.inc';
?>
--FILE--
<?php
    require_once 'connect.inc';

    $mysql = new my_mysqli($host, $user, $passwd, $db, $port, $socket);

    if (!mysqli_query($mysql, "SET sql_mode=''"))
        printf("[002] Cannot set SQL-Mode, [%d] %s\n", mysqli_errno($mysql), mysqli_error($mysql));

    $esc_str = chr(0xbf) . chr(0x5c);

    if ($mysql->set_charset("latin1")) {
        /* 5C should be escaped */
        if (3 !== ($tmp = strlen($mysql->real_escape_string($esc_str))))
            printf("[003] Expecting 3/int got %s/%s\n", gettype($tmp), $tmp);

        if ('latin1' !== ($tmp = $mysql->character_set_name()))
            printf("[004] Expecting latin1/string got %s/%s\n", gettype($tmp), $tmp);
    }

    if ($res = $mysql->query("SHOW CHARACTER SET LIKE 'gbk'")) {
        $res->free_result();
        if ($mysql->set_charset("gbk")) {
            /* nothing should be escaped, it's a valid gbk character */

            if (2 !== ($tmp = strlen($mysql->real_escape_string($esc_str))))
                    printf("[005] Expecting 2/int got %s/%s\n", gettype($tmp), $tmp);

            if ('gbk' !== ($tmp = $mysql->character_set_name()))
                    printf("[005] Expecting gbk/string got %s/%s\n", gettype($tmp), $tmp);
        }
    }
    $mysql->close();

    print "done!";
?>
--EXPECT--
done!
