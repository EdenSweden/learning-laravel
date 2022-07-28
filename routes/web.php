<?php

//  TO CREATE A NEW CONTROLLER, SAY php artisan make:controller ControllerNameHere

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//This is used below in get request:
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//NAMING CONVENTIONS FOR COMMON RESOURCE ROUTES:
// index - Show all listings
// show = show single listing
// create = show form to create new listing
// store = store new listing
// edit = show form to edit listing
// update - update listing
// destroy - delete listing

//THIS IS WHY WE CHANGED LISTINGS.BLADE.PHP AND LISTING.BLADE.PHP TO INDEX.BLADE.PHP AND SHOW.BLADE.PHP RESPECTIVELY AND PLACE THEM WITHIN A LISTINGS FOLDER. This requires us to change ListingController file from view 'listing' to 'listings.index', etc.

//to make actual model for listings in db, go to command line and type php artisan make:model Listing and it will create a class with access to the Eloquent ORM:

// GET ALL LISTINGS:
    // (second arg here is a way to pass data into view page--in this case, the ListingController. Syntax is [ControllerName::class, method-to-use]):
Route::get('/', [ListingController::class, 'index']);

// SHOW CREATE LISTING FORM:
//Middleware to make sure only guests (not logged-in users) can access this route:
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// STORE LISTING DATA:
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//SHOW EDIT FORM. Shows form to update:
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//UPDATE LISTING. Actually performs the update:
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//DELETE LISTING:
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// GET SINGLE LISTING:
//This uses Eloquent model binding. Automatic 404 functionality if the id entered in the url doesn't actually exist as a page, etc. 
//This must be at the bottom because otherwise, other /listings routes won't work
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//SHOW REGISTER/CREATE FORM:
//middleware to make route only accessible to guests (not logged in users):
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//CREATE NEW USER:
Route::post('/users', [UserController::class, 'store']);

//LOG USER OUT:
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//SHOW LOGIN FORM:
//note how you can chain the name and the middleware to a single route
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

//LOG IN USER:
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

//NOTES ON ROUTING:

// Route::get('/hello', function(){
//     //optional second arg is status code.
//     return response('<h1>Hello World</h1>', 200)
//     //The next line(s) can be used to set headers
//     ->header('Content-Type', 'text/plain')
//     //can do custom headers too:
//     ->header('foo', 'bar');
// });

// // set url req parameters like so:
// Route::get('/posts/{id}', function($id){
//     // "die dump" helper method to see the params passed. Will stop the function:
//     // dd($id);
//     // "die dump debug" helper method for more info:
//     // ddd($id);
//     return response('Post ' . $id);
//     // make a constraint for the passed param as so:
// })->where('id', '[0-9]+');

// //more url parameters:
// //e.g. localhost:8000/search?name=Brad&city=Boston
// Route::get('/search', function(Request $request) {
//     return $request->name . ' ' . $request->city;
// });
