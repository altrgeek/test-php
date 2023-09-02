<?php

namespace App\Http\Controllers\Roles\Provider;

use App\Http\Controllers\Controller;
use App\Models\Therapies\TherapiesData;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArchivesController extends Controller
{
    public function index(Request $request)
    {
        $provider = $request->user()->provider;

        $therapy_data=TherapiesData::with('provider','client')->where('provider_id',$provider->id)->get();

        return view('roles.provider.archives',compact('therapy_data'));
    }
    public function download_data_file(Request $request)
    {
        $provider = $request->user()->provider;
        $data_file=TherapiesData::select('data_file')->where(['provider_id'=>$provider->id, 'id'=>$request->id])->first();
if(isset($data_file) && $data_file != null)
        return response()->download(storage_path('app/public/'. $data_file->data_file));
else
return redirect()->back()->with('message','File not found try again later');
    }
}
