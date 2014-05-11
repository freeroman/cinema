<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CinemaManager
 *
 * @author pecha_000
 */
class CinemaManager
{
    /** @var DibiConnection */  
    private $database;
    
    public function __construct($connection)
    {
        $this->database = $connection;
    }
    
    public function getBookingsByPerformanceId($id){
        return $this->database->select('seat, name')
                ->from('bookings')
                ->leftJoin('booking_states')
                ->using('(id_booking_states)')
                ->where('id_performances=%i', $id)
                ->fetchPairs();
    }
    
    public function reserveSeat($seat, $performance) {
        if($this->database->select('*')
                ->from('bookings')
                ->where('seat=%i', $seat,'AND id_performances=%i', $performance, 'AND (id_booking_states=1 OR id_booking_states=2)')->fetch())
        return false;
        if($this->database->select('*')
                ->from('bookings')
                ->where('seat=%i', $seat,'AND id_performances=%i', $performance)->fetch())
        {
            $this->database->update('bookings', array('id_booking_states' => 2))
                    ->where('seat=%i', $seat,'AND id_performances=%i', $performance)
                    ->execute();
        } else {
            $this->database->insert('bookings', array(
                'id_booking_states' => 2,
                'id_performances' => $performance,
                'seat' => $seat
            ))->execute();
        }
        return true;
    }
    
    public function getPerformances($id=null) {
        $sql = $this->database->select('*')
                ->from('performances')
                ->leftJoin('films')
                ->using('(id_films)');
        if($id!==null){
            return $sql->where('id_performances=%i', $id)->fetch();
        } else {
            return $sql->where('start_dt>=NOW()')
                    ->orderBy('start_dt')
                    ->fetchAll();
        }
    }
}
