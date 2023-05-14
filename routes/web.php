<?php

use App\Role;
use App\User;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

//CRUD eloquent many to many                                                   //////////////below also attache detach and sync
Route::get('/create', function () {
    $user = User::find(1);
    //$role = new Role; could have left it like this but we are injecting it with an array
    $user->roles()->save(new Role(['name'=>'Subscriber']));
});

Route::get('/read', function(){
$user = User::findOrFail(2);  
foreach($user->roles as $role){
    echo $role->name;
}
});


Route::get('/update', function(){
   $user = User::findOrFail(1);
   if($user->has('roles')){               //method to find out if a user has relationship
    foreach($user->roles as $role){
        if($role->name =='subscriber'){
            $role->name = 'Administrator';
            $role->save();
            }
        }
    }
    });


Route::get('/delete', function(){
     $user = User::findOrFail(1);
     foreach($user->roles as $role){
        $role->whereId(1)->delete();
     }
});





//attch a role to our user -> create a new record and attaches even when it exists
Route::get('/attach', function(){ 
    $user=User::findOrFail(1);    //attach adds to the role to the pivot table not the roles table
    $user->roles()->attach(6);  
});


Route::get('/detach', function(){    //detach takes away the role at the pivot table not from the roles table
    $user=User::findOrFail(1);
    $user->roles()->detach();
});


Route::get('/sync', function(){
    $user=User::findOrFail(2);
    $user->roles()->sync([1,2]);  //if not in array will delete the rest in the pivot table
    //adds roles 1 and 2 tot he user and deletes the rest of its roles
   
});


