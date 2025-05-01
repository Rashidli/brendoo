<?php

namespace App\Http\Enums;

enum OrderStatus : string
{
    case Pending = 'pending'; // Ödəniş gözlənilir
    case Ordered = 'ordered'; // sifariş alındı
    case Prepared = 'prepared'; // hazırlanır
    case Boxed = 'boxed'; // paketləndi
    case CargoDepot = 'cargo_depot'; // karqo deposu
    case Delivered = 'delivered'; // təslim edildi
    case Returned = 'returned'; // iadə verildi
    case Courier = 'courier'; // kuryerə verildi
    case RefundChecking = 'refund_checking'; // iadə yoxlanılır
    case ReturnAccepted = 'return_accepted'; // iadə qəbul edildi
    case Cancelled = 'cancelled'; // ləğv edildi
//    case OutOFStock = 'out_of_stock'; // stokda yoxdur

    public static function label(string $value): string
    {
        return match ($value) {
            self::Pending->value => 'Ödəniş gözlənilir',
            self::Ordered->value => 'Sifariş verildi',
            self::Prepared->value => 'Hazırlanır',
            self::Boxed->value => 'Paketləndi',
            self::CargoDepot->value => 'Karqo deposundadır',
            self::Courier->value => 'Kuryerə verildi',
            self::Delivered->value => 'Təslim edildi',
            self::Returned->value => 'İadə verildi',
            self::RefundChecking->value => 'İadə yoxlanılır',
            self::ReturnAccepted->value => 'İadə qəbul edildi',
            self::Cancelled->value => 'Sifariş ləğv edildi',
            default => 'Naməlum status',
        };
    }

    public static function color(string $value): string
    {
        return match ($value) {
            self::Ordered->value => 'table-warning',
            self::Prepared->value => 'table-info',
            self::Boxed->value => 'table-primary',
            self::CargoDepot->value => 'table-secondary',
            self::Courier->value => 'table-primary',
            self::Delivered->value => 'table-success',
            self::Returned->value => 'table-danger',
            self::RefundChecking->value => 'table-warning',
            self::ReturnAccepted->value => 'table-success',
            self::Cancelled->value => 'table-danger',
            default => '',
        };
    }

    public static function progressSteps(): array
    {
        return [
            self::Ordered,
            self::Prepared,
            self::Boxed,
            self::CargoDepot,
            self::Courier,
            self::Delivered,
        ];
    }

    public function progressIndex(): int|null
    {
        return collect(self::progressSteps())->search(fn($status) => $status === $this);
    }

    public function isProgressable(): bool
    {
        return in_array($this, self::progressSteps());
    }
}
