<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BisnisUnit extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'bisnis_unit';
     protected $primaryKey = 'Bisnis_Unit_Id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Bisnis_Unit_Name',
    ];
}
