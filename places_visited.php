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

$str = "https://api.foursquare.com/v2/users/self/venuehistory?oauth_token=$foursquare_token&v=20160228";

foreach($entities as $ent => $val) {
	if($ent == "datetime") {
		if(isset($val["value"]["from"])) {
			$from = $val["value"]["from"];
			$epoch = to_epoch($from);
			$str .= "&afterTimestamp=$epoch";
		}
		if(isset($val["value"]["to"])) {
			$to = $val["value"]["to"];
			$epoch = to_epoch($to);
			$str .= "&beforeTimestamp=$epoch";
		}
		// echo $str;
		
	} else if($ent == "search_query") {
		// TODO
	}
}

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

