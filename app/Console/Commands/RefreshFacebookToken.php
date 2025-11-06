<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RefreshFacebookToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facebook:refresh-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Facebook long-lived access token automatically';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->info('Starting Facebook token refresh process...');

            // Get current token from database
            $currentToken = DB::table('facebook_tokens')->where('id', 1)->first();

            if (!$currentToken) {
                $this->error('No existing token found in database!');
                Log::error('Facebook Token Refresh Failed: No existing token');
                return Command::FAILURE;
            }

            // Check if token needs refresh (less than 30 days remaining)
            $daysUntilExpiry = now()->diffInDays($currentToken->expires_at, false);
            
            $this->info("Current token expires in {$daysUntilExpiry} days");
            
            if ($daysUntilExpiry > 30) {
                $this->info('Token still valid for more than 30 days. No refresh needed.');
                return Command::SUCCESS;
            }

            $appId = config('services.facebook.app_id');
            $appSecret = config('services.facebook.app_secret');

            if (!$appId || !$appSecret) {
                $this->error('Facebook App ID or App Secret not configured!');
                Log::error('Facebook Token Refresh Failed: Missing credentials');
                return Command::FAILURE;
            }

            $this->info('Exchanging current token for new long-lived token...');

            // Exchange current token for new long-lived token
            $response = Http::timeout(30)->get('https://graph.facebook.com/v18.0/oauth/access_token', [
                'grant_type' => 'fb_exchange_token',
                'client_id' => $appId,
                'client_secret' => $appSecret,
                'fb_exchange_token' => $currentToken->access_token
            ]);

            if (!$response->successful()) {
                $errorMsg = 'Failed to refresh token: ' . $response->body();
                $this->error($errorMsg);
                Log::error('Facebook Token Refresh Failed', [
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);

                // Send alert notification (you can customize this)
                $this->sendAlertNotification($errorMsg);
                
                return Command::FAILURE;
            }

            $data = $response->json();
            $newToken = $data['access_token'];
            $expiresIn = $data['expires_in'] ?? 5184000; // 60 days default

            // Verify new token
            $tokenInfo = Http::get('https://graph.facebook.com/debug_token', [
                'input_token' => $newToken,
                'access_token' => $newToken
            ])->json();

            if (!($tokenInfo['data']['is_valid'] ?? false)) {
                $this->error('New token is invalid!');
                Log::error('Facebook Token Refresh Failed: New token invalid');
                return Command::FAILURE;
            }

            // Update database
            DB::table('facebook_tokens')->updateOrInsert(
                ['id' => 1],
                [
                    'access_token' => $newToken,
                    'expires_in' => $expiresIn,
                    'expires_at' => now()->addSeconds($expiresIn),
                    'token_type' => 'long_lived',
                    'last_refreshed_at' => now(),
                    'updated_at' => now()
                ]
            );

            $newExpiryDate = now()->addSeconds($expiresIn)->toDateTimeString();
            
            $this->info('✓ Token successfully refreshed!');
            $this->info("New token expires in: " . round($expiresIn / 86400) . " days");
            $this->info("Expiry date: {$newExpiryDate}");

            Log::info('Facebook Token Successfully Refreshed', [
                'expires_in_days' => round($expiresIn / 86400),
                'expires_at' => $newExpiryDate,
                'token_valid' => true
            ]);

            // Send success notification (optional)
            $this->sendSuccessNotification($expiresIn);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $errorMsg = 'Exception during token refresh: ' . $e->getMessage();
            $this->error($errorMsg);
            
            Log::error('Facebook Token Refresh Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->sendAlertNotification($errorMsg);

            return Command::FAILURE;
        }
    }

    /**
     * Send alert notification (customize based on your notification system)
     */
    private function sendAlertNotification($message)
    {
        // Option 1: Log to a dedicated alert channel
        Log::channel('slack')->critical('Facebook Token Refresh Failed', [
            'message' => $message,
            'time' => now()->toDateTimeString()
        ]);

        // Option 2: Send email to admin
        // Mail::to(config('mail.admin_email'))->send(new TokenRefreshFailed($message));

        // Option 3: Store in a notifications table
        DB::table('system_alerts')->insert([
            'type' => 'facebook_token_refresh_failed',
            'message' => $message,
            'severity' => 'critical',
            'created_at' => now()
        ]);
    }

    /**
     * Send success notification
     */
    private function sendSuccessNotification($expiresIn)
    {
        Log::info('Facebook Token Refresh Success Notification', [
            'expires_in_days' => round($expiresIn / 86400),
            'next_refresh' => now()->addDays(30)->toDateTimeString()
        ]);

        // Optional: Send success email or notification
    }
}