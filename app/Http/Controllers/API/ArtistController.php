<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artist;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Exception;

class ArtistController extends Controller
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
        $artists = Artist::where('user_id', auth()->user()->id)->latest()->get();
        //dd($artists);
        return $artists;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        //ensure no such record exists in the DB to avoid duplicates
        $name = $request->input('name');

        $artistExists = Artist::firstWhere("name", $name);

        if ($artistExists) {
            return response()->json('Artist already exists');
        } else {
            $artist = new Artist([
                'name' => $request->input('name'),
                'user_id' => auth()->user()->id,
            ]);
            $artist->save();
        }

        return response()->json('The artist successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artist = Artist::find($id);
        return response()->json($artist);
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
        $artist = Artist::find($id);
        $artist->update($request->all());

        return response()->json('The artist successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $artist = Artist::find($id);
        $artist->delete();

        return response()->json('The artist successfully deleted');
    }

    // edit artist
    public function search($name)
    {
        try {
            $search     = "method=artist.Search&artist=" . $name . "&limit=1";
            $getSimilar = "method=artist.getSimilar&artist=" . $name;
            $getTopTracks = "method=artist.getTopTracks&artist=" . $name;
            $getTopAlbums = "method=artist.getTopAlbums&artist=" . $name;

            //var_dump(self::LAST_FM_URL.$search, self::LAST_FM_URL.$getSimilar, self::LAST_FM_URL.$getTopTracks, self::LAST_FM_URL.$getTopAlbums);

            // $artist = $response = [];

            //execute concurrently for performance
            $poolResponse = Http::pool(fn (Pool $pool) => [
                $pool->get(self::LAST_FM_URL . $search),
                $pool->get(self::LAST_FM_URL . $getSimilar),
                $pool->get(self::LAST_FM_URL . $getTopTracks),
                $pool->get(self::LAST_FM_URL . $getTopAlbums),
            ]);

            $response[0] = $poolResponse[0]->json();
            $response[1] = $poolResponse[1]->json();
            $response[2] = $poolResponse[2]->json();
            $response[3] = $poolResponse[3]->json();

            $artist['name'] = $response[0]['results']['artistmatches']['artist'][0]['name'];

            $similarartists = $response[1]['similarartists']['artist'];
            foreach ($similarartists as $key => $similarartist) {
                $artist['similarartists'][$key] = $similarartist["name"];
            }
            sort($artist['similarartists']);

            $toptracks = $response[2]['toptracks']['track'];
            foreach ($toptracks as $key => $toptrack) {
                $artist['toptracks'][$key] = $toptrack["name"];
            }

            $topalbums = $response[3]['topalbums']['album'];
            foreach ($topalbums as $key => $topalbum) {
                $artist['topalbums'][$key] = $topalbum["name"];
            }
        } catch (Exception $ex) {
            //$album = "could not get match";//.$ex->getMessage();
            return $ex;
        }

        return $artist;
    }
}
