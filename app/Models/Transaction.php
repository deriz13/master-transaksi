<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'date',
        'master_charts_id',
        'desc',
        'debit',
        'credit'
    ];

    public function masterChart()
{
    return $this->belongsTo(MasterChart::class, 'master_charts_id');
}
}
