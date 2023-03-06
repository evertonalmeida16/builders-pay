<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property double $original_amount
 * @property double $amount
 * @property string $due_date
 * @property string $payment_date
 * @property double $interest_amount_calculated
 * @property double $fine_amount_calculated
 *
 */

class BillPayment extends Model
{
    use HasFactory;

    protected $table = 'bill_payments';

    protected $fillable = [
        'original_amount',
        'amount',
        'due_date',
        'payment_date',
        'interest_amount_calculated',
        'fine_amount_calculated'
    ];
}
