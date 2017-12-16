<?php
/**
 * Created by PhpStorm.
 * User: thomasjezequel
 * Date: 17/12/2017
 * Time: 00:27
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Model\Framework;
use Illuminate\Http\Request;

class FrameworkController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     * Lists all the framework availables in the application
     *
     */
    function list() {

        $frameworks = Framework::all();
        return response()->json($frameworks);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * Creates a new framework
     */
    function create(Request $request) {

        $requestContent = $request->getContent();

        try {
            $jsonContent = json_decode($requestContent, true)['framework'];
            $framework = Framework::create([
                'name' => $jsonContent['name'],
                'version' => $jsonContent['version'],
                'logo_url' => $jsonContent['logo_url']
            ]);
            return response()->json($framework, 201);
        } catch (\Exception $err) {
            return response()->json(['error'=> 'invalid_or_empty_data'], 400);
        }

    }


    /**
     * @param Request $request
     * @param $frameworkId
     *
     * Updates the framework with the requested Id
     * @return \Illuminate\Http\JsonResponse
     */
    function update(Request $request, $frameworkId) {
        $requestContent = $request->getContent();
        $framework = Framework::findOrFail($frameworkId);
        try {
            $jsonContent = json_decode($requestContent, true)['framework'];
            $framework->name = $jsonContent['name'];
            $framework->version = $jsonContent['version'];
            $framework->logo_url = $jsonContent['logo_url'];
            $framework->save();
            return response('', 200);
        } catch (\Exception $err) {
            return response()->json(['error'=> 'invalid_or_empty_data'], 400);
        }

    }

    function delete($frameworkId) {
        $framework = Framework::findOrFail($frameworkId);
        $framework->delete();
        return response('', 204);
    }

}