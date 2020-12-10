<?php
    namespace App\Http\Controllers;
    
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use App\Models\UserJob;
    use App\Traits\ApiResponser;
    use DB;



Class UserJobController extends Controller {
    use ApiResponser;
    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function index(){
        $usersjob = UserJob::all();
        return $this->successResponse($usersjob);}

    public function show($id){
        $userjob = UserJob::findOrFail($id);
        return $this->successResponse($userjob);
    }
}

