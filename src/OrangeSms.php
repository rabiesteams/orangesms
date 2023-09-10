// src/OrangeSms.php

namespace OrangeSms;

use Illuminate\Support\Facades\Http;

class OrangeSms
{
    protected $apiUrl;
    protected $token;

    public function __construct($apiUrl, $token)
    {
        $this->apiUrl = $apiUrl;
        $this->token = $token;
    }

    public function sendSms($recipient, $message)
    {
        $response = Http::post(
            $this->apiUrl,
            [
                'outboundSMSMessageRequest' => [
                    'address' => "tel:+225{$recipient}",
                    'senderAddress' => "tel:+{{devPhoneNumber}}",
                    'outboundSMSTextMessage' => [
                        'message' => $message,
                    ],
                ],
            ],
            [
                'headers' => [
                    'Authorization' => 'Basic ' . $this->token,
                    'Accept' => 'application/json',
                ],
            ]
        );

        if ($response->successful()) {
            return "success";
        } else {
            $error = $response->json()['requestError']['serviceException']['variables'];
            return $error;
        }
    }
}
