<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCompany extends Model
{
    use HasFactory;
    protected $table = 'main_company';
    protected $primaryKey = "id";
    protected $guarded = [];

    protected $fillable = [
        'id',
        'name',
        'contact',
        'status',
        'address',
        'location_radius',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->hasMany(User::class, "main_company_id");
    }
}
