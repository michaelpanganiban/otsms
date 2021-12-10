<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductSale
 * 
 * @property int $product_id
 * @property string $product_code
 * @property string $product_name
 * @property string|null $description
 * @property string $amount
 * @property string $quantity
 * @property string $image
 * @property string $status
 * @property string $type
 * @property int $create_by
 * @property Carbon $created_at
 * @property int|null $modified_by
 * @property Carbon|null $modified_at
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class ProductSale extends Model
{
	protected $table = 'product_sales';
	protected $primaryKey = 'product_id';
	public $timestamps = false;

	protected $casts = [
		'create_by' => 'int',
		'modified_by' => 'int'
	];

	protected $dates = [
		'modified_at'
	];

	protected $fillable = [
		'product_code',
		'product_name',
		'description',
		'amount',
		'quantity',
		'image',
		'status',
		'type',
		'create_by',
		'modified_by',
		'modified_at'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'modified_by');
	}
}
