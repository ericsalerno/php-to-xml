<?php
/**
 * Convert PHP to XML Test
 *
 * @package SalernoLabs
 * @subpackage Tests
 * @author Eric Salerno
 */
namespace SalernoLabs\Tests\PHPToXML;

class ConvertTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @param $input
     * @param $expectedOutput
     * @covers \SalernoLabs\PHPToXML\Convert::convert
     * @covers \SalernoLabs\PHPToXML\Convert::setObjectData
     * @throws \Exception
     * @dataProvider dataProviderForTestConversion
     */
    public function testConversion($input, $expectedOutput)
    {
        $converter = new \SalernoLabs\PHPToXML\Convert();

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
                json_decode(file_get_contents(__DIR__ . '/data/test' . $index . '/input.json')),
                file_get_contents(__DIR__ . '/data/test' . $index . '/output.xml')
            ];
            $output[] = $test;

            ++$index;
        }

        return $output;
    }

    /**
     * Because no one likes to be sold a false bill of goods.
     * @covers \SalernoLabs\PHPToXML\Convert::convert
     * @covers \SalernoLabs\PHPToXML\Convert::setObjectData
     */
    public function testReadmeSampleCode()
    {
        $object = new \stdClass();
        $object->hello = 'world';
        $object->items = ['one', 'two', 'three'];
        $object->samples = ['sample1'=>true, 'sample2'=>false, 'sample3'=>'I dunno!'];

        $converter = new \SalernoLabs\PHPToXML\Convert();
        $xml = $converter
            ->setObjectData($object)
            ->convert();

        $this->assertEquals(file_get_contents(__DIR__ . '/data/sample/expected.txt'), $xml);
    }

}