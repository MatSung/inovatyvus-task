<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Truck;

class TruckSubunit extends Model
{
    use HasFactory;

    protected $table = 'truck_subunits';

    protected $fillable = [
        'main_truck_id',
        'subunit_id',
        'start_date',
        'end_date',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $with = [
        'mainTruck',
        'subunit',
    ];

    public function mainTruck()
    {
        return $this->belongsTo(Truck::class, 'main_truck_id', 'id');
    }

    public function subunit()
    {
        return $this->belongsTo(Truck::class,'subunit_id', 'id');
    }
}
