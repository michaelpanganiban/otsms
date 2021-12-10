<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserType
 * 
 * @property int $id
 * @property string $user_type
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class UserType extends Model
{
	protected $table = 'user_type';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'user_type'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'user_type');
	}
}
