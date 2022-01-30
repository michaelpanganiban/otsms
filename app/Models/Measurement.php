<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Measurement
 * 
 * @property int $measurement_id
 * @property int $user_id
 * @property int $custom_id
 * @property float|null $shoulder_length
 * @property float|null $sleeve_length
 * @property float|null $bust_chest
 * @property float|null $waist
 * @property float|null $skirt_length
 * @property float|null $slack_length
 * @property float|null $slack_front_rise
 * @property float|null $slack_fit_seat
 * @property float|null $slack_fit_thigh
 * @property int $created_by
 * @property Carbon $created_at
 * 
 * @property Customization $customization
 *
 * @package App\Models
 */
class Measurement extends Model
{
	protected $table = 'measurement';
	protected $primaryKey = 'measurement_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'custom_id' => 'int',
		'shoulder_length' => 'float',
		'sleeve_length' => 'float',
		'bust_chest' => 'float',
		'waist' => 'float',
		'skirt_length' => 'float',
		'slack_length' => 'float',
		'slack_front_rise' => 'float',
		'slack_fit_seat' => 'float',
		'slack_fit_thigh' => 'float',
		'created_by' => 'int'
	];

	protected $fillable = [
		'user_id',
		'custom_id',
		'shoulder_length',
		'sleeve_length',
		'bust_chest',
		'waist',
		'skirt_length',
		'slack_length',
		'slack_front_rise',
		'slack_fit_seat',
		'slack_fit_thigh',
		'created_by'
	];

	public function customization()
	{
		return $this->belongsTo(Customization::class, 'custom_id');
	}
}
