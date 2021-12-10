<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inventory
 * 
 * @property int $item_id
 * @property string $item_name
 * @property string|null $description
 * @property float $price
 * @property int $quantity
 * @property string $status
 * @property int $created_by
 * @property Carbon $created_at
 * @property int $modified_by
 * @property Carbon|null $modified_at
 *
 * @package App\Models
 */
class Inventory extends Model
{
	protected $table = 'inventory';
	protected $primaryKey = 'item_id';
	public $timestamps = false;

	protected $casts = [
		'price' => 'float',
		'quantity' => 'int',
		'created_by' => 'int',
		'modified_by' => 'int'
	];

	protected $dates = [
		'modified_at'
	];

	protected $fillable = [
		'item_name',
		'description',
		'price',
		'quantity',
		'status',
		'created_by',
		'modified_by',
		'modified_at'
	];
}
