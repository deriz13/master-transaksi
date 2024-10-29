<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterChart extends Model
{
    protected $table = 'master_charts';

    protected $fillable = [
        'code',
        'name',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(MasterCategory::class, 'category_id');
    }
}
