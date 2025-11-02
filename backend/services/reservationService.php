<?php
namespace App\services;

use App\dao\ReservationDao;

class ReservationService {

    private ReservationDao $reservationDao;

    public function __construct() {
        $this->reservationDao = new ReservationDao();
    }

    public function getAllReservations() {
        return $this->reservationDao->getAllReservations();
    }

    public function getReservationsByUser($user_id) {
        return $this->reservationDao->getReservationsByUser($user_id);
    }
}
