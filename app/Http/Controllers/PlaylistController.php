<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render("Playlists/Index", [
            "playlists" => Auth::user()->playlists()->with([
                "songs" => function ($query) {
                    $query->orderBy("title");
                }
            ])->get(),
            "songs" => Song::all()->sortBy("title")->values()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Playlist::create([
            "Title" => $request->title,
            "user_id" => Auth::user()->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function show(Playlist $playlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Playlist $playlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::user()->id) {
            abort(403);
        }

        $playlist->update([
            "title" => $request->title
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::user()->id) {
            abort(403);
        }
        $playlist->songs()->detach();
        $playlist->delete();
    }

    public function addSong(Request $request, Playlist $playlist, Song $song)
    {
        if ($playlist->user_id !== Auth::user()->id) {
            abort(403);
        }

        $playlist->songs()->detach($song);
        $playlist->songs()->attach($song);
    }

    public function removeSong(Request $request, Playlist $playlist, Song $song)
    {
        if ($playlist->user_id !== Auth::user()->id) {
            abort(403);
        }

        $playlist->songs()->detach($song);
    }
}
