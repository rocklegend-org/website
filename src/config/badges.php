<?php

$badgeArray = array();

$badgeArray['earlyaccess'] = array(
	'name' => 'Early Access',
	'description' => 'Been here from the beginning. I helped shaping this game! - The Rocklegend team says "THANK YOU SO MUCH!"',
	'image' => 'early_access.png',
    'internal_name' => 'earlyaccess',
    'target' => '0',
    'group' => 'earlyaccess',
    'checkFunction' => 'earlyAccess'
);

/** Played x songs badges **/
$playedSongsBadges = array(
	1 => 'Newbie',
	10 => 'I like this game.',
	50 => 'I love this game.',
	100 => '100 Club',
	500 => 'Addicted',
	1000 => 'Diagnosed: Rocklegenditis',
	2000 => 'I PLAYED 2000 SONGS AND ALL I GOT WAS THIS LOUSY BADGE!',
	5000 => 'Officialy insane'
);

foreach($playedSongsBadges as $target => $name)
{
	$badgeArray['played'.$target.'songs'] = array(
		'name' => $name,
		'description' => 'Played '.$target.' song'.(($target > 1) ? 's' : '').'.',
		'image' => 'played_'.$target.'_songs.png',
        'internal_name' => 'played'.$target.'songs',
        'target' => $target,
        'group' => 'playedSongs',
        'checkFunction' => 'playedSongs'
	);
}

/** Played x songs badges **/
$playedBandsBadges = array(
	5 => 'Checking them out.',
	10 => 'I like to try new stuff!',
	50 => 'I knew them before it was cool.',
	100 => 'A breathing rocklegend-codex'
);

foreach($playedBandsBadges as $target => $name)
{
	$badgeArray['played'.$target.'bands'] = array(
		'name' => $name,
		'description' => 'Played songs by '.$target.' different artists.',
		'image' => 'played_'.$target.'_bands.png',
        'internal_name' => 'played'.$target.'bands',
        'target' => $target,
        'group' => 'playedBands',
        'checkFunction' => 'playedBands'
	);
}

$badgeArray['donator'] = array(
	'name' => 'Donator',
	'description' => 'Thank you for donating! Your contribution helps us to pay for server & domain costs, and add new stuff to rocklegend.',
	'image' => 'donator.png',
    'internal_name' => 'donator',
    'target' => '0',
    'group' => 'donator',
    'checkFunction' => 'donator'
);

return $badgeArray;