<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Youtube;

class YoutubeVideoService
{
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = env('YOUTUBE_API_KEY', 'AIzaSyBk1z-xAVabyzCk4VJOCSDJh_i49MlMpPI');
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getActiveDefaultPlaylist(): ?Youtube
    {
        return Youtube::where('status', 1)->orderByDesc('id')->first();
    }

    public function getYoutubeChannelUrl(): ?string
    {
        $settings = Setting::first();

        return $settings?->youtube_link ?: null;
    }

    public function fetchData(string $url): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true) ?? [];
    }

    public function fetchAllPlaylistVideos(string $playlistId, int $maxPages = 5): array
    {
        $url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId={$playlistId}&key={$this->apiKey}";
        $allVideos = [];
        $pages = 0;

        do {
            $data = $this->fetchData($url);
            if (!isset($data['items'])) {
                break;
            }

            $allVideos = array_merge($allVideos, $data['items']);
            $pages++;

            $url = isset($data['nextPageToken'])
                ? "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId={$playlistId}&key={$this->apiKey}&pageToken={$data['nextPageToken']}"
                : null;
        } while ($url && $pages < $maxPages);

        return $this->sortVideosByLatest($allVideos);
    }

    public function fetchPlaylistVideosPage(string $playlistId, ?string $pageToken = null, int $maxResults = 20): array
    {
        $url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults={$maxResults}&playlistId={$playlistId}&key={$this->apiKey}";

        if ($pageToken) {
            $url .= '&pageToken=' . $pageToken;
        }

        $data = $this->fetchData($url);

        return [
            'videos' => $this->sortVideosByLatest($data['items'] ?? []),
            'next_page_token' => $data['nextPageToken'] ?? null,
            'total_results' => $data['pageInfo']['totalResults'] ?? null,
        ];
    }

    public function sortVideosByLatest(array $videos): array
    {
        usort($videos, function ($a, $b) {
            $dateA = $a['snippet']['publishedAt'] ?? '';
            $dateB = $b['snippet']['publishedAt'] ?? '';

            return strcmp($dateB, $dateA);
        });

        return $videos;
    }

    public function formatVideos(array $videos): array
    {
        return array_values(array_map(fn ($video) => $this->formatVideo($video), $videos));
    }

    public function formatVideo(array $video): array
    {
        $snippet = $video['snippet'] ?? [];
        $resourceId = $snippet['resourceId'] ?? [];
        $videoId = $resourceId['videoId'] ?? ($video['id']['videoId'] ?? null);
        $thumbnails = $snippet['thumbnails'] ?? [];

        return [
            'video_id' => $videoId,
            'title' => $snippet['title'] ?? '',
            'description' => $snippet['description'] ?? '',
            'published_at' => $snippet['publishedAt'] ?? null,
            'thumbnail' => $thumbnails['high']['url']
                ?? $thumbnails['medium']['url']
                ?? $thumbnails['default']['url']
                ?? null,
            'watch_url' => $videoId ? "https://www.youtube.com/watch?v={$videoId}" : null,
            'embed_url' => $videoId ? "https://www.youtube.com/embed/{$videoId}" : null,
            'playlist_id' => $snippet['playlistId'] ?? null,
        ];
    }

    public function buildPlaylistMeta($playlist, array $sortedVideos): object
    {
        $meta = new \stdClass();
        $meta->id = $playlist->id ?? null;
        $meta->playlist_id = $playlist->playlist_id ?? null;
        $meta->playlist_title = $playlist->playlist_title ?? ($playlist->api_title ?? '');
        $meta->created_at = $playlist->created_at ?? null;
        $meta->updated_at = $playlist->updated_at ?? null;
        $meta->status = $playlist->status ?? 1;
        $meta->details = $playlist->details ?? null;
        $meta->playlist_list = $playlist->playlist_list ?? [];
        $meta->selected_playlist_id = $playlist->selected_playlist_id ?? $playlist->playlist_id;
        $meta->selected_playlist_title = $playlist->selected_playlist_title ?? $meta->playlist_title;
        $meta->videos = $sortedVideos;
        $meta->latest_videos = $this->formatVideos(array_slice($sortedVideos, 0, 12));

        return $meta;
    }
}
