<?php

declare(strict_types=1);

namespace MyVendor\Weekday\Resource\App;

use BEAR\Resource\ResourceObject;
use DateTimeImmutable;
use MyVendor\Weekday\Exception\InvalidDateTimeException;

class Weekday extends ResourceObject
{
    public function onGet(int $year, int $month, int $day): static
    {
        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d', "$year-$month-$day");
        if (! $dateTime instanceof DateTimeImmutable) {
            throw new InvalidDateTimeException("$year-$month-$day");
        }

        $weekday = $dateTime->format('D');
        $this->body = ['weekday' => $weekday];

        return $this;
    }

    public function tesInvalidDateTime(): void
    {
        $this->expectException(InvalidDateTimeException::class);
        $this->resource->get('app://self/weekday', ['year' => '-1', 'month' => '1', 'day' => '1']);
    }
}