<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function fetchAllNotifications()
    {
        $user = User::find(auth()->user()->id);
        $notifications = $user->notifications()->where('read', false)->orderBy('created_at', 'desc')->get();
        $notifications = $notifications->merge($user->notifications()->where('read', true)->orderBy('created_at', 'desc')->get());
        $output = '';
        if ($notifications->isEmpty()) {
            return response()->json(['message' => 'No notifications found'], 404);
        }
        else{
            $output .= '<ul class="list-group">
                        <div class="d-flex justify-content-between align-items-center">
                            <a style="text-decoration: none;" href="#" class="text-info read-all-notifications">Read all</a>
                            <a style="text-decoration: none;" href="#" class="text-danger delete-all-notifications">Delete all</a>
                        </div>';
            foreach ($notifications as $notification){
                $output .= '<li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="user-profile-image">';
                if (User::find($notification->sender_id)->profile_image){
                    $output .= '<img class="img-fluid" style="max-width: 40px; max-height: 40px; border-radius: 10px;"
                    src="' . asset('storage/images/profile').'/' . User::find($notification->sender_id)->profile_image . '" alt="User Profile Image">';
                }
                else{
                    $output .= '<img src="'.asset('images/profile-placeholder.png').'"
                     alt="User Profile Image" class="img-fluid" style="max-width: 40px; max-height: 40px; border-radius: 10px;">';
                }

                $output .= '</div>
                <div class="ms-2 me-auto">
                    <div class="fw"><a style="text-decoration: none;" class="text-primary" href="'.route('users.show', User::find($notification->sender_id)).'">'.User::find($notification->sender_id)->name.'</a>';

                if($notification->type == 'follow'){
                    $output .= ' started following you';
                }
                else if($notification->type == 'like'){
                    $output .= ' liked your workout: <span style="font-weight: 500;">'.Notification::find($notification->id)->workout->title.'</span>';
                }
                else if($notification->type == 'join'){
                    $output .= ' joined your workout: <span style="font-weight: 500;">'.Notification::find($notification->id)->workout->title.'</span>';
                }
                else if($notification->type == 'leave'){
                    $output .= ' left your workout: <span style="font-weight: 500;">'.Notification::find($notification->id)->workout->title.'</span>';
                }
                else if($notification->type == 'comment'){
                    $output .= ' commented "'.Notification::find($notification->id)->comment->body.'" on your workout: <span style="font-weight: 500;">'.Notification::find($notification->id)->workout->title.'</span>';
                }

                $output .= '</div>
                    <small>'.$notification->created_at->diffForHumans().'</small>
                </div>';
                if (!$notification->read){
                    $output .= '<a href="#" id="'.$notification->id.'" class="text-primary mx-1 read-notification"><i class="bi-eye h5"></i></a>';
                }
                $output .= '<a href="#" id="'.$notification->id.'" class="text-danger mx-1 delete-notification"><i class="bi-trash h5"></i></a>
                </li>';
            }
            $output .= '</ul>';
        }
        return response()->json([
            'status' => 200,
            'html' => $output,
            'unreadNotificationsCount' => User::find(auth()->user()->id)->unreadNotifications()->count(),
        ]);
    }

    public function markAsRead(Request $request)
    {
        Notification::find($request->notificationId)->markAsRead();
        return response()->json([
            'status' => 200,
            'unreadNotificationsCount' => User::find(auth()->user()->id)->unreadNotifications()->count(),
        ]);
    }

    public function markAllAsRead()
    {
        $user = User::find(auth()->user()->id);
        foreach ($user->unreadNotifications as $notification){
            $notification->markAsRead();
        }
        return response()->json([
            'status' => 200,
            'unreadNotificationsCount' => User::find(auth()->user()->id)->unreadNotifications()->count(),
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

    public function deleteAll()
    {
        try{
            $user = User::find(auth()->user()->id);
            foreach ($user->notifications as $notification){
                $notification->delete();
            }
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
