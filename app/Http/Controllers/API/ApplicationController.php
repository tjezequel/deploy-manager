<?php
/**
 * Created by PhpStorm.
 * User: thomasjezequel
 * Date: 17/12/2017
 * Time: 13:20
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Application;
use App\Team;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{

    function list(Request $request) {
        $apps = collect();
        $roles = $request->user()->roles()->get();
        foreach($roles as $role) {
            if($role->name == 'superadmin') {
                $apps = Application::all();
                return response()->json(['apps' => $apps]);
            }
            if($role->name == 'admin'){
                $team = Team::findOrFail($role->pivot->team_id);
                $apps = $apps->merge($team->apps()->get());
            }
            if($role->name == 'user'){
                $permissions = $request->user()->allPermissions()->filter(function ($value, $key) {
                    return starts_with($value->name, 'viewapp###');
                });
                $appsId = str_replace('viewapp###', '', $permissions->pluck('name')->all());
                $apps = $apps->merge(Application::whereIn('id',$appsId)->where('team_id', $role->pivot->team_id)->get());
            }
        }
        return response()->json(['apps' => $apps], 200);
    }

    function create(Request $request) {
        
    }

    function update(Request $request, $appId) {

    }

    function delete($appId) {

    }

}