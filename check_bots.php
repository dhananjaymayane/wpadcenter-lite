<?php

function wpadl_check_bot(){

	$bots_array = array
		(
		'google',
		'ia_archiver',
		'lycos',
		'jeeves',
		'scooter',
		'fast-webcrawler',
		'slurp@inktomi',
		'technorati',
		'yahoo',
		'findexa',
		'findlinks',
		'gaisbo',
		'zyborg',
		'bloglines',
		'blogsearch',
		'pubsub',
		'syndic8',
		'userland',
		'become.com',
		'baiduspider',
		'360spider',
		'spider',
		'sosospider',
		'yandex',
		'ASPSeek',
		'CrocCrawler',
		'FAST-WebCrawler',
		'Lycos',
	    'MSRBOT',
	    'Scooter',
	    'Altavista',
	    'eStyle',
	    'Scrubby',
	    'facebookexternalhit',
		'008',
	    'Arachmo',
	    'boitho.com-dc',
	    'boitho.com-robot',
	    'Cerberian Drtrs',
	    'Charlotte',
	    'cosmos',
	    'Covario IDS',
	    'FindLinks',
	    'DataparkSearch',
	    'Holmes',
	    'htdig',
	    'ia_archiver',
	    'ichiro',
	    'L.webis',
	    'Larbin',
	    'LinkWalker',
	    'lwp-trivial',
	    'Mnogosearch',
	    'mogimogi',
	    'Morning Paper',
	    'MVAClient',
	    'NetResearchServer',
	    'NewsGator',
	    'NG-Search',
	    'NutchCVS',
	    'Nymesis',
	    'oegp',
	    'Orbiter',
	    'Peew',
	    'Pompos',
	    'PostPost',
	    'PycURL',
	    'Qseero',
	    'Radian6',
	    'SBIder',
		'ScoutJet',
		'Scrubby',
		'SearchSight',
		'semanticdiscovery',
		'ShopWiki',
		'silk',
		'Snappy',
		'Sqworm',
		'StackRambler',
		'Teoma',
		'TinEye',
		'truwoGPS',
		'updated',
		'Vagabondo',
		'Vortex',
		'voyager',
		'VYU2',
		'webcollage',
		'Websquash.com',
		'wf84',
		'WomlpeFactory',
		'yacy'
	);

	$useragent = $_SERVER['HTTP_USER_AGENT'];
	$result = false;

	foreach ( $bots_array as $key ) {
		if ( stristr($useragent, $key) ) {
			$result = true;
			break;
		}
	}
	if( preg_match('~(bot|crawl|spider|b-o-t|spyder)~i', $useragent) ){
		$result = true;
	}
	
	return $result;
}

$result = wpadl_check_bot();

if($result){
	return true;
}
else
{
	return false;
}
?>