<?php
namespace SalernoLabs\Tests\PHPToXML;

use PHPUnit\Framework\TestCase;
use SalernoLabs\PHPToXML\Convert;

/**
 * Convert PHP to XML Test
 *
 * @package SalernoLabs
 * @subpackage Tests
 * @author Eric Salerno
 */
class ConvertTest extends TestCase
{
    /**
     * @param $input
     * @param $expectedOutput
     * @throws \Exception
     * @dataProvider dataProviderForTestConversion
     */
    public function testConversion($input, $expectedOutput)
    {
        $converter = new Convert();

        $output = $converter
            ->setObjectData($input)
            ->convert();

        $this->assertEquals($expectedOutput, $output);
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function dataProviderForTestConversion()
    {
        $output = [];

        $index = 1;
        while (is_dir(__DIR__ . '/data/test' . $index))
        {
            $test = [
                unserialize(file_get_contents(__DIR__ . '/data/test' . $index . '/input.txt')),
                file_get_contents(__DIR__ . '/data/test' . $index . '/output.xml')
            ];
            $output[] = $test;

            ++$index;
        }

        return $output;
    }

    /**
     * Because no one likes to be sold a false bill of goods.
     * @throws \Exception But shouldn't here
     */
    public function testReadmeSampleCode()
    {
        $object = new \stdClass();
        $object->hello = 'world';
        $object->items = ['one', 'two', 'three'];
        $object->samples = ['sample1'=>true, 'sample2'=>false, 'sample3'=>'I dunno!'];

        $converter = new Convert();
        $xml = $converter
            ->setRootNodeName('garbage')
            ->setObjectData($object)
            ->convert();

        $expected = file_get_contents(__DIR__ . '/data/sample/expected.txt');
        $this->assertEquals($expected, $xml);

        // Run it again to cover our memoized value
        $this->assertEquals($expected, $converter->convert());
    }

    /**
     * @throws \Exception When theres empty data
     */
    public function testEmptyData()
    {
        $this->expectException(\Exception::class);
        $converter = new Convert();
        $converter
            ->convert();
    }
}
