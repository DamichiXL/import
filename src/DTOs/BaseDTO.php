<?php

namespace DamichiXL\Import\DTOs;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;

abstract readonly class BaseDTO implements Arrayable, ArrayAccess
{
    public function offsetExists(mixed $offset): bool
    {
        return property_exists($this, $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return property_exists($this, $offset) ? $this->{$offset} : null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            return;
        }
        if (! property_exists($this, $offset)) {
            return;
        }

        $this->{$offset} = $value;
    }

    public function offsetUnset(mixed $offset): void {}
}
