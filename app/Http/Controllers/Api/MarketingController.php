<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketingController extends Controller{


        public function createCampaignContact($campaign_id,Request $request){
            Auth::login(User::first());
            $request->validate([
                "campaign_id"=>"required|exists:campaigns,id",
                "name"=> "required",
                "mobile"=> "required",
                "custom_attributes"=> "nullable|array",
            ]);
            $campaign = Campaign::find($campaign_id);
            $contact = new Contact();
            $contact->name = $request->name;
            $contact->mobile = $request->mobile;
            $contact->contact_source_id = $campaign->contact_source_id;
            $contact->custom_attributes = $request->custom_attributes;
            $contact->campaign_id = $campaign_id;
            $contact->created_by = auth()->user()->id;
            $contact->activity_id = $campaign->activity_id;
            $contact->interest_id = $campaign->interest_id;
            $contact->save();
            Auth::logout();
            return response()->json(['success'=>true]);
        }
}
