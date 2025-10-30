<?php

namespace App\Http\Controllers;

use function auth;

class RouteClosureHandlerController extends Controller {

	//
	public function redirectToLogin()
	{
		return redirect('login');
	}

	public function markAsReadNotification()
	{
		auth()->user()->unreadNotifications->markAsRead();
	}

	public function allNotifications()
	{
		$all_notification = auth()->user()->notifications()->get();
		if(auth()->user()->role_users_id == 3)
		{
			return view('shared.client_all_notifications', compact('all_notification'));
		}
		return view('shared.all_notifications', compact('all_notification'));
	}

	public function clearAll()
	{
		auth()->user()->notifications()->delete();
		return redirect()->back();
	}


	public function help()
	{
		return view('help.index');
	}

	public function notificationsJson()
	{
		$notifications = auth()->user()->notifications()->take(10)->get()->map(function($notification) {
			return [
				'id' => $notification->id,
				'text' => $notification->data['data'] ?? '',
				'link' => $notification->data['link'] ?? '',
				'read_at' => $notification->read_at,
			];
		});
		$unreadCount = auth()->user()->unreadNotifications->count();
		return response()->json([
			'notifications' => $notifications,
			'unread_count' => $unreadCount
		]);
	}
}
