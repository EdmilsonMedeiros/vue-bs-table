<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/getUsers', function(Request $request){
    // return $request;
    $search     = $request->searched ?? null;
    $page       = $request->page ?? 1;
    $sortBy     = $request->sortBy ?? null;
    $orderAs    = $request->orderAs ?? null;

    $users = User::orderBy($sortBy ?? 'id', $orderAs ?? 'DESC')
    ->paginate($request->itemsPerPage, ['*'], 'page', $page);
    
    if($search != null){
        $users = User::orderBy($sortBy ?? 'id', $orderAs ?? 'DESC')
            ->where('name', 'LIKE', "%$search%")
            ->orWhere('email', 'LIKE', "%$search%")
            ->orWhere('created_at', 'LIKE', "%$search%")
            ->orWhere('birthday', 'LIKE', "%$search%")
            ->paginate($request->itemsPerPage, ['*'], 'page', $page);
    }

    $users['last_page'] = User::count() / $request->itemsPerPage;

    return response()->json($users);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
