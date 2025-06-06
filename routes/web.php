<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function() {
    return redirect()->route('tasks.index');
});

Route::get('/tasks', function () {
    return view('index', [
        'tasks' => Task::latest()->paginate()
    ]);
})->name('tasks.index');

Route::view('/tasks/create', 'create')
    ->name('tasks.create');

Route::get('/tasks/{task}', function (Task $task){

    return view('show', [
        'task' => $task
    ]);
})->name('tasks.show');

Route::get('/tasks/{task}/edit', function (Task $task){

    return view('edit', [
        'task' => $task
    ]);
})->name('tasks.edit');

// store
Route::post('/tasks', function (TaskRequest $request) {
    $task = Task::create($request->validated());
    return redirect()->route("tasks.show", ['task'=> $task->id])
    ->with('success', 'Task created successfully!');
})->name('tasks.store');

// update
Route::put('/tasks/{task}', function (Task $task, TaskRequest $request) {
    $task->update($request->validated());
    return redirect()->route("tasks.show", ['task'=> $task->id])
    ->with('success', 'Task updated successfully!');
})->name('tasks.update');

// delete
Route::delete('/tasks/{task}', function (Task $task) {
    $task->delete();

    return redirect()->route('tasks.index')
    ->with('success', 'Task deleted successfully!');
})->name('tasks.destroy');
Route::fallback(function () {
    return 'Still got somewhere!';
});
