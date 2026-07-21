<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    private $category;

    public function __construct()
    {
        $this->category = new \App\Models\Category();
    }

    public function index()
    {
        $categories = $this->category->all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }
}
