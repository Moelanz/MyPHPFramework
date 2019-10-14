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
     * @return mixed
     */
    public function deconvert($string)
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