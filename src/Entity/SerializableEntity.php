<?php
declare(strict_types = 1);

namespace App\Entity;

interface SerializableEntity
{
    /**
     * return array representation of the object
     * 
     * @return mixed[]
     */
    public function toArray(): array;
}