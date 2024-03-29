<?php namespace Moelanz\Serializer;

use DOMDocument;
use SimpleXMLElement;

/**
 * Class XML
 * @package Moelanz\Serializer
 *
 * @author Moelanz
 */
class XML extends BaseFormat implements FormatNameInterface, FormatInterface
{
    /**
     * @return string
     */
    public function convert(): string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><object/>');
        $this->arrayToXML($this->data, $xml);

        //DOMDocument to format code output
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());

        return $dom->saveXML();
    }

    /**
     * @param $string
     * @return mixed|void
     */
    public function deconvert($string)
    {
        // TODO: Implement deconvert() method.
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'XML';
    }

    /**
     * @param array $data
     * @param $node
     */
    private function arrayToXML(array $data, $node)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $subNode = $node->addChild(str_replace(' ','_', $key));
                $this->arrayToXML($value, $subNode);

                continue;
            }

            $node->addChild(str_replace(' ','_', $key), trim($value));
        }
    }
}
