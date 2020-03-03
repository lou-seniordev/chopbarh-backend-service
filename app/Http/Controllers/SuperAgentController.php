<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 03.03.20
 * Time: 04:15
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class SuperAgentController extends Controller
{
    public function list() {
        return view('pages.super_agents.list');
    }

    public function upload() {
        return view('pages.super_agents.upload');
    }

    public function upload_csv(Request $request) {

    }
}