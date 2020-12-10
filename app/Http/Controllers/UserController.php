<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
	use Illuminate\Http\Response;
    use App\Models\UserJob;
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
        $user = User::all(); 
        return $this->successResponse($user);   
    }

    public function index($id){
        $user = User::where('id',$id)->first();
        
        if ($user){
            return $this->successResponse($user);
        }
        else{
           return $this->errorResponse('User not Found',Response::HTTP_NOT_FOUND);
        }

    }

    public function updateUser(Request $request, $id){
        $rule=[
            'username' => 'max:20',
            'password' => 'max:20',
            'jobID' => 'required|numeric|min:1|not_in:0',
        ];

        $this->validate($request, $rule);

        $userjob = UserJob::findOrFail($request->jobID);
        $user = User::findOrFail($id);
        $user->fill($request->all());

        if($user->isClean()){
                return $this->errorResponse("At least one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();
        return $this->successResponse($user);
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

    public function addUser(Request $request ){
        $rules = [
        'username' => 'required|max:20',
        'password' => 'required|max:20',
        'jobID' => 'required|numeric|min:1|not_in:0',
        ];
        $this->validate($request,$rules);

        $userjob = UserJob::findOrFail($request->jobID);
        $user = User::create($request->all());
        return $this->successResponse($user,Response::HTTP_CREATED);

    }

}

