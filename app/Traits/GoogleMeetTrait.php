<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\ConferenceData;
use Google\Service\Calendar\CreateConferenceRequest;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventCreator;
use Google\Service\Calendar\EventOrganizer;
use Illuminate\Support\Str;

trait GoogleMeetTrait
{

    public $client;

    /**
     * This method will create a a new google client,
     *  before creating an event.
     *
     * @return String $client
     */
    public function getClient($request)
    {
        $client = new Client();

        $client->setApplicationName("Cognimeet");
        $client->setRedirectUri(config('app.url'));

        $client->setScopes(Calendar::CALENDAR);
        $client->setAuthConfig(base_path("secrets/oauth-credentials.json"));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        if (file_exists(base_path("secrets/oauth-token.json"))) {
            $accessToken = json_decode(file_get_contents(base_path("secrets/oauth-token.json")), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname(base_path("secrets/oauth-token.json")))) {
                touch(dirname(base_path("secrets/oauth-token.json")));
            }
            file_put_contents(base_path("secrets/oauth-token.json"), json_encode($client->getAccessToken()));
        }

        return $this->createMeeting($request, $client);
    }

    /**
     * This method will create an event with google meet link.
     *
     * @return Google\Service\Calendar\Event
     */
    public function createMeeting($request, $client)
    {

        $start = $request['start_date'].'T'.$request['start_time'].'Z';
        $end = $request['end_date'].'T'.$request['end_time'].'Z';

        $service = new Calendar($client);

        $event = new Event(array(
            'summary' => $request['title'],
            'location' => $request->user()->address,
            'description' => $request['description'],

            'start' => array(
                'dateTime' => $start,
                'timeZone' => config('app.timezone'),
            ),
            'end' => array(
                'dateTime' => $end,
                'timeZone' => config('app.timezone'),
            ),
        ));

        // creating new event in Google Calendar with the event array body
        $event = $service
            ->events
            ->insert("primary", $event);

        $conference = new ConferenceData();
        $conferenceRequest = new CreateConferenceRequest();
        // setting a random string unique id for the request
        $conferenceRequest->setRequestId(Str::orderedUuid());
        // creating new conference request with requestId
        $conference->setCreateRequest($conferenceRequest);
        // setting conference data to the event as an array
        $event->setConferenceData($conference);

        // updating the previously created event with the conference data
        $event = $service
            ->events
            ->patch("primary", $event->id, $event, ['conferenceDataVersion' => 1]);

        return $event;
    }
}
