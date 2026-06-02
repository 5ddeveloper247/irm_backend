<?php

namespace App\Services;

use App\Models\AudioCategory;
use App\Models\AudioLecture;

class AudioLectureService
{
    public function formatLectureForApi(AudioLecture $lecture): array
    {
        $lecture->loadMissing(['category', 'attachments']);

        $sourceType = $lecture->audio_source_type ?? 'file';
        $playUrl = $this->resolvePlayUrl($lecture, $sourceType);
        $downloadUrl = $this->resolveDownloadUrl($lecture, $sourceType);
        $embedUrl = $this->resolveEmbedUrl($lecture, $sourceType);

        $dateRaw = $lecture->date ?? $lecture->created_at?->format('Y-m-d');

        return [
            'id' => $lecture->id,
            'bayan_name' => $lecture->title,
            'title' => $lecture->title,
            'speaker' => $lecture->speaker ?? '',
            'date' => $dateRaw ? date('F d, Y', strtotime($dateRaw)) : '',
            'date_raw' => $dateRaw,
            'description' => $lecture->description,
            'description_short' => $this->shortDescription($lecture->description),
            'has_description' => !empty(strip_tags((string) $lecture->description)),
            'category_id' => $lecture->category_id,
            'category_name' => $lecture->category?->title,
            'duration' => (int) ($lecture->duration ?? 0),
            'duration_label' => $this->formatDuration((int) ($lecture->duration ?? 0)),
            'thumbnail' => $lecture->thumbnail ? url('/' . $lecture->thumbnail) : null,
            'audio_source_type' => $sourceType,
            'stream_type' => in_array($sourceType, ['soundcloud', 'youtube', 'external'], true) ? 'embed' : 'direct',
            'play_url' => $playUrl,
            'download_url' => $downloadUrl,
            'embed_url' => $embedUrl,
            'attachments' => $lecture->attachments->map(function ($attachment) {
                return [
                    'id' => $attachment->id,
                    'name' => $attachment->name,
                    'url' => url('/' . $attachment->path),
                    'download_url' => url('/' . $attachment->path),
                ];
            })->values()->all(),
            'status' => (int) $lecture->status,
            'created_at' => $lecture->created_at,
            'updated_at' => $lecture->updated_at,
        ];
    }

    public function formatCategoryForApi(AudioCategory $category, bool $withLectures = false, int $lectureLimit = 0): array
    {
        $formatted = [
            'id' => $category->id,
            'title' => $category->title,
            'description' => $category->description,
            'date' => $category->date,
            'status' => (int) $category->status,
            'lecture_count' => $category->audio_lectures()
                ->where('status', 1)
                ->count(),
        ];

        if ($withLectures) {
            $query = AudioLecture::with(['category', 'attachments'])
                ->where('category_id', $category->id)
                ->where('status', 1)
                ->orderByDesc('id');

            if ($lectureLimit > 0) {
                $query->limit($lectureLimit);
            }

            $formatted['lectures'] = $query->get()
                ->map(fn ($lecture) => $this->formatLectureForApi($lecture));
        }

        return $formatted;
    }

    public function buildEmbedUrl(string $sourceType, string $url): ?string
    {
        $url = trim($url);

        if ($url === '') {
            return null;
        }

        if ($sourceType === 'soundcloud') {
            if (str_contains($url, 'w.soundcloud.com/player')) {
                return $url;
            }

            return 'https://w.soundcloud.com/player/?url=' . urlencode($url)
                . '&auto_play=false&hide_related=false&show_comments=false&show_user=true&show_reposts=false&visual=false';
        }

        if ($sourceType === 'youtube') {
            if (preg_match('/(?:embed\/|v=|youtu\.be\/)([a-zA-Z0-9_\-]{11})/', $url, $matches)) {
                return 'https://www.youtube.com/embed/' . $matches[1];
            }

            return $url;
        }

        if (in_array($sourceType, ['external', 'embed'], true)) {
            return $url;
        }

        return null;
    }

    public function normalizeSourceType(?string $type): string
    {
        $type = strtolower(trim((string) $type));

        return in_array($type, ['file', 'soundcloud', 'youtube', 'external'], true) ? $type : 'file';
    }

    private function resolvePlayUrl(AudioLecture $lecture, string $sourceType): ?string
    {
        if (in_array($sourceType, ['soundcloud', 'youtube', 'external'], true)) {
            return $this->resolveEmbedUrl($lecture, $sourceType);
        }

        $first = $lecture->attachments->first();

        return $first ? url('/' . $first->path) : null;
    }

    private function resolveDownloadUrl(AudioLecture $lecture, string $sourceType): ?string
    {
        if ($sourceType !== 'file') {
            return null;
        }

        $first = $lecture->attachments->first();

        return $first ? url('/' . $first->path) : null;
    }

    private function resolveEmbedUrl(AudioLecture $lecture, string $sourceType): ?string
    {
        if (!in_array($sourceType, ['soundcloud', 'youtube', 'external'], true)) {
            return null;
        }

        if (!empty($lecture->embed_url)) {
            return $lecture->embed_url;
        }

        return $this->buildEmbedUrl($sourceType, (string) $lecture->external_url);
    }

    private function formatDuration(int $seconds): string
    {
        if ($seconds <= 0) {
            return '';
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        if ($hours > 0) {
            return sprintf('%d:%02d:%02d', $hours, $minutes, $secs);
        }

        return sprintf('%d:%02d', $minutes, $secs);
    }

    private function shortDescription(?string $text, int $limit = 120): string
    {
        $plain = trim(strip_tags((string) $text));

        if (strlen($plain) <= $limit) {
            return $plain;
        }

        return substr($plain, 0, $limit) . '...';
    }
}
