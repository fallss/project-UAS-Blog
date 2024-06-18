<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);

Route::middleware('throttle:10,1')->group(function () {
Route::get('/login', [loginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [loginController::class, 'login']);
Route::post('/logout', [loginController::class, 'logout'])->name('logout');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/Tech', [ArticleController::class, 'index'])->name('tech.index');
});


Route::get('/encrypt', function() {
    $encrypted = Crypt::encryptString('Sensitive data');
    return response()->json(['encrypted' => $encrypted]);
});

Route::get('/decrypt', function() {
    $encrypted = Request('encrypted_data');
    $decrypted = Crypt::decryptString($encrypted);
    return response()->json(['decrypted' => $decrypted]);
});

Route::get('/encrypt', [DataController::class, 'encryptData']);
Route::match(['get', 'post'], '/decrypted',[DataController::class, 'decryptData']);
Route::get('decrypted', [DataController::class, 'showDecryptedForm']);

Route::get('/register', [UserController::class, 'showRegistrationForm']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/tech', [ArticleController::class, 'index']);
Route::post('/tech/create', [ArticleController::class, 'store'])->name('tech.create');

?>

