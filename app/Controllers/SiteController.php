<?php

namespace App\Controllers;

use Illumine\Foundation\Application;
use Illumine\Http\Request;

class SiteController extends Controller
{
    public function home()
    {
        return $this->view('home', ['name' => 'ELECTRA']);
    }

    public function contact()
    {
        return $this->view('contact');
    }

    public function submitContact(Request $request)
    {
//        $this->validate($request, [
//            'name' => 'required',
//            'email' => 'required|email',
//            'message' => 'required',
//        ]);
        echo '<pre>';
        var_dump($request->all(), $request->getBody(), $request->hasFile('avatar2'));
        echo '</pre>';
    }
}