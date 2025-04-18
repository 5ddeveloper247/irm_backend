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
    // public function getPlaylists(Request $request, $playlistId = null)
    // {
    //     $playlist = null;
    //     $lastestPlaylists = Youtube::where('status', 1)->latest()->first();
    //     if ($lastestPlaylists == null) {
    //         return response()->json([
    //             'message' => 'Playlist not found',
    //             'status' => 404
    //         ]);
    //     }
    //     if ($playlistId) {
    //         $playlist = Youtube::where('playlist_id', $playlistId)->where('status', 1)->first();
    //     } else {
    //         $playlist = Youtube::where('playlist_id', $lastestPlaylists->playlist_id)->where('status', 1)->first();
    //     }
    //     if (!$playlist) {
    //         return response()->json([
    //             'message' => 'Playlist not found',
    //             'status' => 404
    //         ]);
    //     }
    //     $playlistDetailsUrl = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&id={$playlist->playlist_id}&key={$this->apiKey}";
    //     $playlistDetails = $this->fetchData($playlistDetailsUrl);
    //     $playlist->details = $playlistDetails['items'][0] ?? null;
    //     // vedios
    //     $playlistItemsUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId={$playlist->playlist_id}&key={$this->apiKey}";
    //     $videos = $this->fetchAllVideos($playlistItemsUrl);
    //     $playlist->videos = $videos;
    //     $youtubeChannelLists = Youtube::where('status', 1)->latest()->get();
    //     $youtubeChannelLists->map(function ($list) {
    //         $words = explode(' ', $list->playlist_title); // Split the string into an array of words
    //         $firstTwoWords = implode(' ', array_slice($words, 0, 2)); // Take the first two words
    //         $list->stitle = $firstTwoWords;
    //     });
    //     return response()->json([
    //         'playlist' => $playlist,
    //         'lastestPlaylists' => $lastestPlaylists,
    //         'youtubeChannelLists' => $youtubeChannelLists,
    //         'status' => 200
    //     ]);
    // }

    public function getPlaylists(Request $request, $playlistId = null)
    {
        // Get latest playlist or use requested one
        $latestPlaylist = Youtube::where('status', 1)->latest()->first();
        if (!$latestPlaylist) {
            return response()->json(['message' => 'Playlist not found', 'status' => 404]);
        }

        // Select playlist based on ID or fallback to latest
        $playlist = null;
        if ($playlistId) {
            $playlist = Youtube::where('playlist_id', $playlistId)->where('status', 1)->first();
            // Handle API playlists not in database
            if (!$playlist) {
                $parentChannel = Youtube::where('status', 1)->first();
                if ($parentChannel) {
                    $playlist = clone $parentChannel;
                    $playlist->playlist_id = $playlistId;
                }
            }
        } else {
            $playlist = $latestPlaylist;
        }

        if (!$playlist) {
            return response()->json(['message' => 'Playlist not found', 'status' => 404]);
        }

        // Initialize collections and determine if we're dealing with a channel
        $databaseChannels = Youtube::where('status', 1)->latest()->get();
        $youtubeChannelLists = collect([]);
        $isChannelId = strpos($playlist->playlist_id, 'UC') === 0;
        $selectedPlaylistId = $playlistId ?: $playlist->playlist_id;

        if ($isChannelId) {
            // CHANNEL HANDLING
            $channelId = $playlist->playlist_id;

            // Get channel details
            $channelUrl = "https://www.googleapis.com/youtube/v3/channels?part=snippet&id={$channelId}&key={$this->apiKey}";
            $channelDetails = $this->fetchData($channelUrl);
            $playlist->details = $channelDetails['items'][0] ?? null;

            // Get all playlists from this channel
            $channelPlaylistsUrl = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&channelId={$channelId}&maxResults=50&key={$this->apiKey}";
            $channelPlaylistsData = $this->fetchData($channelPlaylistsUrl);
            $filteredPlaylists = collect($channelPlaylistsData['items'] ?? [])
                ->filter(function ($item) {
                    return isset($item['id']) && strpos($item['id'], 'PL') === 0;
                })
                ->values()
                ->all();

            // Build sidebar channel list
            foreach ($databaseChannels as $dbChannel) {
                if ($dbChannel->playlist_id == $channelId) {
                    // Add channel to sidebar
                    $channelItem = clone $dbChannel;
                    $channelItem->api_title = $channelDetails['items'][0]['snippet']['title'] ?? $dbChannel->playlist_title;
                    $channelItem->is_channel = true;
                    $youtubeChannelLists->push($channelItem);

                    // Add all playlists from this channel to sidebar
                    foreach ($filteredPlaylists as $pl) {
                        $playlistItem = new \stdClass();
                        $playlistItem->id = $dbChannel->id;
                        $playlistItem->playlist_id = $pl['id'];
                        $playlistItem->playlist_title = $pl['snippet']['title'];
                        $playlistItem->api_title = $pl['snippet']['title'];
                        $playlistItem->is_playlist = true;
                        $playlistItem->parent_channel_id = $channelId;
                        $youtubeChannelLists->push($playlistItem);
                    }
                } else {
                    // Add other channels
                    $channelItem = clone $dbChannel;
                    $channelItem->is_channel = true;
                    $youtubeChannelLists->push($channelItem);
                }
            }

            // Set playlist data
            $playlist->playlist_list = $filteredPlaylists;

            // Determine which playlist videos to show
            $targetPlaylistId = null;
            $targetPlaylistTitle = '';

            if ($playlistId && strpos($playlistId, 'PL') === 0) {
                // Show selected playlist
                $targetPlaylistId = $playlistId;
                foreach ($filteredPlaylists as $pl) {
                    if ($pl['id'] == $targetPlaylistId) {
                        $targetPlaylistTitle = $pl['snippet']['title'] ?? '';
                        break;
                    }
                }
            } elseif (!empty($filteredPlaylists)) {
                // Show first playlist as default
                $targetPlaylistId = $filteredPlaylists[0]['id'];
                $targetPlaylistTitle = $filteredPlaylists[0]['snippet']['title'] ?? '';
            }

            // Get videos for target playlist
            if ($targetPlaylistId) {
                $playlistItemsUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId={$targetPlaylistId}&key={$this->apiKey}";
                $playlist->videos = $this->fetchAllVideos($playlistItemsUrl);
                $playlist->selected_playlist_title = $targetPlaylistTitle;
                $playlist->selected_playlist_id = $targetPlaylistId;
            } else {
                $playlist->videos = [];
                $playlist->selected_playlist_title = '';
                $playlist->selected_playlist_id = '';
            }
        } else {
            // REGULAR PLAYLIST HANDLING
            $currentPlaylistId = $playlistId ?: $playlist->playlist_id;

            // Get playlist details
            $playlistDetailsUrl = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&id={$currentPlaylistId}&key={$this->apiKey}";
            $playlistDetails = $this->fetchData($playlistDetailsUrl);
            $playlist->details = $playlistDetails['items'][0] ?? null;

            // Set playlist metadata
            if (isset($playlistDetails['items'][0]['snippet']['title'])) {
                $playlist->api_title = $playlistDetails['items'][0]['snippet']['title'];
            }
            $playlist->selected_playlist_title = $playlistDetails['items'][0]['snippet']['title'] ?? '';
            $playlist->selected_playlist_id = $currentPlaylistId;

            // Get videos for this playlist
            $playlistItemsUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId={$currentPlaylistId}&key={$this->apiKey}";
            $playlist->videos = $this->fetchAllVideos($playlistItemsUrl);

            // Handle sidebar content - add channel and sibling playlists
            if (isset($playlistDetails['items'][0]['snippet']['channelId'])) {
                $channelId = $playlistDetails['items'][0]['snippet']['channelId'];
                $channelPlaylistsUrl = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&channelId={$channelId}&maxResults=50&key={$this->apiKey}";
                $channelPlaylists = $this->fetchData($channelPlaylistsUrl);

                foreach ($databaseChannels as $dbChannel) {
                    // Add channel to sidebar
                    $channelItem = clone $dbChannel;
                    $channelItem->is_channel = true;
                    $youtubeChannelLists->push($channelItem);

                    // Add related playlists if this is related to current playlist's channel
                    $isRelated = ($dbChannel->playlist_id == $playlist->playlist_id ||
                        (isset($playlistDetails['items'][0]['snippet']['channelId']) &&
                            $dbChannel->playlist_id == $playlistDetails['items'][0]['snippet']['channelId']));

                    if ($isRelated) {
                        foreach ($channelPlaylists['items'] ?? [] as $pl) {
                            if (isset($pl['id'])) {
                                $playlistItem = new \stdClass();
                                $playlistItem->id = $dbChannel->id;
                                $playlistItem->playlist_id = $pl['id'];
                                $playlistItem->playlist_title = $pl['snippet']['title'];
                                $playlistItem->api_title = $pl['snippet']['title'];
                                $playlistItem->is_playlist = true;
                                $playlistItem->parent_channel_id = $channelId;
                                $youtubeChannelLists->push($playlistItem);
                            }
                        }
                    }
                }
            }
        }

        // Create shortened titles for UI
        $youtubeChannelLists = $youtubeChannelLists->map(function ($item) {
            $title = $item->api_title ?? $item->playlist_title;
            $words = explode(' ', $title);
            $item->stitle = implode(' ', array_slice($words, 0, 2));
            return $item;
        });

        return response()->json([
            'playlist' => $playlist,
            'lastestPlaylists' => $latestPlaylist,
            'youtubeChannelLists' => $youtubeChannelLists,
            'status' => 200
        ]);
    }

    public function getChannel($channelId)
    {

        $channelUrl = "https://www.googleapis.com/youtube/v3/channels?part=snippet&id={$channelId}&key={$this->apiKey}";
        $channelDetails = $this->fetchData($channelUrl);

        return response()->json([
            'channel' => $channelDetails['items'][0] ?? null,
            'status' => 200
        ]);


        return response()->json([
            'message' => 'Channel ID is required',
            'status' => 400
        ]);
    }
    public function getPlaylist(Request $request)
    {
        if (!$request->has('playlist_id')) {
            return response()->json([
                'message' => 'Channel ID is required',
                'status' => 400
            ]);
        }

        $channelId = $request->playlist_id;

        // Get channel data directly instead of calling the response-returning method
        $channelUrl = "https://www.googleapis.com/youtube/v3/channels?part=snippet&id={$channelId}&key={$this->apiKey}";
        $channelDetails = $this->fetchData($channelUrl);

        // Format the response to match what your frontend expects
        $channelResponse = [
            'original' => [
                'channel' => $channelDetails['items'][0] ?? null
            ]
        ];

        return response()->json([
            'channels' => $channelResponse,
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
