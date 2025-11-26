<?php
namespace Equipment\Model;

class Equipment
{
    private ?int $code = null;
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function exchangeArray($data)
    {
        $this->code = $data['code'] ?? 0;
        $this->name = $data['name'] ?? '';
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

}