<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends BaseController
{
    protected $book = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Book $book)
    {
        #$this->middleware('auth:api');
        $this->book = $book;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = $this->book->orderBy('id', 'ASC')->latest()->paginate(10);

        return $this->sendResponse($books, 'Books list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $books = $this->book->pluck('id','title','author','description','isbn','image','published','publisher');

        return $this->sendResponse($books, 'Books list');
    }


    /**
     * Store a newly created resource in storage.
     *
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $saveBook = $this->book->create([
            'title' => $request->get('title'),
            'author' => $request->get('author'),
            'genre' => $request->get('genre'),
            'description' => $request->get('description'),
            'isbn' => $request->get('isbn'),
            'published' => $request->get('published'),
            'publisher' => $request->get('publisher')
        ]);

        return $this->sendResponse($saveBook, 'Book Created Successfully');
    }

    /**
     * Update the resource in storage
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $updateBook = $this->book->findOrFail($id);

        $updateBook->update($request->all());

        return $this->sendResponse($updateBook, 'Book Information has been updated');
    }


    public function destroy($id){

        #$this->authorize('isAdmin');
        $book = $this->book->findOrFail($id);
        $book->delete();

        return $this->sendResponse($book, 'Book has been Deleted');
    }

    public function upload(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('bookImage'), $fileName);

        return response()->json(['success' => true]);
    }
}
