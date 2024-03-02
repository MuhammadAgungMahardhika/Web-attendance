<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCompany extends Model
{
    use HasFactory;
    protected $table = 'main_company';
    protected $primaryKey = "id";

    protected $fillable = [
        'id',
        'name',
        'contact',
        'address',
        'location_radius',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
