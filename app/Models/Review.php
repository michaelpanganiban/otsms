<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 * 
 * @property int $review_id
 * @property int $user_id
 * @property int $product_id
 * @property string $review
 * @property Carbon $created_at
 * 
 * @property ProductSale $product_sale
 * @property User $user
 *
 * @package App\Models
 */
class Review extends Model
{
	protected $table = 'review';
	protected $primaryKey = 'review_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'product_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'product_id',
		'review'
	];

	public function product_sale()
	{
		return $this->belongsTo(ProductSale::class, 'product_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
