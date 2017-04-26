<?php

namespace Hunt\Http\Controllers\Api;

use Hunt\Http\Controllers\Controller;
use Hunt\Repositories\SettingsRepository;
use Hunt\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private $settingsRepository;

    /**
     * Create a new settings controller instance.
     * @param SettingsRepository $settingsRepository
     */
    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->middleware(['auth:api', 'dev']);
        $this->settingsRepository = $settingsRepository;
    }

    /**
     * Show token settings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function token()
    {
        return view('settings.token');
    }

    public function getSettings() {
        $settings = Setting::find(1);
        return response()->json($settings, 200);
    }

    public function update(Request $request) {
        return $this->settingsRepository->updateSettings($request);
    }
}
