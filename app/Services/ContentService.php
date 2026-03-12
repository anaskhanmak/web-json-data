<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class ContentService
{
    private const CACHE_KEY = 'website_content_json';

    private const CONTENT_PATH = 'app/content.json';

    public function getPath(): string
    {
        return storage_path(self::CONTENT_PATH);
    }

    /**
     * Get all section data from JSON (cached).
     */
    public function getContent(): array
    {
        return Cache::remember(self::CACHE_KEY, 3600, function () {
            return $this->readFromFile();
        });
    }

    /**
     * Read raw content from file (no cache).
     */
    public function readFromFile(): array
    {
        $path = $this->getPath();

        if (! File::exists($path)) {
            return $this->getDefaultContent();
        }

        $json = File::get($path);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->getDefaultContent();
        }

        return is_array($data) ? $data : $this->getDefaultContent();
    }

    /**
     * Save content to JSON file and clear cache.
     */
    public function saveContent(array $content): void
    {
        $path = $this->getPath();
        $dir = dirname($path);

        if (! File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        File::put($path, json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        $this->clearCache();
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Default structure when file is missing or invalid.
     */
    public function getDefaultContent(): array
    {
        return [
            'hero' => [
                'enabled' => true,
                'title' => 'Welcome to Our Website',
                'subtitle' => 'We build amazing products',
                'button_text' => 'Get Started',
            ],
            'about' => [
                'enabled' => true,
                'title' => 'About Us',
                'description' => 'We are a creative company.',
            ],
            'services' => [
                'enabled' => false,
                'title' => 'Our Services',
                'items' => ['Web Development', 'Mobile Apps', 'UI/UX Design'],
            ],
        ];
    }

    /**
     * Ensure content file exists with default data.
     */
    public function ensureFileExists(): void
    {
        if (! File::exists($this->getPath())) {
            $this->saveContent($this->getDefaultContent());
        }
    }
}
