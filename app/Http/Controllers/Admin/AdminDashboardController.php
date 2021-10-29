<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{

    private $nav_tree = "dashboard";

    public function index()
    {

        $data = [
            'nav_tree' => $this->nav_tree,
        ];

        return view('admin.pages.dashboard', $data);
    }
}
