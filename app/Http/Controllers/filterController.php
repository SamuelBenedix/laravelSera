<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class filterController extends Controller
{



    public function index()
    {
        $path = storage_path() . "/json/filter-data.json";
        $json = json_decode(file_get_contents($path), true);

        $data = $json['data']['response']['billdetails'];

        $newArray = [];

        foreach ($data as  $value) {
            preg_match_all('!\d+\.*\d*!', $value['body'][0], $matches);
            $denom = $matches[0][0];
            if ($denom >= 100000) {
                array_push($newArray, $matches[0][0]);
            }
        };

        return response()->json(
            $newArray
        );
    }
}
