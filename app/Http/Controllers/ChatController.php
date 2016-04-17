<?php
class ChatController extends BaseController {

	public function setOpen()
	{
		Session::put('chat.open', Input::get('open'));
	}

}