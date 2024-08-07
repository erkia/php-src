--TEST--
Swap underlying object to call methods with xml_set_object() new object has missing methods
--EXTENSIONS--
xml
--FILE--
<?php

class A {
    public function start_element($parser, $name, $attributes) {
        global $b;
        echo "A::start_element($name)\n";
        try {
            xml_set_object($parser, $b);
        } catch (\Throwable $e) {
            echo $e::class, ': ', $e->getMessage(), PHP_EOL;
            exit();
        }
    }
    public function end_element($parser, $name) {
        echo "B::end_element($name)\n";
    }
}

class B {
    public function start_element($parser, $name) {
        echo "B::start_element($name)\n";
    }
}

$a = new A;
$b = new B;

$parser = xml_parser_create();
xml_set_object($parser, $a);
xml_set_element_handler($parser, "start_element", "end_element");
xml_parse($parser, <<<XML
<?xml version="1.0"?>
<container>
    <child/>
</container>
XML);

?>
--EXPECTF--
Deprecated: Function xml_set_object() is deprecated since 8.4, provide a proper method callable to xml_set_*_handler() functions in %s on line %d

Deprecated: xml_set_element_handler(): Passing non-callable strings is deprecated since 8.4 in %s on line %d
A::start_element(CONTAINER)

Deprecated: Function xml_set_object() is deprecated since 8.4, provide a proper method callable to xml_set_*_handler() functions in %s on line %d
ValueError: xml_set_object(): Argument #2 ($object) cannot safely swap to object of class B as method "end_element" does not exist, which was set via xml_set_element_handler()
