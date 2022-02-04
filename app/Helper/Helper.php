<?php 
namespace App\Helper;
use Illuminate\Support\Facades\Auth;  
use App\Models\Notification;
class Helper
{
    public function addNotification($details, $type, $notif_read=0, $link, $user_id) {
        $data = array(
            'details' => $details,
            'type' => $type,
            'notif_read' => $notif_read,
            'link' => $link,
            'user_id' => $user_id,
        );
        Notification::create($data);
    }

    public function getNotification(){
        if(Auth::user()->user_type === 0){
            $notif = Notification::where('user_id', Auth::id())->get();
        }
        else {
            $notif = Notification::where(function ($query) {
                $query->where('type', 'Admin')->orWhere('type', 'Both');
            })->where('notif_read', 0)->get();
        }
        return $notif;
    }

    public function getUnreadNotification(){
        if(Auth::user()->user_type === 0){
            $notif = Notification::where('user_id', Auth::id())->where('notif_read', 0)->count();
        }
        else {
            $notif = Notification::where(function ($query) {
                $query->where('type', 'Admin')->orWhere('type', 'Both');
            })->where('notif_read', 0)->count();
        }
        return $notif;
    }

    public function setAsRead(){
        $id = request()->notif_id;
        Notification::find($id)->update(['notif_read' => 1]);
        return 1;
    }
}

?>