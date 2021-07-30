<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'table_id',
        'menu_id',
        'quantity',
        'status',
        'description',
        'waiter_id'
    ];

    // Relations
    public function client() : BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function table() : BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function menu() : BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function employee() : BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
