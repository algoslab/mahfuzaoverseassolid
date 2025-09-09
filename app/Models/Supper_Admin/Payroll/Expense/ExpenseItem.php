<?php

namespace App\Models\Supper_Admin\Payroll\Expense;

use Illuminate\Database\Eloquent\Model;

class ExpenseItem extends Model
{
    protected $fillable =
        [
            'expense_category_id',
            'expense_item_name',
            'note',
            'status'
        ];

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id', 'id');
    }
}
