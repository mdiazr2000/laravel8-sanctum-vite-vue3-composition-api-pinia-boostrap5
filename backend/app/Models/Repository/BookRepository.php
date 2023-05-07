<?php

namespace App\Models\Repository;

use App\Models\Book;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class BookRepository
{
    public function books()
    {
        return Book::with(['reservation' => function ($q) {
            $q->where('active', true)
                ->select('*', DB::raw('CASE
                                    WHEN current_timestamp() > reservations.finalDate THEN "overdue"
                                    ELSE "ontime"
                                END as status_time'))
                ->with('client');
        }])->get();
    }

    public function saveBook($title = "", $description = "", $reserved = false, $active = true)
    {
        try {
            // Tell Laravel all the code beneath this is a transaction
            DB::beginTransaction();
            $book = new Book();
            $book->title = $title;
            $book->description = $description;
            $book->active = $active;
            $book->save();
            DB::commit();
            return $book;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function book($id = null)
    {
        return Book::where('id', $id)->first();
    }

    public function updateBook(
        $title = "",
        $description = "",
        $reserved = false,
        $id = null,
        $active = false
    )
    {
        try {
            // Tell Laravel all the code beneath this is a transaction
            DB::beginTransaction();
            // Search book
            $book = Book::where('id', $id)->first();
            if (isset($book)) {
                $book->title = $title;
                $book->description = $description;
                $book->reserved = $reserved;
                $book->active = $active;
                $book->save();
            }
            DB::commit();
            return $book;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function deleteBook($id)
    {
        try {
            // Tell Laravel all the code beneath this is a transaction
            DB::beginTransaction();
            // Search book
            $book = Book::where('id', $id)->first();
            if (isset($book)) {
                $book->delete();
            }
            DB::commit();
            return $book;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function reserveBook($clientId, $bookId)
    {
        try {
            // Tell Laravel all the code beneath this is a transaction
            DB::beginTransaction();

            // All the dates will come from the front in UTC timezone
            // Check that book is not reserved yet
            $book = Book::where('id', $bookId)->where('reserved', false)->first();
            if (!isset($book)) {
                throw new \Exception("This book is already reserved", 404);
            }

            // If exists and not reserved make a reservation
            $reservation = new Reservation();
            $reservation->client_id = $clientId;
            $reservation->book_id = $bookId;
            $reservation->initialDate = Carbon::now('UTC')->addDays(1)->format('Y-m-d 00:00:00');
            $reservation->finalDate = Carbon::now('UTC')->addDays(2)->format('Y-m-d 23:59:59');
            $reservation->save();

            // set book as reserved on book
            $book->reserved = true;
            $book->save();

            DB::commit();
            return $reservation;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function unReserveBook($reservationId)
    {
        try {
            // Tell Laravel all the code beneath this is a transaction
            DB::beginTransaction();

            // All the dates will come from the front in UTC timezone
            // Check that book is not reserved yet
            $reservation = Reservation::where('id', $reservationId)->first();
            if (!isset($reservation)) {
                throw new \Exception("This reservation does not exists", 404);
            }

            $reservation->active = false;
            $reservation->save();

            // set book as un Reserved on book
            $book = Book::where('id', $reservation->book_id)->first();
            $book->reserved = false;
            $book->save();

            DB::commit();
            return $reservation;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function booksAvailableToReserve()
    {
        return Book::where('reserved', false)->where('active', true)->get();
    }
}
