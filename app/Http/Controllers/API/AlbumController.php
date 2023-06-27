<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Album;
use Exception;
use Illuminate\Support\Facades\Http;

class AlbumController extends Controller
{
    private const LAST_FM_URL = 'http://ws.audioscrobbler.com/2.0/?api_key=b703f6c39ed526249165ee98d6e06f39&format=json&'; //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(auth()->user());
        $albums = Album::where('user_id', auth()->user()->id)->latest()->get();
        //dd($albums);
        return $albums;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->input('name'), $request->query('name'));
        /* dd(session("loggedInUser"));
        $loggedInUser = [];
        if ($request->session()->has('loggedInUser')) {
            $loggedInUser = session("loggedInUser");
        }

        dd(Auth::user(), $loggedInUser); */

        $album = new Album([
            'name' => $request->input('name'),
            'artist' => $request->input('artist'),
            'user_id' => auth()->user()->id,
        ]);
        $album->save();

        return response()->json('The album successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $album = Album::find($id);
        return response()->json($album);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $album = Album::find($id);
        $album->update($request->all());

        return response()->json('The album successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $album = Album::find($id);
        $album->delete();

        return response()->json('The album successfully deleted');
    }

    // edit album
    public function search($name, $artist)
    {
        try {
            $album = $response = [];

            $search  = "method=album.Search&album=" . $name;
            // var_dump(self::LAST_FM_URL.$search);
            $response = Http::get(self::LAST_FM_URL . $search)->json();

            $albummatches = $response['results']['albummatches']['album'];
            //var_dump($albummatches);
            $album['name'] = $name;
            $album['artist'] = $artist;

            foreach ($albummatches as $key => $albummatch) {
                //echo "\n".$albummatch['name']."--".$albummatch['artist']."::".$name."--".$artist." 88 ".(strtolower($albummatch['name']) == strtolower($name))."xx".(strtolower($albummatch['artist']) == strtolower($artist));
                if ((strtolower($albummatch['name']) == strtolower($name)) && (strtolower($albummatch['artist']) == strtolower($artist))) {
                    $album['name'] = $albummatch['name'];
                    $album['artist'] = $albummatch['artist'];
                }
            }

            $getInfo = "method=album.getInfo&album=" . $album['name'] . "&artist=" . $album['artist'];
            //var_dump(self::LAST_FM_URL . $getInfo);
            $response = Http::get(self::LAST_FM_URL . $getInfo)->json();

            //dd($response);
            //if there're no songs don't return it.
            //if ($response) {
                $tracks = $response['album']['tracks']['track'];
                if (is_array($tracks)) {
                    foreach ($tracks as $key => $track) {
                        $album['tracks'][$key]['name'] = $track["name"];
                        $album['tracks'][$key]['duration'] = $track["duration"] ?? "Unknown";
                    }
                    $release_date = $response['album']['wiki']['published'];
                    $album['release_date'] = $release_date;
                } else {
                    //dd("No tracks found");
                    $album['error'] = $response['message']."---No tracks found";
                    return response()->json($album);
                }
            //} else {
                //dd("No albums found");
                //$album['error'] = $response['message'];
                //return response()->json($album);
           // }

        } catch (Exception $ex) {
            //dd($ex);
            return response()->json($ex->getMessage());
        }

        return $album;
    }
}
