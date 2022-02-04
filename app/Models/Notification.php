<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * 
 * @property int $notification_id
 * @property string $details
 * @property string $type
 * @property bool $notif_read
 * @property string $link
 * @property int $user_id
 * @property Carbon $created_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notification';
	protected $primaryKey = 'notification_id';
	public $timestamps = false;

	protected $casts = [
		'notif_read' => 'bool',
		'user_id' => 'int'
	];

	protected $fillable = [
		'details',
		'type',
		'notif_read',
		'link',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
