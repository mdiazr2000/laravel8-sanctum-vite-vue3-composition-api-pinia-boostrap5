<?php

namespace App\Http\Controllers;

use App\Models\Repository\ReservationRepository;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $reservations = $this->reservationRepository->reservationsActive();

            return response()->json([
                'message'   => 'Reservation listed succesfully',
                'data' => $reservations
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }
}
