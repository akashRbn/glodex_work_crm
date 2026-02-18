<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Admin\Country;
use Illuminate\Http\Request;

class AgentHomeController extends Controller
{
    public function agentHomePage()
    {
        $countries = Country::where('status', 1)->orderBy('country_name', 'asc')->get();
        return view('agent.agent-home-page', compact('countries'));
    }
}
