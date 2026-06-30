<?php

namespace app\Controllers;

use app\Core\Request;
use app\Core\Response;
use app\Core\View;

class HomeController {
    public function index(Request $request, Response $response) {
        $q = $request->input('q');
        
        $categories = \app\Models\Post::getCategoriesWithCounts();
        $totalPosts = count(\app\Models\Post::all()); // Total across all categories
        
        // Check for slug or query parameter
        $categorySlug = $request->routeParam('slug');
        $category = $request->input('category'); // Fallback for old query param

        if ($categorySlug) {
            // Find the original category name matching the slug
            foreach ($categories as $cat) {
                if (slugify($cat['category']) === $categorySlug) {
                    $category = $cat['category'];
                    break;
                }
            }
        }

        $posts = \app\Models\Post::searchAndFilter($q, $category);
        
        return View::render('home/index', [
            'posts' => $posts,
            'categories' => $categories,
            'totalPosts' => $totalPosts,
            'currentCategory' => $category,
            'currentSearch' => $q
        ]);
    }
}
