<?php
namespace App\Core\Serializer;

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
     * @return string
     */
    public function getName(): string
    {
        return 'YAML';
    }

    private function arrayToYAML($data, $node)
    {
        foreach ($data as $key => $value)
        {
            if(is_array($value))
            {
                $subNode = $key . ':' . "\n";
                $node .= $this->arrayToYAML($value, $subNode);
                continue;
            }

            $node .= $key . ': ' . $value . "\n";
        }

        return $node;
    }
}