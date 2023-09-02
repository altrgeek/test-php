<?php

namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Roles\Admin\ZoomMeetingController;

/**
 * trait ZoomMeetingTrait
 */
trait ZoomMeetingTrait
{
    public $client;
    public $jwt;
    public $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->jwt = $this->generateZoomToken();
        $this->headers = [
            'Authorization' => 'Bearer '.$this->jwt,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }
    public function generateZoomToken()
    {
        $key = config('zoom.keys.api_key');
        $secret = config('zoom.keys.api_secret_key');
        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];

        return \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');
    }

    private function retrieveZoomUrl()
    {
        return config('zoom.meeting_url');
    }

    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);

            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            $log = Log::error('ZoomJWT->toZoomTimeFormat : '.$e->getMessage());

            return $log;
        }
    }

    public function create($request)
    {
        $path = 'users/me/meetings';
        $url = $this->retrieveZoomUrl();

        $start_time = $request['start_date'].$request['start_time'];

        if (isset($request['admin_id'])) {

            $participant_video = $request['admin_id'];

        }elseif (isset($request['client_id'])) {

            $participant_video = $request['client_id'];

        }elseif (isset($request['provider_id'])) {

            $participant_video = $request['provider_id'];

        }elseif (isset($request['super_admin_id'])) {

            $participant_video = $request['super_admin_id'];
        }

        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([
                'topic'      => $request['title'],
                'type'       => ZoomMeetingController::MEETING_TYPE_SCHEDULE,
                'start_time' => $this->toZoomTimeFormat($start_time),
                'duration'   => '',
                'agenda'     => (! empty($request['description'])) ? $request['description'] : null,
                'timezone'     => config('app.timezone'),
                'settings'   => [
                    'host_video'        => ($request->user()->id) ? true : false,
                    'participant_video' => ($participant_video) ? true : false,
                    'waiting_room'      => true,
                ],
            ]),
        ];

        $response =  $this->client->post($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 201,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function update($id, $data)
    {
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([
                'topic'      => $data['topic'],
                'type'       => ZoomMeetingController::MEETING_TYPE_SCHEDULE,
                'start_time' => $this->toZoomTimeFormat($data['start_time']),
                'duration'   => $data['duration'],
                'agenda'     => (! empty($data['agenda'])) ? $data['agenda'] : null,
                'timezone'     => 'Asia/Pakistan',
                'settings'   => [
                    'host_video'        => ($data['host_video'] == "1") ? true : false,
                    'participant_video' => ($data['participant_video'] == "1") ? true : false,
                    'waiting_room'      => true,
                ],
            ]),
        ];
        $response =  $this->client->patch($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function get($id)
    {
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();
        $this->jwt = $this->generateZoomToken();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
        ];

        $response =  $this->client->get($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    /**
     * @param string $id
     *
     * @return bool[]
     */
    public function delete($id)
    {
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
        ];

        $response =  $this->client->delete($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
        ];
    }
}
