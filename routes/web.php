<?php
use App\Http\Controllers\GuestController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatronController;
use App\Http\Controllers\ResearchAssistantController;
use App\Mail\ParticipantNotification;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllProjectsController;
use App\Http\Controllers\NewsController;


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
Route::get('/', [TemplateController::class, 'index'])->name('home');
//Route::get('/people', [TemplateController::class, 'people'])->name('people');
Route::get('/peoplepage', [TemplateController::class, 'peoplepage'])->name('peoplepage');

Route::get('/Allprojects', [PatronController::class, 'Allprojects'])->name('Allprojects');
Route::get('/publications', [TemplateController::class, 'publications'])->name('publications');
Route::get('/courses', [TemplateController::class, 'courses'])->name('courses');
Route::get('/newz', [NewsController::class, 'index'])->name('newz');
Route::get('/news', [NewsController::class, 'create'])->name('news.create');
Route::get('/news', [NewsController::class, 'edit'])->name('news.edit');
Route::get('/news', [NewsController::class, 'store'])->name('news.store');


Route::get('/events', [TemplateController::class, 'events'])->name('events');
Route::get('/description', [PatronController::class, 'showDescription'])->name('description');
Route::get('/projectDetails', [TemplateController::class, 'displayProjectdetails']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//admin route
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
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
    Route::post('/admin/users/{id}/disable', [AdminController::class, 'disableUser'])->name('admin.users.disable');
    Route::post('/admin/users/{id}/enable', [AdminController::class, 'enableUser'])->name('admin.users.enable');
    // Edit/Update Users
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');

    // View Active Tasks for Admin
    Route::get('/admin/active-tasks', [TemplateController::class, 'listAdminActiveTasks'])->name('admin.active_tasks');
    Route::post('/admin/active-tasks/{id}/comment', [TemplateController::class, 'addComment'])->name('admin.add_comment');

    Route::post('/admin/active-tasks/{id}/confirm', [TemplateController::class, 'confirmTaskCompletion'])->name('admin.confirm_task');
    Route::get('/admin/update-description', function () {
        return view('admin.editDescription'); // Ensure this file exists in resources/views/patron/
    })->name('admin.editDescription');
    Route::post('/admin/update-description-text', [AdminController::class, 'updateDescription'])->name('admin.updateDescription');



});

//patron route
Route::middleware(['auth', 'role:patron'])->group(function () {
    Route::get('/patron/dashboard', [PatronController::class, 'dashboard'])->name('patron.dashboard');
    Route::get('/patron/task/create', [TemplateController::class, 'createTask'])->name('patron.task.create'); // GET route for form
    Route::post('/patron/task/create', [TemplateController::class, 'storeTask'])->name('patron.task.store');
    Route::get('/patron/tasks', [TemplateController::class, 'listTasks'])->name('patron.task.list');

    //editing the description on the landing page
    Route::post('/patron/update-description-text', [PatronController::class, 'updateDescriptionText'])->name('patron.updateDescriptionText');

    Route::get('/patron/projects', [PatronController::class, 'projects']);

    Route::get('/patron/createprojects', [PatronController::class, 'createProject'])->name('patron.createProject');

    Route::get('/projects', [PatronController::class, 'index'])->name('projects');


    Route::get('/projects', [AllProjectsController::class, 'index'])->name('projects');
    // Route for storing projects
    Route::post('/storeprojects', [PatronController::class, 'storeProject'])->name('projects.store');

    Route::get('/projects', [PatronController::class, 'projects'])->name('projects');

    // Show edit form for a project
    Route::get('projects/{project}/edit', [PatronController::class, 'edit'])->name('projects.edit');

    // Update project
    Route::put('projects/{project}', [PatronController::class, 'update'])->name('projects.update');

    // Delete project
    Route::delete('projects/{project}', [PatronController::class, 'destroy'])->name('projects.destroy');
    //Route::get('/projects', [PatronController::class, 'index'])->name('projects.index');

    Route::get('/patron/update-description', function () {
        return view('patron.editDescription'); // Ensure this file exists in resources/views/patron/
    })->name('patron.editDescription'); // 

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
    Route::post('/patron/users/{id}/disable', [PatronController::class, 'disableUser'])->name('patron.users.disable');
    Route::post('/patron/users/{id}/enable', [PatronController::class, 'enableUser'])->name('patron.users.enable');
    // Edit/Update Users (limited)
    Route::get('/patron/users/{id}/edit', [PatronController::class, 'editUser'])->name('patron.users.edit');
    Route::put('/patron/users/{id}', [PatronController::class, 'updateUser'])->name('patron.users.update');

    // View Active Tasks for Patron
    Route::get('/patron/active-tasks', [TemplateController::class, 'listPatronActiveTasks'])->name('patron.active_tasks');
    Route::post('/patron/active-tasks/{id}/comment', [TemplateController::class, 'addComment'])->name('patron.add_comment');
    Route::post('/patron/active-tasks/{id}/confirm', [TemplateController::class, 'confirmTaskCompletion'])->name('patron.confirm_task');
});



//research_assistant route
Route::middleware(['auth', 'role:research_assistant'])->group(function () {
    Route::get('/research_assistant/dashboard', [ResearchAssistantController::class, 'dashboard'])->name('research_assistant.dashboard');
    Route::get('/research-assistant/tasks', [TemplateController::class, 'listTasksForResearchAssistant'])->name('research_assistant.task.list');
    // Route to activate a task
    Route::post('/research-assistant/tasks/{task}/activate', [TemplateController::class, 'activateTask'])->name('research_assistant.task.activate');
    // Route to view active tasks
    Route::get('/research-assistant/active-tasks', [TemplateController::class, 'listActiveTasks'])->name('research_assistant.active_tasks');
    Route::get('/research-assistant/tasks/{id}/record-progress', [TemplateController::class, 'recordProgress'])->name('research_assistant.task.record_progress');
    Route::patch('/research-assistant/tasks/{id}/update-progress', [TemplateController::class, 'updateProgress'])->name('research_assistant.task.update_progress');
    Route::post('/research-assistant/change-password', [ResearchAssistantController::class, 'changePassword'])->name('research-assistant.change-password');

});

Route::resource('news', NewsController::class);

require __DIR__ . '/auth.php';
