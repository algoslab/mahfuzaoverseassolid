<?php

namespace App\Models\Supper_Admin\Payroll\Expense;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $fillable =
        [
            'account_type',
            'expense_category_name',
            'expense_category_code',
            'opening_balance',
            'opening_balance_sheet',
            'note',
            'status'
        ];
}
