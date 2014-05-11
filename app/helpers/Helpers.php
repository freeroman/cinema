<?php

class Helpers
{    
    public static function StateColor($id)
    {        
        switch($id){
            case 'free': $res = 'green'; break;
            case 'booked': $res = 'red'; break;
            case 'reserved': $res = 'orange'; break;
            default : $res = 'red'; break;
        }
        
        return $res;
    }    

}
