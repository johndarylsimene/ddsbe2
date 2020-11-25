<?php
    namespace App\Http\Controllers;
    
    use Illuminate\Http\Request;
	use Illuminate\Http\Response;
    use App\Models\User;
    use App\Traits\ApiResponser;
    use DB;



Class UserController extends Controller {
    use ApiResponser;
    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function login(){
        return view('login');
    }

    //user validation
    public function validation(){
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        $user = User :: all();
        $pass = false;
        $user = DB::connection('mysql') ->select("Select * from tbluser where username = '$username'");

        if($user){
            foreach ($user as $name){
                if($password == $name->password ){
                    echo '<script>alert("Welcome!")</script>';
                    return view('login');
                }
                else{
                    echo '<script>alert("Incorrect Credentials")</script>';
                    return view('login');
                }   
            }  
        }
        else{
            echo '<script>alert("Incorrect Credentials")</script>';
            return view('login');
        }
    }

    public function show(){
        $users = User::all(); 
        return $this->successResponse($users);   
    }

    public function addUser(Request $request){
        $rule=[
            'username' => 'required|max:20',
            'password' => 'required|max:20',
        ];
        $this->validate($request, $rule);
        $users = User::create($request -> all());
        return $this->successResponse($users);
    }

    public function index($id){$users = User::where('id',$id)->first();
        
        if ($users){
            return $this->successResponse($users);
        }
        else{
           return $this->errorResponse('User not Found',Response::HTTP_NOT_FOUND);
        }

    }


    public function updateUser(Request $request, $id){
        $rule=[
            'username' => 'max:20',
            'password' => 'max:20',
        ];

        $this->validate($request, $rule);
        $users = User::where('id',$id)->first();

        if($users){
            $users->fill($request->all());

            if($users->isClean()){
                return $this->errorResponse("NO CHANGES HAVE BEEN MADE.", Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
        else{
            return $this->errorResponse("USER NOT FOUND",Response::HTTP_NOT_FOUND);
            }
        $users->save();
        return $this->successResponse($users);
    }

    public function removeUser($id){
        $user = user::where('id', $id)->first();
        
        if($user){
            $user->delete();
            return $this->successResponse($user);}
        else{
            return $this->errorResponse('User ID Does NOT Exists', Response::HTTP_NOT_FOUND);
        }
    }


}

