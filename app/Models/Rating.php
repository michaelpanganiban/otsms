<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rating
 * 
 * @property int $rating_id
 * @property int $user_id
 * @property int $product_id
 * @property int $rating
 * @property Carbon $created_at
 * 
 * @property ProductSale $product_sale
 * @property User $user
 *
 * @package App\Models
 */
class Rating extends Model
{
	protected $table = 'ratings';
	protected $primaryKey = 'rating_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'product_id' => 'int',
		'rating' => 'int'
	];

	protected $fillable = [
		'user_id',
		'product_id',
		'rating'
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
