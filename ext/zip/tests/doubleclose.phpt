--TEST--
close() called twice
--EXTENSIONS--
zip
--FILE--
<?php

echo "Procedural\n";
$zip = zip_open(__DIR__ . '/test.zip');
if (!is_resource($zip)) {
    die("Failure");
}
var_dump(zip_close($zip));
try {
    var_dump(zip_close($zip));
} catch (TypeError $e) {
    echo $e->getMessage(), "\n";
}

echo "Object\n";
$zip = new ZipArchive();
if (!$zip->open(__DIR__ . '/test.zip')) {
    die('Failure');
}
if ($zip->status == ZIPARCHIVE::ER_OK) {
    var_dump($zip->close());
    try {
        $zip->close();
    } catch (ValueError $err) {
        echo $err->getMessage(), PHP_EOL;
    }
} else {
    die("Failure");
}

?>
Done
--EXPECTF--
Procedural

Deprecated: Function zip_open() is deprecated since 8.0, use ZipArchive::open() instead in %s on line %d

Deprecated: Function zip_close() is deprecated since 8.0, use ZipArchive::close() instead in %s on line %d
NULL

Deprecated: Function zip_close() is deprecated since 8.0, use ZipArchive::close() instead in %s on line %d
zip_close(): supplied resource is not a valid Zip Directory resource
Object
bool(true)
Invalid or uninitialized Zip object
Done
