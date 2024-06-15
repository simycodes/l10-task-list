<?php

use Illuminate\Http\Response; 
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest; // extends Request class above but has validation rules
use Illuminate\Support\Facades\Route; // equivalent to express code below:
// import { Router } from "express";
// const router = new Router();
use Laravel\Prompts\Concerns\Fallback;
use \App\Models\Task;

// Double Colon - :: - is usually used to access static (class) members 
// The double colon is a way in PHP Object Oriented Programming to directly access
// a method within the class. More like dot notation in express: router.get()

// SERVER HOME
Route::get('/', function () { 
    // return redirect('/tasks'); same as code below
    return redirect()->route('tasks.index');
});

// BASE ROUTE - GETS ALL TASKS
Route::get('/tasks', function () {
    // Second argument of view is used to pass values/arguments to the view page 
    // 'tasks' is the variable name being passed and '$tasks is its value
    // Can not passed html as value, the syntax will be escaped and passed as text
    return view('index', ['tasks' => Task::latest()->get()]); // no need to write full path index.blade.php
})->name('tasks.index');

// order of routes matter, such a route comes before routes that get a param, else errors
// express equivalent: router.get("/stats", showStats); placed before router.get("/:id", validateIdParam, getJob); - to avoid param errors in connection to :id as express reads from top to bottom
// in PHP vanilla: switch ($action) { case 'login':  include '../view/login.php'; break;
Route::view('tasks/create', 'create')->name('tasks.create'); 

// GET A SINGLE TASK ROUTE
// express equivalent: router.get("/:id", getJob);
// {task} still holds the passed id
Route::get('tasks/{task}', function(Task $task) { 
    return view('show', ['task'=> $task]);

})->name('tasks.show');


// CREATE A SINGLE TASK
// express equivalent: const createJob = async (req, res) => {const job = await Job.create(req.body);}
Route::post('tasks', function(TaskRequest $request) { //function(Request $request) - default
    // dd('route reached'); // dd() dump and die function
    // dd($request->all()); // displays all the incoming data

    // Get and Validate Incoming form data (which is stored as array from the form)
    // TaskRequest extends Request class and adds validation rules, hence once used, the
    // validation rules apply to the incoming form data
    $incomingFormData = $request->validated(); // validates data using code in TaskRequest class
    // code above is run instead of running code below in every controller to validate
    // incoming data

    // $incomingFormData = $request->validate([
    //     'title' => 'required|max: 255',
    //     'description' => 'required',
    //     'long_description' => 'required'
    // ]);

    // Create a new task using the incoming validated form data
    $task = new Task();
    $task->title = $incomingFormData['title'];
    $task->description = $incomingFormData['description'];
    $task->long_description = $incomingFormData['long_description'];

    // Save changes to the database/adds new task to the database
    $task->save();

    // Redirect the user with a success or failure message - redirect to a page that shows
    // the newly created job, hence redirect while passing the id of the newly created task
    return redirect()->route('tasks.show', ['id' => $task->id])
    ->with('success', 'Task Created Successfully');
    // with(); -- Creates a flash  session message indicating an operation success, this
    // message is removed after being used when displayed to the user.
    // Express equivalent:  <Link to={`../view-job/${_id}`}>Job name<Link />

})->name('tasks.store');

// GET A SINGLE TASK TO EDIT ROUTE
// express equivalent: router.get("/:id", getJob); -- /edit not used in express
// route-model binding(searching db data using arguments): {task} still holds the passed id
Route::get('tasks/{task}/edit', function(Task $task) { 
    return view('edit', ['task' => $task]);
})->name('tasks.edit');

// OTHER APPROACH OF ROUTER ABOVE
Route::get('tasks/{id}/edit', function($id) { 
    return view('edit', ['task'=> Task::findOrFail($id)]);
})->name('tasks.edit');


// EDIT A SINGLE TASK
// express equivalent: const updatedJob = await Job.findByIdAndUpdate(id, req.body, { new: true });
Route::put('tasks/{task}', function(Task $task, TaskRequest $request) { 
    // Update the task using the incoming validated form data
    $incomingFormData = $request->validated(); // validates data using code in TaskRequest class
    $task->title = $incomingFormData['title'];
    $task->description = $incomingFormData['description'];
    $task->long_description = $incomingFormData['long_description'];

    // Save changes to the database/adds new task to the database
    $task->save();

    // Redirect the user with a success or failure message - redirect to a page that shows
    // the newly created job, hence redirect while passing the id of the newly created task
    return redirect()->route('tasks.show', ['id' => $task->id])
    ->with('success', 'Task updated Successfully');
    // with(); -- Creates a flash  session message indicating an operation success, this
    // message is removed after being used when displayed to the user.
    // Express equivalent:  <Link to={`../view-job/${_id}`}>Job name<Link />

})->name('tasks.update');




// OTHER ROUTES
// '/hello' is http://127.0.0.1:8000/hello
// name() a get() method is used to name a route
Route::get('/hello', function () { return 'Hello'; })->name('Hello There');

// DYNAMIC ROUTES - passing params 
// Params are defined on the server route inside /{} and passed as argument to the 
// controller. If defined like this then they passed on frontend like the following
// http://127.0.0.1:8000/greeting/simon  - simon as the param
// express equivalent: the query params are retrieved from req.query inside the controller
Route::get('/greeting/{name}', function ($name) {
    return 'Hello' . ' '. $name . '!';
})->name('Greetings Route');

// REDIRECTING TO DIRECT ROUTE USING redirect() FUNCTION
Route::get('/hallo', function () {
    // return redirect('/hello'); // same as code below but using a route name
    return redirect()->route('Hello There');
});

// FALLBACK ROUTES 
// Resource/route Not Found routes - If user tries accessing a route not defined
// on the API, give this error. Must be put after all defined routes in the API.
Route::fallback(function (){
    return 'resource/route not found';
});

// express equivalent (defined in main server file): 
// app.use("*", (req, res) => { res.status(404).json({ msg: "resource/route not found" }); });
