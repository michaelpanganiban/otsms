<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Customization
 * 
 * @property int $custom_id
 * @property string $garment_type
 * @property string $details
 * @property int $user_id
 * @property string $status
 * @property Carbon $pickup_date
 * @property float $downpayment
 * @property float|null $fullpayment
 * @property string $proof_of_payment
 * @property Carbon $created_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Customization extends Model
{
	protected $table = 'customization';
	protected $primaryKey = 'custom_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'downpayment' => 'float',
		'fullpayment' => 'float',
		'pickup_date' => 'date:Y-m-d'
	];

	protected $dates = [
		'pickup_date'
	];

	protected $fillable = [
		'garment_type',
		'details',
		'user_id',
		'status',
		'pickup_date',
		'downpayment',
		'fullpayment',
		'proof_of_payment',
		'reference_id',
		'price'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
