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
     * @var mixed
     */
    private $data;

    /**
     * @var string
     */
    private $rootNode = 'data';

    /**
     * Set the PHP object data
     *
     * @param $data
     * @return $this
     */
    public function setObjectData($data)
    {
        $this->data = $data;

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
        if (empty($this->data))
        {
            throw new \Exception("No data specified!");
        }

        $xmlHeader = '<?xml version="1.0" encoding="utf-8"?>';

        return '';
    }
}