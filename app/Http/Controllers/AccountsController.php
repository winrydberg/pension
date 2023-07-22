<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AccountsController extends Controller
{
    public function newStaff(Request $request){
        $departments = Department::all();
        $roles = Role::all();
        $permissions = Permission::all();
        return view('accounts.newstaff', compact('departments', 'roles','permissions'));
    }

    public function staffs(){
        $users = User::all();
        return view('accounts.staffs', compact('users'));
    }

    public function updateStaffAccountState(Request $request){
        try{
            $staff = User::where('id', $request->id)->first();
            if($staff){
                $staff->update([
                    'is_active' => $request->state
                ]);
                $message = 'Staff account successfully deactivated';
                if($request->state ==1){
                    $message = 'Staff account successfully activated';
                }
                return response()->json([
                    'status' => 'success',
                    'message' => $message
                ]);

            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Staff account not found. Please refresh page and try again'
                ]);
            }
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unble to deactivate staff account. Please contact administrators'
            ]);
        }
    }


    public function saveStaff(Request $request){
        try{
            // return $request->all();
            $staff = User::where('email', $request->email)->first();
            if($staff){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Staff account already exist. Please use a difference email'
                ]);

            }else{
                $userDetails = $request->all();
                $userDetails['password'] = Hash::make($userDetails['password']);
                $user = User::create($userDetails);

                if(array_key_exists('permissions', $userDetails)){
                    foreach($userDetails['permissions'] as $p){
                        $permission = Permission::find($p);
                        if($permission){
                            $user->givePermissionTo($permission->name);
                        }
                    }
                }

                if(array_key_exists('roles', $userDetails)){
                    foreach($userDetails['roles'] as $r){
                        $role = Role::find($r);
                        if($role){
                            $user->assignRole($role->name);
                        }
                    }
                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Staff account successfully created on platform'
                ]);
            }
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unble to add staff account. Please contact administrators'
            ]);
        }
    }


    public function editStaff(Request $request){
        $staffid = $request->query('staffid', null);

        $staff = User::with('roles', 'permissions')->where('id', $staffid)->first();

        

        if($staff == null){
            return back()->with('error', 'Staff account not found');
        }

        $departments = Department::all();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('accounts.editstaff', compact('staff','departments', 'roles', 'permissions'));
    }

    public function saveNewStaffInfo(Request $request){
        try{
            
            // $exist = User::where('email', $request->email)->first();
            // if($exist){
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => 'Staff Email address already in use by another staff. please use a different email'
            //     ]);
            // }
            // $staff =  $this->userRepository->getUserById($request->staffid);
            $staff = User::find($request->userid);

            

            if($staff == null){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Staff account not found.'
                ]);
            }

           
            $permissions = Auth::user()->permissions->pluck('name');
            $roles = Auth::user()->roles->pluck('name');
            if($request->permissions == null ){
                $permissions = [];
            }else{
                $permissions = Permission::whereIn('id', $request->permissions)->pluck('name');
            }

            if($request->roles == null){
                $roles = [];
            }else{
                $roles = Role::whereIn('id', $request->roles)->pluck('name');
            }
            
            
            // dd($staff);
            $staff->syncPermissions($permissions);
            $staff->syncRoles($roles);

            return response()->json([
                'status' => 'success',
                'message' => 'Staff Information successfully updated'
            ]);

            
        }catch(Exception $e){
            Log::error('STAFF_EDIT_ERROR =>'.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Opps something went wrong.Pleasetry again later'
            ]);
        }
    }
}
