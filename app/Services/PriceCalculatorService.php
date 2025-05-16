<?php

namespace App\Services;

class PriceCalculatorService
{
    public static function calculate(?float $price): int
    {
        if (is_null($price)) {
            return 0;
        }

        if ($price >= 1 && $price <= 80) {
            return round($price * 25);
        } elseif ($price >= 81 && $price <= 160) {
            return round($price * 16);
        } elseif ($price >= 161 && $price <= 280) {
            return round($price * 10);
        } elseif ($price >= 281 && $price <= 370) {
            return round($price * 8);
        } elseif ($price >= 371 && $price <= 450) {
            return round($price * 7);
        } elseif ($price >= 451 && $price <= 750) {
            return round($price * 6);
        } elseif ($price >= 751 && $price <= 1900) {
            return round($price * 5);
        } elseif ($price >= 1901 && $price <= 7500) {
            return round($price * 4);
        } elseif ($price >= 7501 && $price <= 30000) {
            return round($price * 3.5);
        }

        return round($price); // Əgər heç bir aralığa düşməsə, olduğu kimi yuvarlaqla
    }
    public static function parsePrice(string|float|null $rawPrice): float
    {
        if (is_null($rawPrice)) {
            return 0;
        }

        if (is_float($rawPrice) || is_int($rawPrice)) {
            return (float) $rawPrice;
        }

        // "2.090,00 TL" -> "2090.00"
        $cleaned = preg_replace('/\s*TL$/u', '', $rawPrice);
        $cleaned = str_replace(['.', ','], ['', '.'], $cleaned);

        return (float) $cleaned;
    }
}
