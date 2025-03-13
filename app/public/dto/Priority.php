<?php

enum PriorityEnum: string
{
    case LOW = 'Low';
    case MEDIUM = 'Medium';
    case HIGH = 'High';

    public static function fromString(string $value): self
    {
        return match (strtolower($value)) {
            'low' => self::LOW,
            'medium' => self::MEDIUM,
            'high' => self::HIGH,
            default => throw new InvalidArgumentException('Invalid priority value'),
        };
    }
}
