<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Youtube;

class YoutubeController extends Controller
{
    // private $apiKey = env('youtube_apiKey');
    // private $playlistId = env('youtube_playlistId');
    private $apiKey = 'AIzaSyBk1z-xAVabyzCk4VJOCSDJh_i49MlMpPI';
    // private $playlistId = 'PLgohHfkVYNArdtwrYAw-F0QfHYe1u7IdU&si=cXp8QUBiDwZLOxYV';
    private $playlistId = 'PLnWyyZtBFGDVV3g7EQVjNlouzVZ9eSzcv';
    public function getPlaylists(Request $request, $playlistId = null)
    {
        $playlist = null;
        $lastestPlaylists = Youtube::where('status', 1)->latest()->first();
        if($lastestPlaylists == null){
            return response()->json([
                'message' => 'Playlist not found',
                'status' => 404
            ]);
        }
        if ($playlistId) {
            $playlist = Youtube::where('playlist_id', $playlistId)->where('status', 1)->first();
        } else {
            $playlist = Youtube::where('playlist_id', $lastestPlaylists->playlist_id)->where('status', 1)->first();
        }
        if (!$playlist) {
            return response()->json([
                'message' => 'Playlist not found',
                'status' => 404
            ]);
        }
        $playlistDetailsUrl = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&id={$playlist->playlist_id}&key={$this->apiKey}";
        $playlistDetails = $this->fetchData($playlistDetailsUrl);
        $playlist->details = $playlistDetails['items'][0] ?? null;
        // vedios
        $playlistItemsUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId={$playlist->playlist_id}&key={$this->apiKey}";
        $videos = $this->fetchAllVideos($playlistItemsUrl);
        $playlist->videos = $videos;
        $youtubeChannelLists = Youtube::where('status', 1)->latest()->get();
        $youtubeChannelLists->map(function($list){
            $words = explode(' ', $list->playlist_title); // Split the string into an array of words
            $firstTwoWords = implode(' ', array_slice($words, 0, 2)); // Take the first two words
            $list->stitle= $firstTwoWords;
        });
        return response()->json([
            'playlist' => $playlist,
            'lastestPlaylists' => $lastestPlaylists,
            'youtubeChannelLists' => $youtubeChannelLists,
            'status' => 200
        ]);
    }
    public function getPlaylist(Request $request)
    {
        if ($request->has('playlist_id')) {
            $this->playlistId = $request->playlist_id;
        }
        $playlistDetailsUrl = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&id={$this->playlistId}&key={$this->apiKey}";
        $playlistItemsUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId={$this->playlistId}&key={$this->apiKey}";
        $playlistDetails = $this->fetchData($playlistDetailsUrl);
        $videos = $this->fetchAllVideos($playlistItemsUrl);
        return response()->json([
            'playlist' => $playlistDetails['items'][0] ?? null,
            'videos' => $videos,
            'status' => 200
        ]);
    }
    public function videoDetail($videoId)
    {
        $videoDetailsUrl = "https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails,statistics&id={$videoId}&key={$this->apiKey}";
        $commentsUrl = "https://www.googleapis.com/youtube/v3/commentThreads?part=snippet&videoId={$videoId}&key={$this->apiKey}&maxResults=10";
        $videoDetails = $this->fetchData($videoDetailsUrl);
        $comments = $this->fetchData($commentsUrl);
        return ([
            'video' => $videoDetails['items'][0] ?? null,
            'comments' => $comments['items'] ?? []
        ]);
    }
    // get playlist videos
    public function getPlaylistVideos($playlistId)
    {
        $playlistItemsUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId={$playlistId}&key={$this->apiKey}";
        $videos = $this->fetchAllVideos($playlistItemsUrl);
        return response()->json([
            'videos' => $videos,
            'status' => 200
        ]);
    }
    private function fetchData($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
    private function fetchAllVideos($url)
    {
        $allVideos = [];
        do {
            $data = $this->fetchData($url);
            if (!isset($data['items'])) break;
            $allVideos = array_merge($allVideos, $data['items']);
            $url = isset($data['nextPageToken']) ? $url . '&pageToken=' . $data['nextPageToken'] : null;
        } while ($url);
        return $allVideos;
    }
}
