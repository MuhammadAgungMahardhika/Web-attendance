<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OutsourceCompany extends Model
{
    use HasFactory;

    protected $table = "outsource_company";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'main_company_id',
        'name',
        'contact',
        'address',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
    public function users()
    {
        return $this->hasMany(User::class, "outsource_company_id");
    }

    public function mainCompany()
    {
        return $this->belongsTo(MainCompany::class, "main_company_id");
    }
}
