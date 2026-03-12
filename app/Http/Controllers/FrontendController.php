<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Inertia\Inertia;

class FrontendController extends Controller
{
    // ##################### Website Pages ######################
    public function home()
    {
        return view(
            'frontend.pages.home',
            [
                'title' => 'Book Editing | Book Formatting| Book Publishing| Kindle Book Publishers Hub',
                'description' => 'Get professional book editing, formatting, and publishing services in the U.S. Improve your manuscript, achieve publishing success, and grow your readership with us.
',
            ]
        );
    }
    
}
