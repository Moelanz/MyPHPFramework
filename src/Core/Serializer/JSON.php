<?php
namespace App\Core\Serializer;

class JSON extends BaseFormat implements FormatNameInterface, FormatInterface, DeconvertInterface
{
    /**
     * @return string
     */
    public function convert(): string
    {
        return json_encode($this->data);
    }

    /**
     * @param $string
     * @return array
     */
    public function deconvert($string): array
    {
        return json_decode($string, true);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'JSON';
    }
}