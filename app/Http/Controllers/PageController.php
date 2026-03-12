<?php

namespace App\Http\Controllers;

use App\Services\ContentService;

class PageController extends Controller
{
    public function __construct(
        private ContentService $content
    ) {}

    /**
     * Home page: sections and content from JSON.
     */
    public function home()
    {
        $this->content->ensureFileExists();
        $content = $this->content->getContent();

        return view('frontend.pages.home', [
            'content' => $content,
            'title' => $content['hero']['title'] ?? 'Welcome',
            'description' => $content['about']['description'] ?? '',
        ]);
    }
}
