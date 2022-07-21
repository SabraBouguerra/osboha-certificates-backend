<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Repositories\book\interfaces\BooksRepositoryInterface;

class BooksController extends BaseController
{

    private BooksRepositoryInterface $bookService;
    function __construct(BooksRepositoryInterface $bookService) {
        $this->bookService = $bookService;
      }

    public function index(){

        $books =$this->bookService->getAllBooks();
        return $this->sendResponse($books,"Tasks");
     }


    //  public function store(Request $request){
    //      $input = $request->all();
    //      $validator = Validator::make($input,[
    //          'title'=>'required',
    //          'description'=>'required',
    //          'user_id' => 'required'
    //      ]);
    //      if ($validator->fails()) {
    //          return $this->sendError('Validate Error',$validator->errors() );
    //      }

    //      $task = Task::create($input);
    //      return $this->sendResponse($task, 'task added Successfully!' );
    //  }

    //  public function show($id){

    //      $task = Task::find($id);
    //      return $task;
    //  }


    //  public function update(Request $request, Task $task){
    //      $input = $request->all();
    //      $validator = Validator::make($input,[
    //          'title'=>'required',
    //          'description'=>'required'
    //      ]);
    //      if ($validator->fails()) {
    //          return $this->sendError('Validation error' , $validator->errors());
    //      }


    //      $task->title = $input['title'];
    //      $task->description = $input['description'];
    //      $task->save();
    //  }

    //  public function destroy(Task $task, Request $request){
    //      $errorMessage = [] ;

    //      if ( $task->user_id != Auth::id() && $request->user()->role != "ADMIN") {
    //          return $this->sendError('you dont have rights' , $errorMessage);
    //      }
    //      $task->delete();
    //      return $this->sendResponse($task, 'Task deleted Successfully!' );

    //  }


}
