<?php
/**
 * Created by PhpStorm.
 * User: thomasjezequel
 * Date: 16/12/2017
 * Time: 22:40
 */

namespace App\Http\Controllers\API;


use App\Model\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LanguageController
{

    /**
     * @return \Illuminate\Http\JsonResponse
     * Lists all the languages availables in the application
     *
     */
    function list() {

        $languages = Language::all();
        return response()->json($languages);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * Creates a new language
     */
    function create(Request $request) {

        $requestContent = $request->getContent();
        try {
            $jsonContent = json_decode($requestContent, true)['language'];
            $language = Language::create([
                'name' => $jsonContent['name'],
                'version' => $jsonContent['version'],
                'logo_url' => $jsonContent['logo_url']
            ]);
            return response()->json($language, 201);
        } catch (\Exception $err) {
            return response()->json(['error'=> 'invalid_or_empty_data'], 400);
        }

    }


    /**
     * @param Request $request
     * @param $languageId
     *
     * Updates the language with the requested Id
     * @return \Illuminate\Http\JsonResponse
     */
    function update(Request $request, $languageId) {
        $requestContent = $request->getContent();
        $language = Language::findOrFail($languageId);

        try {
            $jsonContent = json_decode($requestContent, true)['language'];
            $language->name = $jsonContent['name'];
            $language->version = $jsonContent['version'];
            $language->logo_url = $jsonContent['logo_url'];
            $language->save();
            return response('', 200);
        } catch (\Exception $err) {
            return response()->json(['error'=> 'invalid_or_empty_data'], 400);
        }

    }

}