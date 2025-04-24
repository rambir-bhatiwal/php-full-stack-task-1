<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataHierarchy extends Model
{
    protected $fillable = ['name', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(DataHierarchy::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(DataHierarchy::class, 'parent_id');
    }
}
