<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'is_active'];

    // Relationship: a category has many packages
    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
