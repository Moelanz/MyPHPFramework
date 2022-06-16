<?php namespace Moelanz\Serializer;

/**
 * Class YAML
 * @package Moelanz\Serializer
 *
 * @author Moelanz
 */
class YAML extends BaseFormat implements FormatNameInterface, FormatInterface
{
    /**
     * @return string
     */
    public function convert(): string
    {
        return $this->arrayToYAML($this->data, '');
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
        return 'YAML';
    }

    /**
     * @param $data
     * @param $node
     * @return mixed|string
     */
    private function arrayToYAML($data, $node)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $subNode = $key . ':' . "\n";
                $node .= $this->arrayToYAML($value, $subNode);
                continue;
            }

            $node .= $key . ': ' . $value . "\n";
        }

        return $node;
    }
}
