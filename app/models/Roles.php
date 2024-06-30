<?php
namespace Models;

class Roles {
    const ADMIN = 'ADMIN';
    const USER = 'USER';

    private $value;

    public function __construct(string $value) {
        $this->value = $value;
    }

    public static function fromString(string $value): self {
        if (!in_array($value, [self::ADMIN, self::USER])) {
            throw new \InvalidArgumentException("Invalid role: $value");
        }
        return new self($value);
    }

    public function getValue(): string {
        return $this->value;
    }
}
