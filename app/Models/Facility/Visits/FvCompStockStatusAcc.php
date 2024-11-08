<?php

namespace App\Models\Facility\Visits;

use App\Models\Settings\StockItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvCompStockStatusAcc extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'stock_item_id',
        'c_reports_available',
        'chmis_qty_consumed',
        'chmis_days_out_of_stock',
        'chmis_Stock_on_hand',
        'csc_qty_consumed',
        'csc_days_out_of_stock',
        'csc_Stock_on_hand',
        'c_report_sc_agree',
    ];

    public function stkItem()
    {
        return $this->belongsTo(StockItem::class, 'stock_item_id', 'id');
    }
}
