<?php
/**
 * Controller for Bands
 * @rdarling42
 * 
 */

include_once 'Db.php';

class Band {

    public $band;
    public $db;

    public function __construct($band){
        $this->set_band($band);
        $this->set_db();
    }

    public function set_band($band){
        $this->band = $band; 
    }

    public function set_db(){
        $this->db = new Db(); 
    }

    public function update_rating($rating){
        $ex_data = array(
            ':rate' => $rating,
            ':band' => $this->band
        );
        return $this->db->update('bands','rate = :rate','band = :band',$ex_data); 
    }
    
    public function update_votes($votes){
        $ex_data = array(
            ':votes' => $votes,
            ':band' => $this->band
        );
        return $this->db->update('bands','votes = :votes','band = :band',$ex_data); 
    }

    public function update_rating_and_votes($rating, $votes){
        $this->update_rating($rating);
        $this->update_votes($votes);
        return true;
    }

    public function insert_band($rating,$votes){
        //this is a cached version of the rating 
        $ex_data = array(
            ':rate' => $rating,
            ':band' => $this->band,
            ':votes' => $votes
        );
        return $this->db->insert('bands','band, rate, votes',':band, :rate, :votes',$ex_data); 
    }

    public function add_rating($rate){
        $ex_data = array(
            ':rate' => $rate,
            ':band' => $this->band,
            ':date' => time()
        );
        return $this->db->insert('band_rates','band, rate, date',':band, :rate, :date',$ex_data);
    }

    public function total_rating(){
        $ex_data = array(
            ':band' => $this->band
        );
        $dig = $this->db->select_sum('rate','band_rates','band = :band', $ex_data); 
        return !empty($dig) ? $dig : false;
    }

    public function count_total_ratings(){
        $ex_data = array(
            ':band' => $this->band
        );
        $dig = $this->db->select('band_rates',$ex_data,'band = :band');
        return count($dig);
    }

    public function calculate_rating(){
        $total_score = $this->total_rating(); 
        if(!empty($total_score) && is_array($total_score)){
            $total_score = $total_score[0]; 
        }
        $number_of_votes = $this->count_total_ratings();
        $one = $number_of_votes * 1;
        $two = $number_of_votes * 2;
        $three = $number_of_votes * 3;
        $four = $number_of_votes * 4;
        $five = $number_of_votes * 5;
        if($total_score <= $two){
            $res = 1; 
        }elseif($total_score <= $three){
            $res = 2; 
        }elseif($total_score <= $four){
            $res = 3; 
        }elseif($total_score <= $five){
            $res = 4; 
        }elseif($total_score > $five){
            $res = 5; 
        }else{
            $res = 0; 
        }
        return $res;
    }

    public function grab_band(){
        return $this->db->select('bands',array(':band'=>$this->band),'band = :band'); 
    }

    public function grab_all_bands(){
        return $this->db->select('bands'); 
    }

    public function update_band(){
        $rating = $this->calculate_rating();
        $votes = $this->count_total_ratings();
        if(!empty($this->grab_band())){
            $res = $this->update_rating_and_votes($rating, $votes); 
        }else{
            $res = $this->insert_band($rating, $votes);
        } 
        return $res;
    }
}
