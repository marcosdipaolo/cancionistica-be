<?php

namespace Cancionistica\ValueObjects;

use Illuminate\Support\Collection;

class ImageSize
{
    const THUMBNAIL = 'thumbnail';
    const FULL = 'full';

    private const SIZES = [
        self::THUMBNAIL => [
            "height" => 120,
            "width" => 150
        ],
        self::FULL => [
            "height" => 1080,
            "width" => 1920,
        ]
    ];

    private string $size;

    private function __construct(string $size)
    {
        $this->size = $size;
    }

    /**
     * @return Collection
     */
    public static function listAll(): Collection
    {
        return collect([
            self::thumbnail(),
            self::full(),
        ]);
    }

    /**
     * @return int
     */
    public function getImageHeight(): int
    {
        return self::SIZES[$this->getSize()]["height"];
    }

    /**
     * @return int
     */
    public function getImageWidth(): int
    {
        return self::SIZES[$this->getSize()]["width"];
    }

    /**
     * @return static
     */
    public static function thumbnail(): self
    {
        return new static(self::THUMBNAIL);
    }

    /**
     * @return static
     */
    public static function full(): self
    {
        return new static(self::FULL);
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param null $size
     * @return bool|string
     */
    public function is($size = null): bool|string
    {
        if (!$size) {
            return $this->size;
        }

        if (!is_array($size)) {
            $size = [$size];
        }

        return in_array($this->size, $size);
    }
}
