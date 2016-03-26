<?php

include "config.php";

// ===== TEST VALUES =====
// $intent = "places_visited";
// $entities = array(
// 	"datetime" => array(
//         "start" => 14,
//         "end" => 26,
//         "body" => "last weekend",
//         "value" => array
//             (
//                 "from" => "2016-02-19T18:00:00.000+01:00",
//                 "to" => "2016-02-22T00:00:00.000+01:00"
//             )
// 	)
// );
//
//
// (
//     [datetime] => Array
//         (
//             [start] => 14
//             [end] => 26
//             [body] => last weekend
//             [value] => Array
//                 (
//                     [from] => 2016-02-19T18:00:00.000+01:00
//                     [to] => 2016-02-22T00:00:00.000+01:00
//                 )
//
//         )
//
// )

// print_r($entities);

function append_from($from) {
	$epoch = to_epoch($from);
	return "&afterTimestamp=$epoch";
}

function append_to($to) {
	$epoch = to_epoch($to);
	return "&beforeTimestamp=$epoch";
}

$str = "https://api.foursquare.com/v2/users/self/venuehistory?oauth_token=$foursquare_token&v=20160228";

foreach($entities as $ent => $val) {
	if($ent == "datetime") {
		if(isset($val["value"]["from"]))
			$str .= append_from($val["value"]["from"]);
		if(isset($val["value"]["to"]))
			$str .= append_to($val["value"]["to"]);
		
		// workaround?
		if(isset($val[0]["value"]["from"]))
			$str .= append_from($val[0]["value"]["from"]);
		if(isset($val[0]["value"]["to"]))
			$str .= append_to($val[0]["value"]["to"]);
		
	} else if($ent == "search_query") {
		// TODO
	}
}

// echo "<br>$str<br>";

$result = json_decode(file_get_contents($str), true);
// $result = utf8_encode($result);
// print_r($result);
$items = $result["response"]["venues"]["items"];
echo "You've been to:<br>";
foreach($items as $item) {
	$name = $item["venue"]["name"];
	$city = $item["venue"]["location"]["city"];
	$country = $item["venue"]["location"]["country"];
	echo "&bull; $name in $city, $country<br>";
}

