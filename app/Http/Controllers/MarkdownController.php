<?php

use Michelf\Markdown;

class MarkdownController extends BaseController {

	/**
	 * @Get("changelog", as="changelog")
	 */
	public function changelog()
	{
		$markdown = Markdown::defaultTransform(file_get_contents('../CHANGELOG.md'));

		return View::make('changelog')
				->with('markdown', $markdown);
	}

}
