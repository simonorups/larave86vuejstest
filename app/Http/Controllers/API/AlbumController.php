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
        $search     = "method=album.Search&album=".$name."&limit=1";
        $getSimilar = "method=album.getSimilar&album=".$name;
        $getTopTracks = "method=album.getTopTracks&album=".$name;
        $getTopAlbums = "method=album.getTopAlbums&album=".$name;

        //var_dump(self::LAST_FM_URL.$search, self::LAST_FM_URL.$getSimilar, self::LAST_FM_URL.$getTopTracks, self::LAST_FM_URL.$getTopAlbums);

        $album = $response = [];

        //execute concurrently for performance
        $poolResponse = Http::pool(fn (Pool $pool) => [
            $pool->get(self::LAST_FM_URL.$search),
            $pool->get(self::LAST_FM_URL.$getSimilar),
            $pool->get(self::LAST_FM_URL.$getTopTracks),
            $pool->get(self::LAST_FM_URL.$getTopAlbums),
        ]);

        $response[0] = $poolResponse[0]->json();
        $response[1] = $poolResponse[1]->json();
        $response[2] = $poolResponse[2]->json();
        $response[3] = $poolResponse[3]->json();

        $album['name'] = $response[0]['results']['albummatches']['album'][0]['name'];
        
        $similaralbums = $response[1]['similaralbums']['album'];
        foreach($similaralbums as $key=>$similaralbum){
            $album['similaralbums'][$key] = $similaralbum["name"];
        }
        sort($album['similaralbums']);

        $toptracks = $response[2]['toptracks']['track'];
        foreach($toptracks as $key=>$toptrack){
            $album['toptracks'][$key] = $toptrack["name"];
        }
        sort($album['toptracks']);

        $topalbums = $response[3]['topalbums']['album'];
        foreach($topalbums as $key=>$topalbum){
            $album['topalbums'][$key] = $topalbum["name"];
        }
        sort($album['topalbums']);

        return $album;

    }
}
