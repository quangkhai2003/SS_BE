<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoginResource;
use Illuminate\Http\Request;
use App\Services\GuestService;


class GuestController extends Controller
{
    //
    protected $guestService;
    public function __construct(GuestService $guestService)
    {
        $this->guestService = $guestService;
    }
    public function loginGuest(Request $request)
    {
        $guestInfo = $this->guestService->Register();
        return LoginResource::make($guestInfo);
    }
    public function logoutGuest()
    {
        $logoutInfo = $this->guestService->logoutGuest();
        return $logoutInfo;
    }
    public function upgradeGuest(RegisterRequest $request)
    {
        $user = auth()->user();
        $userData = $this->guestService->upgradeGuestToUser($user, $request->validated());
        return new LoginResource($userData);
    }
}
