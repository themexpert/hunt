<?php

namespace Hunt\Repositories;

use Hunt\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingsRepository {

    public function updateSettings(Request $request) {
        $validator = Validator::make($request->all(), [
            "new_password" => "min:6",
            "old_password" => "min:6"
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }
        $user = auth()->user();
        if($request->new_password) {
            if(Hash::check($request->old_password, auth()->user()->password))
                $user->password = bcrypt($request->new_password);
            else
                return response()->json("Old password did not match", 422);
        }
        $settings = Setting::find(1);
        if($request->hasFile('favicon') && $request->file('favicon')->isValid()) {
            $favicon = $request->favicon;
            $filename = md5(time().str_random(15)).".".$favicon->extension();
            if($favicon->move(public_path('images'), $filename)) {
                @unlink(public_path().$settings->favicon);
                $settings->favicon = '/images/'.$filename;
            }
        }
        if($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $logo = $request->logo;
            $filename = md5(time().str_random(15)).".".$logo->extension();
            if($logo->move(public_path('images'), $filename)) {
                @unlink(public_path().$settings->logo);
                $settings->logo = '/images/'.$filename;
            }
        }
        if($request->title)
            $settings->title = $request->title;
        if($request->company)
            $settings->company = $request->company;
        if($request->copyright)
            $settings->copyright = $request->copyright;
        if($request->language)
            $settings->language = $request->language;
        if($request->name)
            $user->name = $request->name;
        $settings->save();
        $user->save();
        return response()->json([
            "favicon" => $settings->favicon,
            "logo" => $settings->logo,
            "title" => $settings->title,
            "company" => $settings->company,
            "copyright" => $settings->copyright,
            "message" => "Settings Updated"
        ], 200);
    }
}