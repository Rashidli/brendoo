<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Content;
use App\Models\Link;
use App\Models\Service;
use App\Models\Single;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function sitemap()
    {
        $singles = Single::with('translations')->get();
        $services = Service::active()->with('translation')->get();
        $blogs = Blog::active()->with('translations')->get();
        $contents = Content::active()->with('translations')->get();
        $links = Link::active()->with('translations')->get();
        return response()->view('front.sitemap', compact('singles','blogs','contents','links','services'))->header('Content-type','text/xml');
    }
}
