<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterCategory extends Model
{
    protected $table = 'master_categorys';

    protected $fillable = [
        'name',
    ];
}
