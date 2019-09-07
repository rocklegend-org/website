<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as LaravelBaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class BaseController extends LaravelBaseController
{
    use DispatchesJobs, ValidatesRequests;

   	public $redis = false;

    public function __construct()
    {
       	$this->redis = LRedis::connection();
    }

	public function generateSitemap($format = 'xml'){
	 	// create new sitemap object
	    $sitemap = App::make('sitemap');

	    // set cache (key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean))
	    // by default cache is disabled
	    $sitemap->setCache('laravel.sitemap', 3600);

	    // check if there is cached sitemap and build new only if is not
	    if (!$sitemap->isCached())
	    {
	    	$sitemap->add(URL::to('/'), date('Y-m-d'), '1.0', 'daily');
	    	$sitemap->add(URL::to('/changelog'), date('Y-m-d'), '0.5', 'weekly');
	    	$sitemap->add(URL::to('/forum'), date('Y-m-d'), '0.7', 'daily');
	    	$sitemap->add(URL::to('/discover'), date('Y-m-d'), '0.9', 'daily');
	    	$sitemap->add(URL::to('/terms-of-service'), date('Y-m-d'), '0.9', 'weekly');
	    	$sitemap->add(URL::to('/imprint'), date('Y-m-d'), '0.9', 'monthly');
	    	$sitemap->add(URL::to('/rankings'), date('Y-m-d'), '0.9', 'monthly');

		    // get all posts from db
		    $artists = Artist::all();

		    // add every post to the sitemap
		    foreach ($artists as $artist)
		    {
		    	$sitemap->add(route('artist.show', array('artist' => $artist->slug)), $artist->updated_at, '0.8', 'weekly');

		    	$songs = $artist->songs()->where('status', 1)->get();

		    	foreach($songs as $song){

		    		$tracks = $song->getTracks();

		    		foreach($tracks as $track){
		    			$sitemap->add(route('game.play', array('artist' => $artist->slug, 'song' => $song->slug, 'track' => $track->id)), $track->updated_at, '0.9', 'daily');
		    		}
		    	}
		    }

		    $users = User::all();

		    foreach($users as $user)
		    {
		    	$sitemap->add(route('profile', array('username' => $user->username)), $user->updated_at, '0.6', 'daily');
		    }
	    }

	    // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
	    $formats = array('xml', 'html', 'txt', 'ror-rss', 'ror-rdf');
	    $format = in_array($format, $formats) ? $format : 'xml';

	    echo $sitemap->render($format);
	}
}
