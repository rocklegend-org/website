<?php

class SubscriptionController extends BaseController {

	public function __construct()
	{	
		parent::__construct();

		$this->middleware('auth', array('except' => array('login', 'login')));
	}

	public function index()
	{
		$plans = Braintree_Plan::all();
		$clientToken = Braintree_clientToken::generate();

		$view = View::make('subscriptions.index');
		$view->with('braintreeClientToken',$clientToken)
			->with('plans', $plans);

		return $view;
	}
}