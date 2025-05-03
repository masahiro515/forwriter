<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GoogleCalendarSyncController extends Controller
{
    public function sync(Request $request)
    {
        Log::info('==== Google Calendar Sync called ====');

        $user = auth()->user();
        Log::info('Authenticated user:', ['user' => $user]);

        if (!$user || !$user->google_access_token || !$user->google_refresh_token) {
            return response()->json(['error' => '認証トークンが無効です。'], 400);
        }

        try {
            Log::info('Fetching Google Access Token...');
            $accessToken = $this->getGoogleAccessToken($user);
            Log::info('Access Token fetched: ' . $accessToken);

            $errors = [];
            foreach ($request->events as $event) {
                $eventData = [
                    'summary' => $event['title'],
                    'start' => [
                        'dateTime' => Carbon::parse($event['start'])->toRfc3339String(),
                        'timeZone' => 'Asia/Tokyo',
                    ],
                    'end' => [
                        'dateTime' => $event['end'] ? Carbon::parse($event['end'])->toRfc3339String() : Carbon::parse($event['start'])->addHour()->toRfc3339String(),
                        'timeZone' => 'Asia/Tokyo',
                    ],
                ];

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post('https://www.googleapis.com/calendar/v3/calendars/primary/events', $eventData);

                if (!$response->successful()) {
                    $errors[] = [
                        'event' => $event,
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ];
                    Log::error('Failed to sync event:', end($errors));
                } else {
                    Log::info('Synced event:', ['title' => $event['title']]);
                }
            }

            if (!empty($errors)) {
                return response()->json([
                    'error' => '一部のイベントの同期に失敗しました。',
                    'details' => $errors,
                ], 207); // 207: Multi-Status
            }

            return response()->json(['message' => 'すべてのイベントがGoogleカレンダーに同期されました。']);

        } catch (\Exception $e) {
            Log::error('Exception during sync:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'Googleカレンダーへの同期中にエラーが発生しました。'], 500);
        }
    }

    private function getGoogleAccessToken($user)
    {
        // もしトークンが有効期限内ならそのまま使う
        if (now()->lt($user->google_token_expires_in)) {
            return $user->google_access_token;
        }

        // 期限切れならリフレッシュ
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'refresh_token' => $user->google_refresh_token,
            'grant_type' => 'refresh_token',
        ]);

        if ($response->failed()) {
            throw new \Exception('Googleアクセストークンの更新に失敗しました: ' . $response->body());
        }

        $data = $response->json();
        $user->google_access_token = $data['access_token'];
        $user->google_token_expires_in = now()->addSeconds($data['expires_in']);
        $user->save();

        return $data['access_token'];
    }
}



