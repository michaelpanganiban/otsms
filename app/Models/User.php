<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
/**
 * Class User
 * 
 * @property int $id
 * @property string $status
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property int $user_type
 * @property string $contact_no
 * @property Carbon|null $birthday
 * @property string $email
 * @property float|null $salary
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property bool $password_changed
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|ProductSale[] $product_sales
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	protected $table = 'users';

	protected $casts = [
		'user_type' => 'int',
		'salary' => 'float',
		'password_changed' => 'bool',
		'birthday' => 'date:Y-m-d'
	];

	protected $dates = [
		'birthday',
		'email_verified_at'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'status',
		'first_name',
		'middle_name',
		'last_name',
		'user_type',
		'contact_no',
		'birthday',
		'email',
		'salary',
		'email_verified_at',
		'password',
		'password_changed',
		'remember_token'
	];

	public function user_type()
	{
		return $this->belongsTo(UserType::class, 'user_type');
	}

	public function product_sales()
	{
		return $this->hasMany(ProductSale::class, 'modified_by');
	}
}
