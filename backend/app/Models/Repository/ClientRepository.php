<?php

namespace App\Models\Repository;

use App\Models\Book;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientRepository
{
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function clients()
    {
        return Client::with(['reservation' => function ($q) {
            $q->where('active', true)
                ->with('book');
        }])->get();
    }

    public function saveClient($name = "", $lastName = "", $ci ="", $email = "", $password = "")
    {
        // Save client info
        try {
            // Tell Laravel all the code beneath this is a transaction
            DB::beginTransaction();
            $client = new Client();
            $client->name = $name;
            $client->lastname = $lastName;
            $client->ci = $ci;
            $client->save();

            // Create a a user
            $user = $this->userRepository->saveUser(
                $email,
                $password,
                'client',
                'App\Models\Client',
                $client->id
            );
            DB::commit();

            return $client->load('user');
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function client($id = null)
    {
        return Client::with('user')->where('id', $id)->first();
    }

    public function listBooksReservedByClient($clientId)
    {
        $listBooks = Book::join('reservations', 'reservations.book_id', '=', 'books.id')
            ->where('reservations.client_id', $clientId)
            ->where('reservations.active', true)
            ->select('*', DB::raw('CASE
                                    WHEN current_timestamp() > reservations.finalDate THEN "overdue"
                                    ELSE "ontime"
                                END as status_time'), 'reservations.id as id_reservation')
            ->get();
        return $listBooks;
    }
}
