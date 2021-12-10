<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeSchedule
 * 
 * @property int $schedule_id
 * @property int $user_id
 * @property string $day
 * @property Carbon|null $time_from
 * @property Carbon|null $time_to
 * @property bool|null $off_duty
 * @property int $create_by
 * @property Carbon $created_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class EmployeeSchedule extends Model
{
	protected $table = 'employee_schedule';
	protected $primaryKey = 'schedule_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'off_duty' => 'bool',
		'create_by' => 'int',
		'time_from' => 'date:H:m:s',
		'time_to' => 'date:H:m:s'
	];

	protected $dates = [
		'time_from',
		'time_to'
	];

	protected $fillable = [
		'user_id',
		'day',
		'time_from',
		'time_to',
		'off_duty',
		'create_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
