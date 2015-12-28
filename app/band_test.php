<?php
//testing band.php class
include_once "band.php";
echo '<pre>';
$band = new Band('JimmyJam');
//var_dump($band->add_rating(1));
//var_dump($band->update_band());
//var_dump($band->update_rating_and_votes(4,19));
//var_dump($band->grab_all_bands());
var_dump($band->calculate_rating());
//test insert band
//var_dump($band->insert_band(2,4));
