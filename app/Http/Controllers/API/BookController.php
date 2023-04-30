<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->search != null ? $request->search : '';
            $catId = $request->cat_id != null ? $request->cat_id : '';
            $books = Book::with('category')
                ->when($search, function ($query, $search) {
                    return $query->where('title', 'like', "%$search%");
                })
                ->when($catId, function ($query, $catId) {
                    return $query->where('category_id', $catId);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json(['books' => $books], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255|unique:books',
                'author' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
                'publish_date' => 'required|date',
                'quantity' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $book = Book::create([
                'title' => $request->title,
                'author' => $request->author,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'publish_date' => $request->publish_date,
                'quantity' => $request->quantity,
                'available' => true,
            ]);
            $book->load('category');
            return response()->json(['book' => $book, 'message' => "Book created successfully"], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $book = Book::find($id);
            if (!$book) {
                return response()->json(['message' => 'Book not found'], 404);
            }
            $book->load('category');
            return response()->json(['book' => $book], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255|unique:books,title,' . $book->id,
                'author' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
                'publish_date' => 'required|date',
                'available' => 'required',
                'quantity' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $book->update([
                'title' => $request->title,
                'author' => $request->author,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'publish_date' => $request->publish_date,
                'available' => $request->available,
                'quantity' => $request->quantity
            ]);
            $book->load('category');
            return response()->json(['book' => $book, 'message' => "Book created successfully"], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        try {
            $book->delete();

            return response()->json(['message' => 'Book deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
