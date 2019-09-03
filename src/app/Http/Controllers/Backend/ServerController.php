<?php

namespace Backend;

use BaseController;

class ServerController extends BaseController{

	/**
	 * Deploys changes by pulling from git
	 *
	 * @author pne
	 *
	 * @Any("server/deploy/{authCode?}", as="server.deploy")
	 */
	public function deploy($authCode = false)
	{
		if($authCode == 'MJAVk5rH9EVw0t4SnY3h' || \App::environment() == 'local')
		{
			exec('cd '.base_path().'; git pull 2>&1', $output);

			\Mail::raw(date('d.m.Y h:m:i').' - Executed deployment on '.\App::environment().' :'.$output[0], function ($message) {
			    $message->to('pne+server@rocklegend.org')
			    	->subject('Automatic Deployment');
			});
		}
		else
		{
			$this->redirect('/');
		}
	}

}