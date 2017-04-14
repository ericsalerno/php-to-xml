<?php
/**
 * Convert a PHP Object to XML
 *
 * @package SalernoLabs
 * @subpackage PHPToXML
 * @author Eric
 */
namespace SalernoLabs\PHPToXML;

class Convert
{
    /**
     * You can change the tab character here, the tests were done in PHPStorm so the tab is 4 spaces per psr
     */
    const TAB_CHARACTER = '    ';

    /**
     * The XML version attribute
     */
    const XML_VERSION = '1.0';

    /**
     * The XML encoding attribute
     */
    const XML_ENCODING = 'utf-8';

    /**
     * @var mixed
     */
    private $data;

    /**
     * @var string
     */
    private $rootNode = 'data';

    /**
     * @var string
     */
    private $output;

    /**
     * @var string
     */
    private $currentNode;

    /**
     * Set the PHP object data
     *
     * @param $data
     * @return $this
     */
    public function setObjectData($data)
    {
        $this->data = $data;
        $this->output = null;

        return $this;
    }

    /**
     * Set the root node name
     *
     * @param $nodeName
     * @return $this
     */
    public function setRootNodeName($nodeName)
    {
        $this->rootNode = $nodeName;

        return $this;
    }

    /**
     * Perform the conversion
     *
     * @return string
     * @throws \Exception
     */
    public function convert()
    {
        //Cache result if you want to run it multiple times
        if (!empty($this->output))
        {
            return $this->output;
        }

        if (empty($this->data))
        {
            throw new \Exception("No data specified!");
        }

        $this->output = '<?xml version="' . static::XML_VERSION . '" encoding="' . static::XML_ENCODING . '"?>' . PHP_EOL;

        $this->convertNodeToXML($this->data, $this->rootNode, 0);

        $this->output = trim($this->output);

        return $this->output;
    }

    /**
     * Convert a specific node to XML (ugh! recursion!)
     *
     * @param $data
     * @param $nodeName
     * @param $depth
     */
    private function convertNodeToXML($data, $nodeName, $depth)
    {
        if (is_scalar($data))
        {
            //Treat it as a scalar, just add the node to the output
            $this->output .= str_repeat(static::TAB_CHARACTER, $depth);
            $this->output .= '<' . $nodeName . '>' . $data . '</' . $nodeName . '>' . PHP_EOL;

            return;
        }

        //Handle objects as arrays and arrays as arrays
        if (is_object($data))
        {
            //Sorry for the typecast
            $data = (array)$data;

            //We can assume an object is an associative array now
            $isAssociative = true;
        }
        else
        {
            //This is considered the "Fastest" way to figure out if an array is associative or not
            $isAssociative = ($data !== array_values($data));
        }


        if ($isAssociative)
        {
            //Associative array, treat each node as an element of the parent, indent each one
            $this->output .= str_repeat(static::TAB_CHARACTER, $depth);
            $this->output .= '<' . $nodeName . '>' . PHP_EOL;

            foreach ($data as $key => $value)
            {
                $this->convertNodeToXML($value, $key, $depth + 1);
            }

            $this->output .= str_repeat(static::TAB_CHARACTER, $depth);
            $this->output .= '</' . $nodeName . '>' . PHP_EOL;
        }
        else
        {
            //Integer indexed array (we hope), treat each node as a clone of the parent with no extra indent
            foreach ($data as $key => $value)
            {
                $this->convertNodeToXML($value, $nodeName, $depth);
            }
        }
    }

}