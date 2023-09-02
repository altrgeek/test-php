<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Appointments\ClientProviderAppointment as CPA;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Packages\AgoraRTC\RtcTokenBuilder2 as TokenBuilder;

class MeetingController extends Controller
{
    /**
     * Generates a new session for specified meeting.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function session(Request $request): RedirectResponse|View
    {
        $request->validate([
            'token' => ['required', 'string', 'regex:/^[a-z0-9]+$/i'],
        ]);

        $user = $request->user();

        // Decrypt the passed token and unserialize its contents
        try {
            $payload = Crypt::decrypt($request->query('token'));

            if (
                !is_array($payload) ||
                !array_key_exists('meeting', $payload) ||
                !is_array(Arr::get($payload, 'meeting')) ||
                !array_key_exists('type', Arr::get($payload, 'meeting')) ||
                !is_string(Arr::get($payload, 'meeting.type')) ||
                !strlen(Arr::get($payload, 'meeting.type')) ||
                !array_key_exists('id', Arr::get($payload, 'meeting'))
            ) {
                throw new Exception('Invalid payload!');
            }
        } catch (DecryptException | Exception) {
            return redirect()->back()->with('message', 'Invalid session token provided!');
        }

        // Fetch the meeting record from database
        $meeting = Arr::get($payload, 'meeting.type')::query()
            ->where('uid', Arr::get($payload, 'meeting.id'))
            ->firstOrFail();

        $participants = $meeting
            ->getParticipants()
            ->map(function ($user) {
                $user->avatar = $user->avatar ? asset($user->avatar) : null;
                return $user;
            });

        if (!$participants->first(fn ($participant) => $participant->id == $user->id)) {
            return redirect()->back()->with('message', 'You are not allowed to join this session!');
        }

        $channel = hash('md5', sprintf('%s-%s', $meeting->uid, get_class($meeting)));

        return view('roles.shared.meeting.session', [
            '__session_config' => [
                'session' => [
                    'channel' => $channel,
                    'token' => TokenBuilder::buildTokenWithUid(
                        appId: config('cogni.meeting.cogni.agora.app_id'),
                        appCertificate: config('cogni.meeting.cogni.agora.certificate'),
                        channelName: $channel,
                        uid: $request->user()->id,
                        role: TokenBuilder::ROLE_PUBLISHER,
                        tokenExpire: $meeting->start->addSeconds($meeting->duration)->timestamp
                    ),
                    'title' => $meeting->title,
                    'guest' => $participants
                        ->first(fn ($participant) => $participant->id != $user->id)
                        ->only(['id', 'name', 'avatar']),
                    'link' => url()->full(),
                    'emotion' => [
                        'detect' => Arr::get($payload, 'meeting.type') === CPA::class && $user->isProvider(),
                        'api' => env('VITE_EMOTION_API_PATH')
                    ],
                ],
                'user' => $user->only(['id', 'name', 'email', 'avatar']),
                'agora' => [
                    'app_id' => config('cogni.meeting.cogni.agora.app_id')
                ]
            ]
        ]);
    }

    /**
     * Generates a new session for specified meeting.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required', 'string', 'regex:/^[a-z0-9]+$/i'],
            'email' => ['required', 'string', 'email', 'exists:users,email'],
        ]);

        try {
            $payload = Crypt::decrypt($request->input('token'));

            if (
                !is_array($payload) ||
                !array_key_exists('meeting', $payload) ||
                !is_array(Arr::get($payload, 'meeting')) ||
                !array_key_exists('type', Arr::get($payload, 'meeting')) ||
                !is_string(Arr::get($payload, 'meeting.type')) ||
                !strlen(Arr::get($payload, 'meeting.type')) ||
                !array_key_exists('id', Arr::get($payload, 'meeting'))
            ) {
                throw new Exception('Invalid payload!');
            }
        } catch (DecryptException | Exception) {
            return redirect()->back()->with('message', 'Invalid session token provided!');
        }

        $user = $request->user();

        if ($user->email !== $request->input('email')) {
            return redirect()->back()->with('message', 'You are not allowed to join this session!');
        }

        // Fetch the meeting record from database
        $meeting = Arr::get($payload, 'meeting.type')::query()
            ->where('uid', Arr::get($payload, 'meeting.id'))
            ->firstOrFail();

        $participants = $meeting->getParticipants();

        if (!$participants->first(fn ($participant) => $participant->id == $user->id)) {
            return redirect()->back()->with('message', 'You are not allowed to join this session!');
        }

        return redirect()->route('dashboard.session.join', ['token' => $request->input('token')]);
    }
}
