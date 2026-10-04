<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
public function index()
{
    // Display the roles management view
    return view('roles.index'); 
}}
