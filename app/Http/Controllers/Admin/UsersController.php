<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // ( User.php ) this represents the users table

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(){
        $all_users = $this->user->withTrashed()->latest()->paginate(5);
        return view('admin.users.index')->with('all_users', $all_users);
        # the withTrashed() will include the soft deleted users in the query result
    }

    public function deactivate($id){
        $this->user->destroy($id);
        return redirect()->back();
    }

    public function activate($id){
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
        # Note: the ( onlyTrashed() ) retrieves the soft deleted user only
        # Note: the restore() is going "un-delete" a soft delete user. This will set the deleted_at column in your users table to null
    }
}
