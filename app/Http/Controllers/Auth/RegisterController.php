<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Photo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string',
            'photo' =>'string',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
       /* return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);*/
    }
        //ajouter user
    public function store(Request $request){
       /* $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
           
        ]);*/

        $user = new User();
        $user->name = $request->names;
        $user->email=$request->email;
        $user->role=$request->role;
        $user->password =  Hash::make($request->password);
        
        if($request->get('photo'))
        {
             $photo = $request->get('photo');
             $namePhoto = time().'.' . explode('/', explode(':', substr($photo, 0, strpos($photo, ';')))[1])[1];
             \Image::make($request->get('photo'))->save(public_path('images/').$namePhoto);
             $user->photo = $namePhoto;
        }
        else {
            $user->photo = '';
        }
            $user->save();
        
     return Response()->json(['etat'=>true]);
    }
        //supprimer user
    public function destroy(Request $request,$id){
            $user=User::find($id);
            $user->delete();
        return Response()->json(['etat'=>true]);        
    }
       // afficher users 
    public function getUsers(){
            $users = User::all();
        return Response()->json(['users'=>$users]);
        
    }
        //recuperer donnees user
    public function editUser($id){
            $user = User::find($id);
        return Response()->json(['user'=>$user]);
    }
        //modifier user
    public function updateUser(Request $request){
            $user=User::find($request->id);
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=Hash::make($request->password);
            $user->role=$request->role;


            if($request->get('photo'))
            {
              if(strlen($request->get('photo')) < 40 ){
               $user->photo = $request->get('photo');
             }else {
               $photo = $request->get('photo');
               $namePhoto = time().'.' . explode('/', explode(':', substr($photo, 0, strpos($photo, ';')))[1])[1];
               \Image::make($request->get('photo'))->save(public_path('images/').$namePhoto);
               $user->photo = $namePhoto;}
            }

            else {
               $user->photo = '';
            }
               $user->save();
        return Response()->json(['etat'=>true]);
    
    }
}
