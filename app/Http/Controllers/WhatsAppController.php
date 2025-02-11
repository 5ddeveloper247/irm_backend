<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    public function sendMessage($to, $body)
    {
        $intanceId = env('ULTRAMSG_INSTANCE_ID') ?? 'default';
        // Define the parameters for the API request
        $params = [
            'token' => env('ULTRAMSG_API_TOKEN') ?? 'default',
            'to' => $to,
            'body' => $body
        ];

        // Make the POST request to UltraMsg API using Laravel's Http facade
        try {
            $response = Http::asForm()->post('https://api.ultramsg.com/'.$intanceId.'/messages/chat', $params);
            $statusCode = $response->status();

            if ($statusCode == 200) {
                // Check if there are any specific error responses in the API
                $responseData = $response->json();

                if (isset($responseData['error'])) {
                    // Handle specific error cases
                    switch ($responseData['error']) {
                        case 'exceeded_quota':
                            return response()->json(['error' => 'API limit exceeded. Please try again later.', 'response'=> $responseData], 400);
                        case 'invalid_token':
                            return response()->json(['error' => 'Invalid token provided. Please check your API token.', 'response'=> $responseData], 401);
                        case 'expired_instance':
                            return response()->json(['error' => 'Instance has expired. Please renew your instance.', 'response'=> $responseData], 410);
                        default:
                            return response()->json(['error' => 'An error occurred: ' . $responseData['error'], 'response'=> $responseData], 400);
                    }
                }

                return response()->json(['message' => 'Message sent successfully!', 'response'=> $responseData], 200);
            } else {
                // Handle HTTP error codes
                return $this->handleHttpError($statusCode);
            }
        } catch (\Exception $e) {
            // Log the exception and return a general error response
            Log::error('WhatsApp API error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. Please try again later.'], 500);
        }
    }

    /**
     * Handle HTTP error responses
     *
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleHttpError($statusCode)
    {
        switch ($statusCode) {
            case 400:
                return response()->json(['error' => 'Bad Request: The server could not understand the request. Please check your input and try again.'], 400);
            case 401:
                return response()->json(['error' => 'Unauthorized: Please check your API token and try again.'], 401);
            case 403:
                return response()->json(['error' => 'Forbidden: You do not have permission to access this resource.'], 403);
            case 404:
                return response()->json(['error' => 'Not Found: The requested resource could not be found. Please check the URL and try again.'], 404);
            case 500:
                return response()->json(['error' => 'Internal Server Error: Something went wrong on the server. Please try again later.'], 500);
            default:
                return response()->json(['error' => 'Unexpected error occurred. Please try again later.'], $statusCode);
        }
    }
}
