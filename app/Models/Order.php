<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 * @property int $order_id
 * @property int $product_id
 * @property string|null $reference_id
 * @property int $user_id
 * @property Carbon|null $pickup_date
 * @property float|null $downpayment_amount
 * @property string|null $receipt
 * @property Carbon|null $return_date
 * @property int|null $addtional_fee
 * @property string|null $status
 * @property int $created_by
 * @property Carbon $created_at
 * @property int|null $modified_by
 * @property Carbon|null $modified_at
 * 
 * @property User $user
 * @property ProductSale $product_sale
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'orders';
	protected $primaryKey = 'order_id';
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int',
		'user_id' => 'int',
		'downpayment_amount' => 'float',
		'addtional_fee' => 'int',
		'created_by' => 'int',
		'modified_by' => 'int',
		'pickup_date' => 'date:Y-m-d',
		'return_date' => 'date:Y-m-d',
	];

	protected $dates = [
		'pickup_date',
		'return_date',
		'modified_at'
	];

	protected $fillable = [
		'product_id',
		'reference_id',
		'user_id',
		'pickup_date',
		'downpayment_amount',
		'receipt',
		'return_date',
		'addtional_fee',
		'status',
		'created_by',
		'modified_by',
		'modified_at'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function product_sale()
	{
		return $this->belongsTo(ProductSale::class, 'product_id');
	}
}
