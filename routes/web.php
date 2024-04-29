<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CustomerController;

use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Role;
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

// Authentication and Google OAuth Routes
Route::get('auth/google', [AuthController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/callback', [AuthController::class, 'callbackGoogle'])->name('google.callback');

// Login and Logout Routes
Route::get('/login', [PagesController::class, 'Login'])->name('login')->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Default redirect to login
Route::get('/', function () {
    return redirect('/login');
});

// Authenticated Routes
Route::middleware(['auth','checkrole'])->group(function () {
    Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');
    Route::resource('leads', LeadController::class);

    // Leads Management
    Route::post('/leads/{lead}/approve', [LeadController::class, 'approve'])->name('leads.approve');
    Route::post('/leads/{lead}/disapprove', [LeadController::class, 'disapprove'])->name('leads.disapprove');
    Route::get('/lead-approvals', [LeadController::class, 'approvalIndex'])->name('lead.approvals.index');
    

    // User management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Permissions and Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/{id}/edit-permissions', [RoleController::class, 'editPermissions'])->name('roles.edit_permissions');
    Route::put('/roles/{id}/update-permissions', [RoleController::class, 'updatePermissions'])->name('roles.update_permissions');
    Route::get('permissions/create', [RoleController::class, 'createPermission'])->name('permissions.create');
    Route::post('permissions/store', [RoleController::class, 'storePermission'])->name('permissions.store');

    // Customer Management Routes
Route::prefix('customers')->name('customers.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
});

});

// Admin specific routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::delete('/leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
});

//TESTING ROUTES
Route::get('/pending-role', function () {
    return view('notifications.pending-role');
})->name('pending-role');


// EMAIL SEND ROUTE
// Route::post('/send-email', [EmailController::class, 'sendEmail'])->name('send.email');
// Route::get('/email-form', [EmailController::class, 'showForm'])->name('email.form');

Route::get('/send-test-email', function () {
    Mail::to('mail.tomsan@gmail.com')->send(new TestEmail());
    return 'Email has been sent!';
});

Route::get('test-role/{role_id}', function ($role_id) {
    return Role::find($role_id);
});



    // IGNORE START

    Route::prefix('ManageCourses')->group(function () {
        Route::get('/', [PagesController::class, 'ManageCourses'])->name('ManageCourses');
        Route::get('/AddCategoryCourses', [PagesController::class, 'AddCategoryCourses'])->name('AddCategoryCourses');
        Route::get('/EditCategoryCourses/{id}', [PagesController::class, 'EditCategoryCourses'])->name('EditCategoryCourses');
        Route::post('/EditedCategoryCourses/{id}', [CrudController::class, 'EditedCategoryCourses'])->name('EditedCategoryCourses');
        Route::post('/AddedCategoryCourses', [CrudController::class, 'AddedCategoryCourses'])->name('AddedCategoryCourses');
        Route::get('/DeleteCategoryCourses/{id}', [CrudController::class, 'DeleteCategoryCourses'])->name('DeleteCategoryCourses');
    });
        Route::prefix('ManageAttendence')->group(function () {
        Route::get('/', [PagesController::class, 'ManageAttendence'])->name('ManageAttendence');
        Route::get('/AddAttendence', [PagesController::class, 'AddAttendence'])->name('AddAttendence');
        Route::get('/EditAttendence', [PagesController::class, 'EditAttendence'])->name('EditAttendence');
    });
        Route::prefix('ManageEnrollment')->group(function () {
        Route::get('/', [PagesController::class, 'ManageEnrollment'])->name('ManageEnrollment');
        Route::get('/AddEnrollment', [PagesController::class, 'AddEnrollment'])->name('AddEnrollment');
        Route::get('/EditEnrollment/{id}', [PagesController::class, 'EditEnrollment'])->name('EditEnrollment');
        Route::post('/EditedEnrollment/{id}', [CrudController::class, 'EditedEnrollment'])->name('EditedEnrollment');
        Route::post('/AddedEnrollment', [CrudController::class, 'AddedEnrollment'])->name('AddedEnrollment');
        Route::get('/DeleteEnrollment/{id}', [CrudController::class, 'DeleteEnrollment'])->name('DeleteEnrollment');
    });
        Route::prefix('ManageQuiz')->group(function () {
        Route::get('/', [PagesController::class, 'ManageQuiz'])->name('ManageQuiz');
        Route::get('/AddQuiz', [PagesController::class, 'AddQuiz'])->name('AddQuiz');
        Route::post('/AddedQuiz', [CrudController::class, 'AddedQuiz'])->name('AddedQuiz');

        Route::prefix('{courses}')->group(function () {
            Route::get('/', [PagesController::class, 'Quiz'])->name('Quiz');
            Route::get('/AddQuizDetail', [PagesController::class, 'AddQuizDetail'])->name('AddQuizDetail');
            Route::get('/EditQuiz/{id}', [PagesController::class, 'EditQuiz'])->name('EditQuiz');
            Route::post('/EditedQuiz/{id}', [CrudController::class, 'EditedQuiz'])->name('EditedQuiz');
            Route::post('/AddedQuizDetail', [CrudController::class, 'AddedQuizDetail'])->name('AddedQuizDetail');
            Route::get('/DeleteQuiz/{id}', [CrudController::class, 'DeleteQuizDetail'])->name('DeleteQuizDetail');
            Route::get('/DeleteQuiz/{id}', [CrudController::class, 'DeleteQuiz'])->name('DeleteQuiz');
            
            Route::prefix('QuizDetail/{id}')->group(function () {
                Route::get('/', [PagesController::class, 'QuizDetail'])->name('QuizDetail');
                Route::get('/AddQuestion', [PagesController::class, 'AddQuestion'])->name('AddQuestion');
                Route::post('/AddedQuestion', [CrudController::class, 'AddedQuestion'])->name('AddedQuestion');
                
                Route::prefix('')->group(function () {
                    Route::get('/EditQuizDetail/{QuestionID}', [PagesController::class, 'EditQuizDetail'])->name('EditQuizDetail');
                    Route::post('/EditedQuizDetail/{QuestionID}', [CrudController::class, 'EditedQuizDetail'])->name('EditedQuizDetail');
                    Route::get('/DeleteQuestion/{QuestionID}', [CrudController::class, 'DeleteQuestion'])->name('DeleteQuestion');
                    Route::get('/DeleteOption/{OptionID}', [CrudController::class, 'DeleteOption'])->name('DeleteOption');
                });
            });
        });
    });

    Route::prefix('ManageEnrollment')->group(function () {
        Route::get('/', [PagesController::class, 'ManageEnrollment'])->name('ManageEnrollment');
        Route::get('/AddEnrollment', [PagesController::class, 'AddEnrollment'])->name('AddEnrollment');
        Route::get('/EditEnrollment/{id}', [PagesController::class, 'EditEnrollment'])->name('EditEnrollment');
        Route::post('/EditedEnrollment/{id}', [CrudController::class, 'EditedEnrollment'])->name('EditedEnrollment');
        Route::post('/AddedEnrollment', [CrudController::class, 'AddedEnrollment'])->name('AddedEnrollment');
        Route::get('/DeleteEnrollment/{id}', [CrudController::class, 'DeleteEnrollment'])->name('DeleteEnrollment');

        Route::prefix('{category}')->group(function () {
            Route::get('', [PagesController::class, 'DetailEnrollment'])->name('DetailEnrollment');
            Route::get('/AddDetailEnrollment', [PagesController::class, 'AddDetailEnrollment'])->name('AddDetailEnrollment');
            Route::get('/EditDetailEnrollment/{id}', [PagesController::class, 'EditDetailEnrollment'])->name('EditDetailEnrollment');
            Route::post('/AddedDetailEnrollment', [CrudController::class, 'AddedDetailEnrollment'])->name('AddedDetailEnrollment');
            Route::get('/DeleteDetailEnrollment/{id}', [CrudController::class, 'DeleteDetailEnrollment'])->name('DeleteDetailEnrollment');
            Route::post('/EditedDetailEnrollment/{id}', [CrudController::class, 'EditedDetailEnrollment'])->name('EditedDetailEnrollment');
        });
    });

        Route::prefix('DataUser')->group(function () {
        Route::get('/', [PagesController::class, 'DataUser'])->name('DataUser');
        Route::get('/DetailUser', [PagesController::class, 'DetailUser'])->name('DetailUser');
        Route::get('/AddUser', [PagesController::class, 'AddUser'])->name('AddUser');
        Route::get('/EditUser/{id}', [PagesController::class, 'EditUser'])->name('EditUser');
        Route::post('/EditedUser/{id}', [CrudController::class, 'EditedUser'])->name('EditedUser');
        Route::get('/DeletedUser/{id}', [CrudController::class, 'DeletedUser'])->name('DeletedUser');
    });

    // IGNORE END



