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
use App\Model\Framework;
use App\Model\Language;
use App\Role;
use App\Team;
use Illuminate\Http\Request;
use Mockery\Exception;
use Ramsey\Uuid\Uuid;

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

        $requestContent = $request->getContent();

        //Trying to parse json data
        try {
            $jsonData = json_decode($requestContent, true)['app'];
        } catch (\Exception $exception) {
            return response()->json(['error' => 'failed to parse data'], 422);
        }

        //Checking permission to create app
        try {
            $teamId = $jsonData['team_id'];
            $roles = $request->user()->roles()->get();
            $isAdmin = false;
            foreach ($roles as $role) {
                if($role->name == Role::ROLE_ADMIN && $role->pivot->team_id == $teamId) {
                    $isAdmin = true;
                }
                if($role->name == Role::ROLE_SUPER_ADMIN) {
                    $isAdmin = true;
                }
            }

            if(!$isAdmin) {
                throw new \Exception();
            }

        } catch (\Exception $exception) {
            return response()->json(['error' => 'you are not in the team or are team admin'], 403);
        }

        //Trying to insert data
        try {
            $app = Application::create([
                'name' => $jsonData['name'],
                'description' => $jsonData['description'],
                'logo_url' => $jsonData['logo_url'],
                'language_id' => $jsonData['language_id'],
                'framework_id' => $jsonData['framework_id'],
                'team_id' => $jsonData['team_id']
            ]);
            $app->save();
        } catch (Exception $exception) {
            return response()->json(['error' => 'failed to insert data'], 422);
        }

        return response()->json(['app' => $app], 201);

    }

    function update(Request $request, $applicationId) {

        $requestContent = $request->getContent();

        //Trying to parse json data
        try {
            $jsonData = json_decode($requestContent, true)['app'];
        } catch (\Exception $exception) {
            return response()->json(['error' => 'failed to parse data'], 422);
        }

        //Checking permission to create app
        try {
            $teamId = $jsonData['team_id'];
            $roles = $request->user()->roles()->get();
            $isAdmin = false;
            foreach ($roles as $role) {
                if($role->name == Role::ROLE_ADMIN && $role->pivot->team_id == $teamId) {
                    $isAdmin = true;
                }
                if($role->name == Role::ROLE_SUPER_ADMIN) {
                    $isAdmin = true;
                }
            }

            if(!$isAdmin) {
                throw new \Exception();
            }

        } catch (\Exception $exception) {
            return response()->json(['error' => 'you are not in the team or are team admin'], 403);
        }

        try {
            $app = Application::findOrFail($applicationId);
            $app->name = $jsonData['name'];
            $app->description = $jsonData['description'];
            $app->logo_url = $jsonData['logo_url'];
            $app->language_id = $jsonData['language_id'];
            $app->framework_id = $jsonData['framework_id'];
            $app->team_id = $jsonData['team_id'];
            $app->save();
        } catch (\Exception $exception) {
            return response()->json(['error' => 'failed to update data', 'detail' => $exception], 422);
        }

        return response()->json(['app' => $app], 200);


    }

    function delete($appId) {

    }

}