<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoneyFlow extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'money_flows';
    protected $guarded = [];

    public function category()
    {
        return $this->hasOne(Category::class,'id', 'category_id');
    }
}
