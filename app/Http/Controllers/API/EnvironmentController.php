<?php
/**
 * Created by PhpStorm.
 * User: thomasjezequel
 * Date: 03/02/2018
 * Time: 20:57
 */

namespace App\Http\Controllers\API;

use App\Model\Environment;
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;

class EnvironmentController extends Controller {

    public function create(Request $request) {

        $requestContent = $request->getContent();

        //Trying to parse json data
        try {
            $jsonData = json_decode($requestContent, true)['environment'];
        } catch (\Exception $exception) {
            return response()->json(['error' => 'failed to parse data'], 422);
        }

        if(!$request->user()->can('configureapp###'.$jsonData['app_id'])) {
            return response()->json(['error' => 'You are not authorized to modify this app'], 403);
        }

        try {
            $environment = Environment::create([
                "name" => $jsonData['name'],
                "app_id" => $jsonData['app_id']
            ]);
            $environment->save();

            return response()->json($environment, 201);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'failed to insert data'], 422);
        }

    }

}