<?php
/**
 * Back end for Metal Rating project
 * @rdarling42
 *
 * */
include_once 'band.php';

if(!empty($_POST)){
    //handle post requests
    if(!empty($_POST['action']) && !empty($_POST['safety'])){
        //right now, there is nothing we are doing except updating a bands ratings
        switch($_POST['action']){
        case 'rate':
            if(!empty($_POST['band']) && !empty($_POST['rating'])){
                $band = new Band($_POST['band']);
                if($band->add_rating($_POST['rating'])){
                    $band->update_band();
                    $res = 'Thanks, rating was updating successfully'; 
                }else{
                    $res = 'Sorry, we were not able to update that band rating at this time'; 
                }
            }else{
                $res = 'We do not have the information we need to update'; 
            }
            break;
        default: 
            $res = 'Sorry, action request not understood';
        }
    }else{
        $res = "Error, please set an action param to do anything, or you are requesting something you should not"; 
    }
}elseif(!empty($_GET)){
   //handle get requests 
    if(!empty($_GET['action'])){
        switch($_GET['action']){
            case 'bands': 
                $band = new Band(null);
                $res = $band->grab_all_bands();
                break;
            default:
                $res = 'Sorry, action not understood';
        } 
    }else{
        $res = 'Please set action param for GET request'; 
    }
}else{
    $res = "Error, request not understood";
}

echo $res;//the response
