<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Album;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class AlbumController extends Controller
{
    private const LAST_FM_URL = 'http://ws.audioscrobbler.com/2.0/?api_key=b703f6c39ed526249165ee98d6e06f39&format=json&';//

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
    public function search($name)
    {
        $album = $response = [];

        $search  = "method=album.Search&album=".$name."&limit=1";
        // var_dump(self::LAST_FM_URL.$search);
        $response = Http::get(self::LAST_FM_URL.$search)->json();
        $name     = $response['results']['albummatches']['album'][0]['name'];
        $artist   = $response['results']['albummatches']['album'][0]['artist'];

        $album['name'] = $name;
        $album['artist'] = $artist;

        $getInfo = "method=album.getInfo&album=".$name."&artist=".$artist;
        //var_dump(self::LAST_FM_URL.$getInfo);
        $response = Http::get(self::LAST_FM_URL.$getInfo)->json();
        
        $toptracks = $response['albums']['tracks']['track'];
        foreach($toptracks as $key=>$toptrack){
            $album['tracks'][$key]['name'] = $toptrack["name"];
            $album['tracks'][$key]['duration'] = $toptrack["duration"];
        }
        $published = $response['albums']['wiki']['published'];
        $album['published'] = $published;

        return $album;

    }
}
