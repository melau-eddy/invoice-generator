<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'invoice_id', 'quantity'];

    public function item(){
        return $this->belongsTo(Items::class, 'item_id', 'id');
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
}
