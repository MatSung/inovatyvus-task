<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TruckSubunit;

class Truck extends Model
{
    use HasFactory;

    protected $table = 'trucks';

    protected $fillable = [
        'unit',
        'year',
        'notes',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function TruckSubunits()
    {
        return $this->hasMany(Truck::class, 'main_truck_id', 'id');
    }

    public function TruckThatIsSubunitFor()
    {
        return $this->hasMany(Truck::class, 'subunit_id', 'id');
    }

    public static function getIdFromName(string $name): ?string
    {
        return self::query()->where('unit', $name)->value('id');
    }

    public static function getNameFromId(string $id): ?string
    {
        return self::query()->where('id', $id)->value('unit');
    }

    /**
     * Checks whether the truck is not subbing or being subbed on given date range.
     * 
     * @return bool
     */
    public static function isAvailableBetweenDates(string $start, string $end, string $id, ?string $exceptId = null): bool
    {
        return !(self::isSubbingBetweenDates($start, $end, $id, $exceptId) || self::isSubbedBetweenDates($start, $end, $id, $exceptId));
    }

    /**
     * Checks whether truck is a subunit in this time range.
     */
    public static function isSubbingBetweenDates(string $start, string $end, string $id, ?string $exceptId = null): bool
    {
        return TruckSubunit::query()->where('main_truck_id', '=', $id)
            ->where('id', '!=', $exceptId)
            ->where('end_date', '>=', $start)
            ->where('start_date', '<=', $end)
            ->exists();
    }

    /**
     * checks whether truck is being subbed in this time range.
     */
    public static function isSubbedBetweenDates(string $start, string $end, string $id, ?string $exceptId = null): bool
    {
        return TruckSubunit::query()->where('subunit_id', '=', $id)
            ->where('id', '!=', $exceptId)
            ->where('end_date', '>=', $start)
            ->where('start_date', '<=', $end)
            ->exists();
    }
}