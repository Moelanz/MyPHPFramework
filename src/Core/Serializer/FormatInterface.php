<?php
namespace App\Core\Serializer;

interface FormatInterface
{
    public function convert(): string;
    public function deconvert($string);
    public function setData(array $data): void;
}