<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'tax', 'discount', 'total_cost', 'advance', 'final_cost', 'due'];


    public function items()
    {
        return $this->hasManyThrough(Items::class, InvoiceItem::class, 'invoice_id', 'id');
    }

    public function invoice_items(){
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }
    public function company(){
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
