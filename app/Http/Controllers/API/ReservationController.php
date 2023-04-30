<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
    
     */
    public function getReservationByUser(User $user)
    {
        try {
            $reservations = $user->reservations;

            return response()->json(['reservations' => $reservations], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while retrieving the reservations.'], 500);
        }
    }
    public function index()
    {
        try {
            $reservations = Reservation::with(['book', 'user'])->get();

            return response()->json(['reservations' => $reservations], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while retrieving reservations.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'book_id' => 'required|exists:books,id',
                'date_of_start' => 'required',
                'date_of_end' => 'required|after:date_of_start'
            ]);

            $book = Book::findOrFail($validatedData['book_id']);

            if (!$book->available) {
                return response()->json(['message' => 'This book is not available for reservation'], 422);
            }

            $reservation = Reservation::create($validatedData);
            $book->update(['available' => false]);
            $book->decrement('quantity', 1);

            return response()->json(['reservation' => $reservation, 'message' => "Reservation was made successfully"], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function show($id)
    {
        try {
            $reservation = Reservation::find($id);
            if (!$reservation) {
                return response()->json(['message' => 'Reservation not found'], 404);
            }
            $reservation->load(['book', 'user']);

            return response()->json(['reservation' => $reservation], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while retrieving the reservation.'], 500);
        }
    }

    // public function update(Request $request, Reservation $reservation)
    // {
    //     try {
    //         $validatedData = $request->validate([
    //             'user_id' => 'required|exists:users,id',
    //             'book_id' => 'required|exists:books,id',
    //             'date_of_start' => 'required',
    //             'date_of_end' => 'required|after:date_of_start'
    //         ]);

    //         $reservation->update($validatedData);

    //         return response()->json(['reservation' => $reservation], 200);
    //     } catch (Exception $e) {
    //         return response()->json(['message' => 'An error occurred while updating the reservation.'], 500);
    //     }
    // }

    public function destroy(Reservation $reservation)
    {
        try {
            $book = $reservation->book;
            $book->update(['available' => true]);
            $book->increment('quantity');
            $reservation->delete();

            return response()->json(['message' => 'Reservation deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the reservation.'], 500);
        }
    }
}
