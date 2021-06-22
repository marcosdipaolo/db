<?php

namespace MDP\DB\ValueObjects;

class QueryType
{
    const SELECT = 0;
    const UPDATE = 1;
    const INSERT = 2;
    const DELETE = 3;
    const RAW = 4;

    private function __construct(private int $type) {}

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return static
     */
    public static function select(): self
    {
        return new static(self::SELECT);
    }

    /**
     * @return static
     */
    public static function update(): self
    {
        return new static(self::UPDATE);
    }

    /**
     * @return static
     */
    public static function insert(): self
    {
        return new static(self::INSERT);
    }

    /**
     * @return static
     */
    public static function delete(): self
    {
        return new static(self::DELETE);
    }

    /**
     * @return static
     */
    public static function raw(): self
    {
        return new static(self::RAW);
    }

    /**
     * @param int|null $type
     * @return bool|string
     */
    public function is(int | null $type): bool | string
    {
        if ($type) {
            return $this->type === $type;
        }
        return $this->type;
    }
}