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
     * @param $data
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

}