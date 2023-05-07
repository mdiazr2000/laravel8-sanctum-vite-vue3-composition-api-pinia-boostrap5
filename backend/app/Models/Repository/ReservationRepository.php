<?php

namespace App\Models\Repository;

use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReservationRepository
{
    public function reservationsActive()
    {
        return Reservation::where('reservations.active', true)
            ->join('books', 'books.id', '=', 'reservations.book_id')
            ->select(
                'books.title',
                'books.description',
                'reservations.finalDate',
                DB::raw('CASE
                                    WHEN current_timestamp() > reservations.finalDate THEN "overdue"
                                    ELSE "ontime"
                                END as status_time')
            )
            ->get();
    }
}
