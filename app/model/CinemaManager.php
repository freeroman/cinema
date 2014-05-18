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
    
    public function getReservations(){
        return $this->database->select('bookings.*, performances.*, cinemas.*, films.name film')
                ->from('bookings')
                ->leftJoin('booking_states')
                ->using('(id_booking_states)')
                ->leftJoin('performances')
                ->using('(id_performances)')
                ->leftJoin('films')
                ->using('(id_films)')
                ->leftJoin('cinemas')
                ->using('(id_cinemas)')
                ->where('id_booking_states=1 AND start_dt>=NOW()')
                ->orderBy('start_dt, cinemas.name, code, seat')
                ->fetchAll();
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
            $this->database->update('bookings', array('id_booking_states' => 2, 'created_dt' => date('Y-m-d H-i-s')))
                    ->where('seat=%i', $seat,'AND id_performances=%i', $performance)
                    ->execute();
        } else {
            $this->database->insert('bookings', array(
                'id_booking_states' => 2,
                'id_performances' => $performance,
                'seat' => $seat,
                'created_dt' => date('Y-m-d H-i-s')
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
    
    public function getPerformancesByCinema($cinema) {
        return $this->database->select('*')
                ->from('performances')
                ->leftJoin('films')
                ->using('(id_films)')
                ->where('id_cinemas=%i', $cinema, ' AND start_dt>=NOW()')
                ->orderBy('start_dt')
                ->fetchAll();       
    }
    
    public function getFilms(){
        return $this->database->select('id_films, name')->from('films')->fetchPairs();
    }
    
    public function getCinemas(){
        return $this->database->select('id_cinemas, name')->from('cinemas')->fetchPairs();
    }
    
    public function insertPerformance($data) {
        $this->database->insert('performances', $data)->execute();
    }
    
    public function insertFilm($data) {
        $this->database->insert('films', $data)->execute();
    }
    
    public function insertCinema($data) {
        $this->database->insert('cinemas', $data)->execute();
    }
}
