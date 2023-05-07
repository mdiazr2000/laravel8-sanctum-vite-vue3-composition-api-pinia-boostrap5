<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookReserveRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Book;
use App\Models\Repository\BookRepository;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $books = $this->bookRepository->books();

            return response()->json([
                'message'   => 'Books listed succesfully',
                'data' => $books
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
     * @param BookStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $bookStoreRequest)
    {
        try {
            $book = $this->bookRepository->saveBook(
                $bookStoreRequest->title,
                $bookStoreRequest->description,
                $bookStoreRequest->reserved,
                $bookStoreRequest->active
            );

            return response()->json([
                'message'   => 'Books saved succesfully',
                'data' => $book
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
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $book = $this->bookRepository->book($id);

            return response()->json([
                'message'  => 'Book showed successfully',
                'data' => $book
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookUpdateRequest $bookUpdateRequest
     * @return \Illuminate\Http\Response
     */
    public function update(BookUpdateRequest $bookUpdateRequest)
    {
        try {
            $book = $this->bookRepository->updateBook(
                $bookUpdateRequest->title,
                $bookUpdateRequest->description,
                $bookUpdateRequest->reserved,
                $bookUpdateRequest->id,
                $bookUpdateRequest->active
            );

            return response()->json([
                'message'   => 'Books saved succesfully',
                'data' => $book
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $book = $this->bookRepository->deleteBook($id);

            return response()->json([
                'message'  => 'Book deleted successfully',
                'data' => $book
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BookReserveRequest $bookReserveRequest
     * @return \Illuminate\Http\Response
     */
    public function reserve(BookReserveRequest $bookReserveRequest)
    {
        try {
            $reservation = $this->bookRepository->reserveBook(
                $bookReserveRequest->clientId,
                $bookReserveRequest->bookId
            );

            return response()->json([
                'message'  => 'Reservation saved successfully',
                'data' => $reservation
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function unreserve($id)
    {
        try {
            $reservation = $this->bookRepository->unReserveBook($id);

            return response()->json([
                'message'  => 'Reservation finished successfully',
                'data' => $reservation
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }


    public function availableToReserve()
    {
        try {
            $books = $this->bookRepository->booksAvailableToReserve();

            return response()->json([
                'message'   => 'Books available succesfully',
                'data' => $books
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }
}
