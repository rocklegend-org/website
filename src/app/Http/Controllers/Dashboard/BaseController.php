<?php

namespace Dashboard;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as LaravelBaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class BaseController extends LaravelBaseController {

	public function __construct()
    {
		$this->middleware('auth', array('except' => array('login', 'process.login')));

        // Check if the user has the permissions
		$this->middleware('perm', array('except' => array('login', 'process.login')));

        $this->middleware('csrf', array('on' => 'post'));
    }
}