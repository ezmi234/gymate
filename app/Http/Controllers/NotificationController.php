<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function fetchAllNotifications()
    {
        $user = User::find(auth()->user()->id);
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();
        $output = '';
        if ($notifications->isEmpty()) {
            return response()->json(['message' => 'No notifications found'], 404);
        }
        else{
            $output .= '<ul class="list-group">';
            foreach ($notifications as $notification){
                $output .= '<li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold"><a href="'.route('users.show', User::find($notification->sender_id)).'">'.User::find($notification->sender_id)->name.'</a>';

                if($notification->type == 'follow'){
                    $output .= ' started following you';
                }
                else if($notification->type == 'like'){
                    $output .= ' liked your workout';
                }
                else if($notification->type == 'join'){
                    $output .= ' joined your workout';
                }
                else if($notification->type == 'leave'){
                    $output .= ' left your workout';
                }

                $output .= '</div>
                    <small>'.$notification->created_at->diffForHumans().'</small>
                </div>';
                if (!$notification->read){
                    $output .= '<a href="#" id="'.$notification->id.'" class="text-primary mx-1"><i class="bi-eye h4"></i></a>';
                }
                $output .= '<a href="#" id="'.$notification->id.'" class="text-danger mx-1 delete-notification"><i class="bi-trash h4"></i></a>
                </li>';
            }
            $output .= '</ul>';
        }
        return response()->json([
            'status' => 200,
            'html' => $output,
        ]);
    }

    public function markAsRead(Request $request)
    {
        $notification = Notification::find($request->id);
        $notification->read = true;
        $notification->save();
        return response()->json([
            'status' => 200,
        ]);
    }

    public function delete(Request $request)
    {
        try{
            Notification::destroy($request->notificationId);
        }
        catch (\Exception $e){
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ]);
        }
        return response()->json([
            'status' => 200,
            'unreadNotificationsCount' => User::find(auth()->user()->id)->unreadNotifications()->count(),
        ]);
    }
}
