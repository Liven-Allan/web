<?php
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\PatronController; 
use App\Http\Controllers\ResearchAssistantController; 
use App\Mail\ParticipantNotification;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PublicationController;



use App\Http\Controllers\TextImageController;
Route::get('/icon/{id}.svg', [TextImageController::class, 'generateSvg']);


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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/',[TemplateController::class,'index']);
Route::get('/',[TemplateController::class,'index']);
Route::get('/publications', [PatronController::class, 'publications']);
// Route::get('/publications', [PatronController::class, 'index']);

// Route::get('/publications', [PatronController::class, 'publications']);
// Route::get('/publications/create', [PatronController::class, 'create']);
// Route::get('/patron/createpublications', [PatronController::class, 'createPublication'])->name('publications.create');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//admin route
Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/admin/task/create', [TemplateController::class, 'createTask'])->name('admin.task.create'); 
    Route::post('/admin/task/create', [TemplateController::class, 'storeTask'])->name('admin.task.store'); 
    Route::get('/admin/tasks', [TemplateController::class, 'listTasks'])->name('admin.task.list');
    
    // Add Edit Task route for admin
    Route::get('/admin/task/{task}/edit', [TemplateController::class, 'edit'])->name('admin.task.edit'); 
    Route::put('/admin/task/{task}', [TemplateController::class, 'update'])->name('admin.task.update'); 

    //delete task
    Route::delete('/admin/task/{task}', [TemplateController::class, 'destroy'])->name('admin.task.destroy');

    // register users
    Route::get('/admin/register-user', [AdminController::class, 'showRegisterUserForm'])->name('admin.register_user');
    Route::post('/admin/register-user', [AdminController::class, 'registerUser'])->name('admin.register_user.store');

     // View Users
    Route::get('/admin/users', [AdminController::class, 'listUsers'])->name('admin.users.list');
    Route::delete('/admin/users/{id}/delete', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

      // View Active Tasks for Admin
    Route::get('/admin/active-tasks', [TemplateController::class, 'listAdminActiveTasks'])->name('admin.active_tasks');
    Route::post('/admin/active-tasks/{id}/comment', [TemplateController::class, 'addComment'])->name('admin.add_comment');
    Route::post('/admin/active-tasks/{id}/confirm', [TemplateController::class, 'confirmTaskCompletion'])->name('admin.confirm_task');
});
    //patron route
    Route::middleware(['auth','role:patron'])->group(function () {
    Route::get('/patron/dashboard',[PatronController::class,'dashboard'])->name('patron.dashboard');
    Route::get('/patron/task/create', [TemplateController::class, 'createTask'])->name('patron.task.create'); // GET route for form
    Route::post('/patron/task/create', [TemplateController::class, 'storeTask'])->name('patron.task.store'); 
    Route::get('/patron/tasks', [TemplateController::class, 'listTasks'])->name('patron.task.list');
    Route::get('/patron/publications', [PatronController::class, 'publications']);

    Route::get('/patron/createpublications', [PatronController::class, 'createPublication'])->name('patron.createPublication');
   // Route::post('/patron/storepublications', [PatronController::class, 'storePublication'])->name('patron.storepublication');

    //Route::post('/patron/storepublications', [PatronController::class, 'storePublication'])->name('publications.store');
    
    
    // Route for storing publications (you may already have this)
    Route::post('/storepublications', [PatronController::class, 'storePublication'])->name('publications.store');
   // Route::get('/publications', [PatronController::class, 'publications'])->name('publications');
   Route::get('/publications', [PatronController::class, 'publications'])->name('publications');

    // Add Edit Task route for patron
    Route::get('/patron/task/{task}/edit', [TemplateController::class, 'edit'])->name('patron.task.edit');
    Route::put('/patron/task/{task}', [TemplateController::class, 'update'])->name('patron.task.update');

    // delete task
    Route::delete('/patron/task/{task}', [TemplateController::class, 'destroy'])->name('patron.task.destroy');

    // register users
    Route::get('/patron/register-user', [PatronController::class, 'showRegisterUserForm'])->name('patron.register_user');
    Route::post('/patron/register-user', [PatronController::class, 'registerUser'])->name('patron.register_user.store');
    
     // View Users
    Route::get('/patron/users', [PatronController::class, 'listUsers'])->name('patron.users.list');
    Route::delete('/patron/users/{id}/delete', [PatronController::class, 'deleteUser'])->name('patron.users.delete');
    
    // View Active Tasks for Patron
    Route::get('/patron/active-tasks', [TemplateController::class, 'listPatronActiveTasks'])->name('patron.active_tasks');
    Route::post('/patron/active-tasks/{id}/comment', [TemplateController::class, 'addComment'])->name('patron.add_comment');
    Route::post('/patron/active-tasks/{id}/confirm', [TemplateController::class, 'confirmTaskCompletion'])->name('patron.confirm_task');
});
//research_assistant route
Route::middleware(['auth','role:research_assistant'])->group(function () {
    Route::get('/research_assistant/dashboard',[ResearchAssistantController::class,'dashboard'])->name('research_assistant.dashboard');
    Route::get('/research-assistant/tasks', [TemplateController::class, 'listTasksForResearchAssistant'])->name('research_assistant.task.list');
     // Route to activate a task
    Route::post('/research-assistant/tasks/{task}/activate', [TemplateController::class, 'activateTask'])->name('research_assistant.task.activate');
     // Route to view active tasks
    Route::get('/research-assistant/active-tasks', [TemplateController::class, 'listActiveTasks'])->name('research_assistant.active_tasks');
    Route::get('/research-assistant/tasks/{id}/record-progress', [TemplateController::class, 'recordProgress'])->name('research_assistant.task.record_progress');
    Route::patch('/research-assistant/tasks/{id}/update-progress', [TemplateController::class, 'updateProgress'])->name('research_assistant.task.update_progress');

});

require __DIR__.'/auth.php';
