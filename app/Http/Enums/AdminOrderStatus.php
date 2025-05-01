<?php

namespace App\Http\Enums;

enum AdminOrderStatus : string
{
    case Pending = 'pending'; // ödəniş gözlənilir
    case AdminPaid = 'admin_paid'; // sifariş ödəndi
    case AdminOrdered = 'admin_ordered'; // sifariş verildi
    case TurkishOffice = 'turkish_office'; // türk ofisi
    case AdminBoxed = 'admin_boxed'; // qutulandı
    case RussianCargo = 'russian_cargo'; // rusiya karqosundadı
    case AdminDelivered = 'admin_delivered'; // təslim edildi
    case AdminReturned = 'admin_returned'; // iadə verildi
    case AdminCourier = 'admin_courier'; // kuryerə verildi
    case AdminRefundChecking = 'admin_refund_checking'; // iadə yoxlanılır
    case AdminReturnAccepted = 'admin_return_accepted'; // iadə qəbul edildi

    public static function label(string $value): string
    {
        return match ($value) {
            self::Pending->value => 'Ödəniş gözlənilir',
            self::AdminPaid->value => 'Ödəniş edildi.',
            self::AdminOrdered->value => 'Sifariş alındı',
            self::TurkishOffice->value => 'Türkiyə ofisindədir',
            self::AdminBoxed->value => 'Qutulandı',
            self::RussianCargo->value => 'Rusiya karqosundadır',
            self::AdminDelivered->value => 'Təslim edildi',
            self::AdminReturned->value => 'İadə verildi',
            self::AdminCourier->value => 'Kuryerə verildi',
            self::AdminRefundChecking->value => 'İadə yoxlanılır',
            self::AdminReturnAccepted->value => 'İadə qəbul edildi',
            default => 'Naməlum status',
        };
    }

    public static function color(string $value): string
    {
        return match ($value) {
            self::AdminPaid->value => 'table-success',
            self::AdminOrdered->value => 'table-info',
            self::TurkishOffice->value => 'table-warning',
            self::AdminBoxed->value => 'table-primary',
            self::RussianCargo->value => 'table-secondary',
            self::AdminDelivered->value => 'table-success',
            self::AdminReturned->value => 'table-danger',
            self::AdminCourier->value => 'table-primary',
            self::AdminRefundChecking->value => 'table-warning',
            self::AdminReturnAccepted->value => 'table-success',
            default => '',
        };
    }

    public static function progressSteps(): array
    {
        return [
            self::AdminPaid,
            self::AdminOrdered,
            self::TurkishOffice,
            self::AdminBoxed,
            self::RussianCargo,
            self::AdminCourier,
            self::AdminDelivered,
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
