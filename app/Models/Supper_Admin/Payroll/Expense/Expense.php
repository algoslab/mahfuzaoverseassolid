<?php

namespace App\Models\Supper_Admin\Payroll\Expense;

use App\Models\Supper_Admin\Location\Currency;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable =
        [
            'expense_category_id',
            'expense_item_id',
            'payment_method',
            'currency',
            'amount',
            'bdt_amount',
            'attachment',
            'month_year',
            'expiry_date',
            'transaction_note',
            'note'
        ];

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }
    public function expenseItem()
    {
        return $this->belongsTo(ExpenseItem::class);
    }
}
