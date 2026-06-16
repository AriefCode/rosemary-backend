<?php

namespace App\Http\Controllers;

use App\Models\StockNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = StockNotification::with('sayur')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead(StockNotification $notification)
    {
        $notification->update(['read_at' => now()]);

        return response()->json($notification->fresh('sayur'));
    }

    public function markAllAsRead()
    {
        StockNotification::whereNull('read_at')->update(['read_at' => now()]);

        return response()->json(['message' => 'Semua notifikasi ditandai dibaca.']);
    }
}
