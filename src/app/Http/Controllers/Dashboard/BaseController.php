<?php

namespace Dashboard;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as LaravelBaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class BaseController extends LaravelBaseController {

	public function __construct()
    {
		$this->beforeFilter('auth', array('except' => array('login', 'process.login')));

        // Check if the user has the permissions
		$this->beforeFilter('perm', array('except' => array('login', 'process.login')));

        $this->beforeFilter('csrf', array('on' => 'post'));
    }
}