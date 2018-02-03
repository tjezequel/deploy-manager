<?php
/**
 * Created by PhpStorm.
 * User: thomasjezequel
 * Date: 02/02/2018
 * Time: 21:41
 */

namespace App\Http\Controllers\API;

use App\Model\Application;
use App\Role;
use App\Team;
use Illuminate\Http\Request;
use Symfony\Component\Debug\Debug;

class TeamController
{

    public function teams(Request $request) {
        $roles = $request->user()->roles()->get();
        $teams = collect();
        foreach ($roles as $role) {
            if ($role->name == Role::ROLE_SUPER_ADMIN) {
                return response()->json(Team::all(), 200);
            }
            else $teams[] = Team::findOrFail($role->pivot->team_id);
        }
        return response()->json(["Teams" => $teams], 200);
    }

    public function teamApps(Request $request) {
        $roles = $request->user()->roles()->get();
        $teams  = collect();
        foreach ($roles as $role) {
            if($role->name == Role::ROLE_SUPER_ADMIN) {
                $teams = Team::with('apps')->get();
                return response()->json($teams, 200);
            }
            $team = Team::findOrFail($role->pivot->team_id);
            if($role->name == Role::ROLE_ADMIN) {
                $apps = Application::where('team_id', $team->id)->get();
                $team->apps = $apps;
                $teams->push($team);
                continue;
            }
            $apps = collect();
            $teamApps = Application::where('team_id', $team->id)->get();
            foreach ($teamApps as $app) {
                if($request->user()->can('viewapp###'.$app->id)) {
                    $apps->push($app);
                }
            }
            $team->apps = $apps;
            $teams->push($team);
        }
        return response()->json(["teams" => $teams], 200);
    }

}