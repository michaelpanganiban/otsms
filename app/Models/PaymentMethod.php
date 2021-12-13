<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentMethod
 * 
 * @property int $method_id
 * @property string $method_name
 * @property string $bank_name
 * @property string $account_no
 * @property string $account_name
 *
 * @package App\Models
 */
class PaymentMethod extends Model
{
	protected $table = 'payment_methods';
	protected $primaryKey = 'method_id';
	public $timestamps = false;

	protected $fillable = [
		'method_name',
		'bank_name',
		'account_no',
		'account_name'
	];
}
