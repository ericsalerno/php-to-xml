# php-to-xml

Just a simple class that converts a PHP object to XML, with tests, and no SimpleXML requirement.

Yes, I'm fully aware of the existence of [SimpleXMLElement::asXML()](http://php.net/manual/en/simplexmlelement.asxml.php) and solutions that use it.

## Usage

First include the package in your project.

    composer require salernolabs/php-to-xml

An example usage would be something like this:

    $object = new \stdClass();
    $object->hello = 'world';
    $object->items = ['one', 'two', 'three'];
    $object->samples = ['sample1'=>true, 'sample2'=>false, 'sample3'=>'I dunno!'];

    $converter = new \SalernoLabs\PHPToXML\Convert();
    $xml = $converter
        ->setObjectData($object)
        ->convert();


At this point, the value of $xml is expected to be a string with the following contents:

    <?xml version="1.0" encoding="utf-8"?>
    <data>
        <hello>world</hello>
        <items>one</items>
        <items>two</items>
        <items>three</items>
        <samples>
            <sample1>1</sample1>
            <sample2></sample2>
            <sample3>I dunno!</sample3>
        </samples>
    </data>

## Limitations

I haven't added attribute or CDATA support in yet. It also doesn't collapse/remove empty nodes. Maybe later?