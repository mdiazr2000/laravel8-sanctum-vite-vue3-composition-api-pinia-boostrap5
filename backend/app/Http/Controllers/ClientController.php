<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Models\Client;
use App\Models\Repository\ClientRepository;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public $clientRepository;

    /**
     * @param $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $clients = $this->clientRepository->clients();

            return response()->json([
                'message'   => 'Clients listed succesfully',
                'data' => $clients
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param ClientStoreRequest $clientStoreRequest
     * @return \Illuminate\Http\Response
     */
    public function store(ClientStoreRequest $clientStoreRequest)
    {
        try {
            $client = $this->clientRepository->saveClient(
                $clientStoreRequest->name,
                $clientStoreRequest->lastname,
                $clientStoreRequest->ci,
                $clientStoreRequest->email,
                $clientStoreRequest->password
            );

            return response()->json([
                'message'        => 'Client saved successfully',
                'data' => $client
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $client = $this->clientRepository->client($id);

            return response()->json([
                'message'        => 'Client showed successfully',
                'data' => $client
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }

    /**
     * Display the reservations made by client.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function reservations($clientId)
    {
        try {
            $reservations = $this->clientRepository->listBooksReservedByClient($clientId);

            return response()->json([
                'message'        => 'Client reservations successfully',
                'data' => $reservations
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }
}
