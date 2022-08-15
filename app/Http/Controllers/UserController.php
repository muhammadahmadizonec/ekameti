<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Notifications\Events\NotificationSent;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
// use Illuminate\Support\Integer;
use App\Models\User;
use App\Models\kameti_member;
use App\Models\kameti_term_and_condition;
use App\Models\ekameti_type;
use App\Models\Ekameti;
use App\Models\reference_admin;
use App\Models\push_notification;
use App\Models\drop_kamety;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{   
    // public function __construct()
    // {   
    //     //'auth:sanctum';
    //     $this->middleware('auth:sanctum', ['except' => ['login','user_register']]);
    // }
    public function userRegitser(Request $request){
        $except = ['user_cnic','password','Mobile','Email','password','user_name','upload_frontside_cnic','upload_backside_cnic'];
        $request = request();
        $cleanup = $request->except($except);
        $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
        $validator = Validator::make($request->all(), [
            'user_cnic'=>     'required',
            'Mobile'           => 'required',
            'password'=>      'required',
            'upload_frontside_cnic' =>'required',
            'upload_backside_cnic' => 'required',
            'user_name'=>'required',
            'cnic_expiry'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['response'=>$validator->errors()], 401);      
        }
      
        if(!empty($request->input('Email'))){
            $countExistingUser = DB::table('users')->where('Email',$request->input('Email'))->count();
            if($countExistingUser >= 1){
                return ["response" => ["status" => "Error","message" => "The user with this email or mobile already exists"]];
            }
        }
        if(!empty($request->input('Mobile'))){
           $numberToVerify = $request->input('Mobile');
           $info = "";
        if(strpos($numberToVerify,'0') == 0 && strlen($numberToVerify) == 10){
            $info = "0".$numberToVerify;
        }
        }
        
        $countExistingUser = DB::table('users')->where('Mobile',$request->Mobile)->count();

            if($countExistingUser >= 1){
                return ["response" => ["status" => "Error","message" => "The user with this email or mobile already exists"]];
            }
            // $user = Auth::user();
            $api_token = Str::random(60);
            $date = Date("Y-m-d H:i:s");
            // $EOTP = rand(1111,9999);
            // $MOTP = rand(1111,9999);
            $user_cnic = $request->input('user_cnic');
            $cnic_expiry =$request->input('cnic_expiry');
            $user_name = $request->input('user_name');
            $Email = $request->input('Email');
            $Mobile =$request->input('Mobile');
            $password = $request->input('password');
            $gender = $request->input('gender');
            if($request->has('MOTP')){
              $MOTP= $request->input('MOTP');
            } else{
                    $MOTP='';
            }
           
           
            // $image = base64_decode($request->file('image'));
            // $target_dir =  "img/user_img/"; base64
            // $newFileName = $this->rename_file("hello.png","cnic"); base64
            //     $request->file('upload_firstside_cnic')->storeAs($target_dir,$newFileName);
            //     $path = "/storage/img/user_img/" . $newFileName;
               
            // $image = base64_decode($request->file('upload_fronttside_cnic'));
          //  return $image;
        //    $image = base64_decode($request->input('upload_frontside_cnic')); base64

          
        //     $target_dir = "public/img/user_img";
        //         $newFileName = $this->rename_file("hello.png","cnic");
        //         $image->storeAs( $target_dir,$newFileName);
        //         $path = "/storage/img/user_img/" . $newFileName;

        //$image=base64_encode(file_get_contents($request->file('upload_frontside_cnic')));

    //  $base64_image = $request->input('upload_frontside_cnic'); // your base64 encoded     
    // @list($type, $file_data) = explode(';', $image);
    // @list(, $file_data) = explode(',', $file_data); 
    //$imageName ='name'.'.'.'png'; base64


    
    //Storage::put($target_dir.$newFileName, base64_decode($image)); base 64
   
//   $image=base64_encode(file_get_contents($request->file('upload_frontside_cnic')));
    $target_dir =  "img/frontside_cnic/";

    //$base64_image = $request->input('upload_frontside_cnic'); // your base64 encoded   
   
 
    $newFileName = $this->rename_file("hello.png","front_cnic"); 
    $imageName ='Hello.png'.'.'.'frontside_cnic';
  //  return $request->input('upload_frontside_cnic');
    Storage::put($target_dir.$newFileName, base64_decode($request->input('upload_frontside_cnic')));
    //Storage::put($target_dir.$newFileName,base64_decode($file_data));
    $path = "/storage"."/".$target_dir . $newFileName;
    //return $path;
    // Storage::put($imageName,base64_decode($file_data)); 
    // return $imageName;

  //  return response(['data'=>'ff']);

//   $image=base64_encode(file_get_contents($request->file('upload_frontside_cnic')));
//   $decode=base64_decode($image);
//   $path=$decode->move(base_path('\img'), $decode->getClientOriginalName());
//   return $path;

//     $folderPath = "img/"; //path location
//     $base64_image = $request->input('upload_frontside_cnic'); // your base64 encoded   
//     $image_parts = explode(";base64,", $base64_image);
//     $image_type_aux = explode("image/", $image_parts[0]);
//     $image_type = $image_type_aux[1];
//     $image_base64 = base64_decode($image_parts[1]);
//     $uniqid = uniqid();
//     $file = $folderPath . $uniqid . '.'.$image_type;

    
//     file_put_contents($file, $image_base64);
//     return response(['data'=>'ff']);

   
    
//   =Storage::put($imageName, base64_decode($file_data));

        

//$image1=base64_encode(file_get_contents($request->file('upload_backside_cnic')));


$target_dir =  "img/backside_cnic/";
$newFileName = $this->rename_file("hello.png","backside_cnic"); 
$imageName ='Hello.png'.'.'.'backside_cnic';
//Storage::put($target_dir.$newFileName, base64_decode($image1));
Storage::put($target_dir.$newFileName, base64_decode($request->input('upload_backside_cnic')));
//return $target_dir.$newFileName;
$path1 = "/storage"."/".$target_dir . $newFileName;

// $credentials = $request->only('Mobile', 'password');
// $token = Auth::attempt($credentials);
        
            // DB::table('users')->insert([
            //     'user_cnic'=>$user_cnic,
            //     'Email'=>$Email,
            //     'upload_frontside_cnic'=>$path,
            //     'upload_backside_cnic'=>$path1,
            //     'Mobile'=>$Mobile,
            //     'password'=>$password,
            //     'api_token'=>$api_token,
            //     'user_name'=>$user_name,
            //     'MOTP' => $MOTP,
            //     'gender'=>$gender,
            //     'DOB'=>$DOB

            // ]);

           $user=User::create([
                'user_cnic'=>$user_cnic,
                'cnic_expiry'=>$cnic_expiry,
                'Email'=>$Email,
                'upload_frontside_cnic'=>$path,
                'upload_backside_cnic'=>$path1,
                'Mobile'=>$Mobile,
                'password'=>$password,
                'api_token'=>$api_token,
                'user_name'=>$user_name,
                'MOTP' => $MOTP,
                'gender'=>$gender,
                'mobileConfirm'=>1
            ]);
            // $user =new User();
            // $user->user_cnic = $user_cnic;
            // $user->user_cnic = $user_cnic;
    
            if(($request->Mobile == null || empty($request->Mobile)) && !empty($request->Email))
                {
                    $headers = "MIME-Version: 1.0\r\n";
                    $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                   
                    mail($user->Email,"Ekametic Otp","Your One Time Password",$headers);
                    include($_SERVER['DOCUMENT_ROOT'] . '/include_general_settings.php');
                    $use_ac='noreply';
                    $yto=$user->Email;
                    $ysubj='your verification code is '.$user->EOTP;
                    $yattach='';
                    ymaildo($use_ac,$user->Email,$headers, $yto, $ysubj, $yattach,$_SERVER);
                }
                else if(($request->Email==null || empty($request->Email)) && !empty($request->Mobile)){
                    $msg_txt = $user->MOTP." is OTP\nPlease do not share with any one. Thanks";
                    $sendID='Ekameti OTP';

                    //sms api start working here
                    
                    $url = 'http://customers.smsmarketing.ae/app/smsapi/index.php';
                    $fields = array(
                        'key' => "5ca37c8add0f9",
                        'campaign' => "6297",
                        'routeid' => "39",
                        'type' => "text",
                        'contacts' => $user->Mobile,
                        'senderid' => 'Ekameti OTP',
                        'msg' => $user->MOTP." is OTP \nPlease do not share with any one. Thanks"
                    );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, count($fields));
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                    $result = curl_exec($ch);
                    curl_close($ch);
                }
    
                //$data = ["response" => ["status" => "Success","message" => "User registered successfully",'data'=>['user_name'=>$user_name,'password'=>$password,'MOTP'=>$MOTP,'user_cnic'=>$user_cnic,'upload_frontside_cnic'=>$path,'upload_backside_cnic'=>$path1,'upload_backside_cnic'=>$path1,'gender'=>$gender,'Email'=>$Email,'Mobile'=>$Mobile,'api_token'=>$api_token,'token'=>$user->createToken("API TOKEN")->plainTextToken,'mobileConfirm'=>$user->mobileConfirm]]];
                $data = ["response" => ["status" => "Success","message" => "User registered successfully",'data'=>['user_name'=>$user_name,'password'=>$password,'MOTP'=>$MOTP,'user_cnic'=>$user_cnic,'upload_frontside_cnic'=>$path,'upload_backside_cnic'=>$path1,'upload_backside_cnic'=>$path1,'cnic_expiry'=>$cnic_expiry,'gender'=>$gender,'Email'=>$Email,'Mobile'=>$Mobile,'api_token'=>$api_token,'mobileConfirm'=>$user->mobileConfirm]]];
                return $data;
}
   protected function rename_file($filename,$type){
        $info = pathInfo($filename);
        $extension = $info['extension'];
        $newfilename = $type . "_" . date('Y_m_d_h_i_s') . ".$extension";
        return $newfilename;
        }
    
    
    public function login(Request $request){
        $except = ['Mobile','password','Email','device_id','login_source'];
        $request = request();
        $cleanup = $request->except($except);
        $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
        $validator = Validator::make($request->all(),[
            'Mobile' => 'required',
            'password' => 'required',
            'device_id'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(['response'=>$validator->errors()], 401);      
        }
        
        $Mobile = $request->input('Mobile');
        $password = $request->input('password');
        $device_id = $request->input('device_id');
        $login_source = $request->input('login_source');
        //$token=$user->createToken("token")->plainTextToken;
        if($request->has('Mobile')&& $request->has('Email')){
            $Email = $request->input('Email');
            $result=DB::table('users')
            ->where('Email',$Email)
            ->where('Mobile',$Mobile)
            ->where('password',$password)
            ->first();
        }
        if($request->has('Mobile'))
        {
            //$result = User::where('Mobile',$Mobile)->where('password',$password)->first(); 
            $result = DB::table('users')->where('Mobile',$Mobile)->where('password',$password)->first(); 
            
        }
        
        if($result != null){

            $user_id = $result->id;
      
            $count = DB::table('users_devices')->where('user_id',$user_id)->count();
            
            // $count = DB::table('users_devices')->where('dtype',$request->login_source)
            // ->where('did',$request->device_id)->count()
    
    
            if($count == 0){
                DB::table("users_devices")->insert(["user_id"=>$user_id,"dtype"=>$request->login_source,"did"=>$request->device_id,"dateadd"=>date("Y-m-d H:i:s")]);
            }else{
                //DB::table('store_deviceid')->where('device_id', $request->device_id)->update(['device_id'=>$request->device_id]);
                DB::table("users_devices")->where('user_id',$user_id)->update(['dtype'=>$request->login_source,'did'=>$request->device_id,'updated_at'=>date('Y-m-d H:i:s')]);
            }
           
            $success['status'] = "successfully";
            $success['msg'] ="User is login successfully";
            // $success['token'] =$result->createToken("API TOKEN")->plainTextToken;
            $success['user']= $result;
            return response(['response'=>$success],200);
        }
    
        else{
            $error['status'] = "Error";
            $error['msg'] = "Incorrect Number and Password";
            return response()->json(['response'=>$error]);
        } 
    }     
    public function Update_Password(Request $request){
        $except = ['user_id','password'];
        $request = request();
        $cleanup = $request->except($except);
        $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
        $validator = Validator::make($request->all(), [
            'user_id'=>'required',
            'password'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(['response'=>$validator->errors()], 401);      
        }
        $user_id=$request->input('user_id');
        $password=$request->input('password');

        $update_password = DB::table('users')  
        ->where('id',$user_id)
        ->update(['password'=>$password]);
    if($update_password)    
    {   $user = User::where('id',$user_id)->first();
        $success['status'] = 'Success';
        $success['msg'] = 'Password is updated success';
        $success['data'] = $user;
        return response()->json(['response'=>$success]);
    }
    else {
        $error['status'] = "Fail!";
        $error['msg'] = "Password is not updated";
        return response()->json(['response'=>$error]);
    }
    }   
    public function kameti(Request $request){
        $except = ['users','user_id','ekameti_type','ekameti_Holder_full_name',  'installment','total_amount_kameti','starting_date','ending_date'];
        $request = request();
        $cleanup = $request->except($except);
        $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'ekameti_type'=>'required',
            'ekameti_Holder_full_name' =>'required',
            'installment' =>'required',
            'total_amount_kameti' => 'required',
            'starting_date' => 'required',
            'total_months' =>'required',
            'my_total_kameti' => 'required',
            'ending_date' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['response'=>$validator->errors()], 401);      
        }

        //  $members=$request->input('users');
        
        //  return $members;
        // foreach ($members as $member) {
        //     return $member['total_kameties'];
        // }
       
        $ekameti_type = $request->input('ekameti_type');
        $ekameti_Holder_full_name = $request->input('ekameti_Holder_full_name');
        $installment = $request->input('installment');
        $total_amount_kameti = $request->input('total_amount_kameti');
        $starting_date =$request->input('starting_date');
        $ending_date =$request->input('ending_date');
        $user_id = $request->input('user_id');
        $status=$request->input('status');
        $created_at = date('y-m-d H:i:s');
        $updated_at = date('y-m-d H:i:s');
        $total_months = $request->input('total_months');
        $my_total_kameti = $request->input('my_total_kameti');
        $total_ekameti = $request->input('total_ekameti');
        $users= $request->input('users');
        $terms_and_conditions = $request->input('terms_and_conditions');
        $ekameti_id = $request->input('	ekameti_id');
        $invitation_code =rand(11111,99999);
        
        $isUserExists = DB::table('users')
        ->where('id',$user_id)
        ->first();
       
       if ($isUserExists ==null) {
        $error['msg']="Invalid Users";
        return response(['response'=>$error],400);
       }
      // $kameti_term_and_condition= DB::table('kameti_term_and_conditions')->get(); 

    $ekameti=new Ekameti();
       $ekameti->user_id=$user_id;
       $ekameti->ekameti_type = $ekameti_type;
       $ekameti->ekameti_Holder_full_name=$ekameti_Holder_full_name;
       $ekameti->installment=$installment;
       $ekameti->total_amount_kameti=$total_amount_kameti;
       $ekameti->total_months=$total_months;
       $ekameti->starting_date=$starting_date;
       $ekameti->withdraw_date=$starting_date;
       $ekameti->ending_date=$ending_date;
       $ekameti->status='Pending';
       $ekameti->my_total_kameti=$my_total_kameti;
       $ekameti->invitation_code = $invitation_code;
       $ekameti->save();
    
        $ekameti_member =new kameti_member();
        $ekameti_member->member_id = $user_id;
        $ekameti_member->ekameti_id =$ekameti->id;
        $ekameti_member->total_ekameti=$my_total_kameti;
        $ekameti_member->pending_kameti=$my_total_kameti;
        $ekameti_member->payable_amount=$my_total_kameti * $ekameti->installment;
        $ekameti_member->status = 'Active';
        $ekameti_member->save();

        $message='Kameti has created Successfully';

        $this->notification($ekameti_member->member_id,$ekameti->user_id ,$message);
       
        $sum =0;
        $sum=$sum+$ekameti->my_total_kameti;
        if($ekameti != null){
            if(!empty($users)){ 
            
           // return count($users);
        //    for($i=0;$i<count($users);$i++){
        //     $sum=$sum+$users[$i]['total_kameties'];
        //   }
  
            if ($sum> $ekameti->total_months) {
                $error['msg']="You can't add more than ".$ekameti->total_months.'ekamties';
                return response(['response'=>$error],400);
            }

          

            foreach($users as $user){
              //return $users;

                $payable = $user['total_kameties']*$ekameti->installment;

                $ekameti_member= kameti_member::create([
                    'member_id'=> $user['user_id'],
                    'ekameti_id' =>$ekameti->id,
                    'total_ekameti'=>$user['total_kameties'],
                    'pending_kameti'=>$user['total_kameties'],
                    'payable_amount' =>$payable,
                    'add_by'=>$ekameti->user_id,
                    'status'=> 'Pending'
                   
                ]);
               

                $message =$ekameti->ekameti_Holder_full_name.' Requested you to join his kameti';
                $this->notification($user['user_id'],$ekameti->user_id,$message);
             }
                //return $ekameti_member;
           } 
            DB::table('ekametis')->where('id',$ekameti->id)->update(['allocated_kameties'=>$sum]);
        // }
            $terms_and_condition= DB::table('kameti_term_and_conditions')->where('user_id',$user_id)->get();
            if($request->has("terms_and_conditions")){
            $kameti_term_and_condition = new kameti_term_and_condition();
            $kameti_term_and_condition->user_id=$user_id;
            $kameti_term_and_condition->ekameti_id=$ekameti->id;
            $kameti_term_and_condition->terms_and_conditions= $terms_and_conditions;
            $kameti_term_and_condition->save();
            }
            else{
              $kameti_term_and_condition = DB::table('kameti_term_and_conditions')->update(['terms_and_conditions'=>$terms_and_conditions]);  
            }
        //     $get_deviceid=DB::table('users_devices')->select('id','did')->where('user_id',$user_id)->first();
        //     $message=$request->input('message');
        //     if(!empty($get_deviceid)){
        //         $to=$get_deviceid->did;
        //         $url = 'https://fcm.googleapis.com/fcm/send';

        //         $api_key = 'AAAAjGBdOSw:APA91bHju7pVynRPqcxradiD4Xwdfjk4lKo24uEdct_mA1LSsm4mYPy4YLhm1gQbDlEkKKKpYDkW2VdmNJIMOcE_nZ_3l73uyv9d41VGmLgpYbNwBhyHaJjhNy9HBlsZDDSQAhSWsHLA';

        //         $fields = array (
        //            'to' =>$to,
        //            'notification' => array('body'=>$message)
        //     );
        //     //header includes Content type and api key
        //         $headers = array(
        //            'Content-Type:application/json',
        //            'Authorization:key='.$api_key
        //         );

        //     $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_URL, $url);
        //     curl_setopt($ch, CURLOPT_POST, true);
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        //     $result = curl_exec($ch);
        //     if ($result === FALSE) {
        //         die('FCM Send Error: ' . curl_error($ch));
        //     }
        // }
        //     curl_close($ch);
        //     echo($result);
            //$data = ["response" => ["status" => "Success",'data'=>$kameti_user]];

           $members=kameti_member::where('ekameti_id',$ekameti->id)->orderBy('created_at','DESC')->get();

           // $data = ["response" => ["status" => "Success",'data'=>$kameti_term_and_condition,'ekameti_members'=>$members]];
           $data = ["response" => ["status" => "Success","message"=>"kameti created successfully","to"=>"A user ekameti created"]]; 
           return $data;
        }
    }    
     
    // public function user_ekameti_list(Request $request){
    //     $except = ['user_id'];
    //     $request = request();
    
    //     $cleanup = $request->except($except);
    //     $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
    //     $validator = Validator::make($request->all(), [
    //         'user_id' => 'required',
    //     ]);
    //     if($validator->fails()){
    //         return response()->json(['response'=>$validator->errors()], 401);      
    //     }

    //     //$user = DB::table('users')->where('id',$request->input('user_id'))->first();
    //     $user = User::where('id',$request->input('user_id'))->first();

    //     if(empty($user)){
    //         $data = ["response" => ["status" => "Error",'msg'=>'User does not exits']];
    //         //return $data;
    //     }
        
    //     $user_id = $request->input('user_id');
    //     $ekameties=[];
      
    //     // $ekameti_data = DB::table('ekametis')->select('*')->where('user_id',$user_id)->get();
    //     $ekameti_data = Ekameti::where('user_id',$user_id)->get();
       
    //     foreach($ekameti_data as $ekameti){
    //       //$ekameti_members = DB::table('kameti_members')->where('ekameti_id',$ekameti->id)->get();
    //        $ekameti_members = kameti_member::where('ekameti_id',$ekameti->id)->get();


    //        // return $ekameti_members;
    //       $user_member=[];
    //           foreach($ekameti_members as $user_members){
                
    //    //     $users = DB::table('users')->where('id',$user_members->member_id)->first();
    //         $users = User::where('id',$user_members->member_id)->first();
    //                array_push($user_member,$users);
    //           }
              

    //           $data= array(
    //               "id"=>$ekameti->id,
    //               "user_id"=>$ekameti->user_id,
    //               "total_amount_kameti"=>$ekameti->total_amount_kameti,
    //               "ekameti_type"=>$ekameti->ekameti_type,
    //               "ekameti_Holder_full_name"=>$ekameti->ekameti_Holder_full_name,
    //               "installment"=>$ekameti->installment,
    //               "total_months"=>$ekameti->total_months,
    //               "starting_date"=>$ekameti->starting_date,
    //               "ending_date"=>$ekameti->ending_date,
    //               "my_total_kameti"=>$ekameti->my_total_kameti,
    //               "status"=>$ekameti->status,
    //               "invitation_code"=>$ekameti->invitation_code,
    //               "member_list"=>$user_member
    //           );
    //           array_push($ekameties,$data);
    //         // return $ekameties;
    // }
    //    $data = ["response" => ["status" => "Success",'data'=>$ekameties]];
    //    return $data;
    // }
    public function user_ekameti_list(Request $request){
        $except = ['user_id'];
        $request = request();
        $cleanup = $request->except($except);
        $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type'=>'nullable'
            
        ]);
        if($validator->fails()){
            return response()->json(['response'=>$validator->errors()], 401);      
        }

        //$user = DB::table('users')->where('id',$request->input('user_id'))->first();
        $user = User::where('id',$request->input('user_id'))->first();

        if(empty($user)){
            $data = ["response" => ["status" => "Error",'msg'=>'User does not exits']];
            return $data;
        }
        
        $user_id = $request->input('user_id');
        $ekameties=[];
      
        // $ekameti_data = DB::table('ekametis')->select('*')->where('user_id',$user_id)->get();
        //$ekameti_data = Ekameti::where('user_id',$user_id)->orderBy('created_at','DESC')->get();
        
        if($request->input('type')=='Completed')
        {
             $ekameti_data = DB::table('ekametis')->select('ekametis.*','kameti_members.status as member_status')
        ->join('kameti_members','kameti_members.ekameti_id','ekametis.id')
         ->where(function($query){
             $query->where('ekametis.status','Completed');
            
        })
        ->where('kameti_members.member_id',$user_id)
        ->where('kameti_members.status','Active')
        ->orderBy('ekametis.created_at','DESC')->get();
        }else{
             $ekameti_data = DB::table('ekametis')->select('ekametis.*','kameti_members.status as member_status')
        ->join('kameti_members','kameti_members.ekameti_id','ekametis.id')
         ->where(function($query){
             $query->where('ekametis.status','Pending');
             $query->orwhere('ekametis.status','Active');
        })
        ->where('kameti_members.member_id',$user_id)
        ->where('kameti_members.status','Active')
        ->orderBy('ekametis.created_at','DESC')->get();
        }
       
       
      //  return $ekameti_data;
        foreach($ekameti_data as $ekameti){
          //$ekameti_members = DB::table('kameti_members')->where('ekameti_id',$ekameti->id)->get();
          $ekameti_active_members = kameti_member::where('ekameti_id',$ekameti->id)->where('status','Active')->get();
          $ekameti_pending_members = kameti_member::where('ekameti_id',$ekameti->id)->where('status','Pending')->whereRaw('add_by is Null')->get();
            

           // return $ekameti_members;
           $user_member_active=[];
           $user_member_pending=[];
            foreach($ekameti_active_members as $user_members){
                
               $users = DB::table('users')->select('users.id','users.user_name','users.Mobile','kameti_members.total_ekameti','kameti_members.pending_kameti')
               ->join('kameti_members','kameti_members.member_id','users.id')->where('kameti_members.member_id',$user_members->member_id)->where('kameti_members.ekameti_id',$user_members->ekameti_id)->first();
            
               array_push($user_member_active,$users);
            }

            foreach($ekameti_pending_members as $user_members){
                
                $users = DB::table('users')->select('users.id','users.user_name','users.Mobile','kameti_members.total_ekameti','kameti_members.pending_kameti')
                ->join('kameti_members','kameti_members.member_id','users.id')->where('kameti_members.member_id',$user_members->member_id)->where('kameti_members.ekameti_id',$user_members->ekameti_id)->first();
             
                array_push($user_member_pending,$users);
            }
              
              $data= array(
                  "id"=>$ekameti->id,
                  "user_id"=>$ekameti->user_id,
                  "total_amount_kameti"=>$ekameti->total_amount_kameti,
                  "ekameti_type"=>$ekameti->ekameti_type,
                  "ekameti_Holder_full_name"=>$ekameti->ekameti_Holder_full_name,
                  "installment"=>$ekameti->installment,
                  "total_months"=>$ekameti->total_months,
                  "starting_date"=>$ekameti->starting_date,
                  "ending_date"=>$ekameti->ending_date,
                  "withdraw_date"=>$ekameti->withdraw_date,
                  "my_total_kameti"=>$ekameti->my_total_kameti,
                  "status"=>$ekameti->status,
                  "invitation_code"=>$ekameti->invitation_code,
                  "allocated_kameties"=>$ekameti->allocated_kameties,
                  "active_member_list"=>$user_member_active,
                  'pending_member_list'=>$user_member_pending
              );
              array_push($ekameties,$data);
            //return $ekameties;
    }
       $data = ["response" => ["status" => "Success",'data'=>$ekameties]];
       return $data;
    }
    public function ekameti_member_delete(Request $request){
        $except = ['member_id','ekameti_id'];
        $request = request();
        $cleanup = $request->except($except);
        $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
        $validator = Validator::make($request->all(), [
            'user_id'=>'required',
            'ekameti_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['response'=>$validator->errors()], 401);      
        }
        $user_id=$request->input('user_id');
        $ekameti_id =$request->input('ekameti_id');
        $ekameti_member= Ekameti::where('user_id',$user_id)->where('id',$ekameti_id)->first();
        $kameti_member = kameti_member::where('member_id',$ekameti_member->user_id)->where('ekameti_id',$ekameti_id)->first();
        $total_ekameti_member = $ekameti_member->allocated_kameties-$kameti_member->total_ekameti;
        $update_kameti_member = DB::table('ekametis')->where('user_id',$request->user_id)->where('id',$request->ekameti_id)->update(['allocated_kameties'=>$total_ekameti_member]);
        $kameti_member_delete = DB::table('kameti_members')->where('member_id',$ekameti_member->member_id)->where('ekameti_id',$ekameti_id)->delete();
        $success['status'] = "Success";
        $success['msg'] = 'Kameti member has been Deleted successfully.';
        // $success['data'] = $data;
        return response()->json(['response'=>$success],200);
    }
    public function Join_Kameti(Request $request){
        $except = ['user_id ','invitation_code'];
        $request = request();
        $cleanup = $request->except($except);
        $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
        $validator = Validator::make($request->all(), [
            'invitation_code'=>'required',
            'user_id' => 'required',
            'total_ekameti'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(['response'=>$validator->errors()], 401);      
        }
        $invitation_code=$request->input('invitation_code');
        $user_id = $request->input('user_id');
        $total_ekameti =$request->input('total_ekameti');
 
        // $isUserExist = reference_admin::where('member_id',$user_id)->first();
        // if($isUserExist == null){
        //     $reference_admin =  $reference_admin = reference_admin::create([
        //         'admin_id'=>$user_id,
        //         'member_id'=>$user_id,
        //         'created_at'=>now(),
        //         'updated_at'=>now()
        //     ]);
        // }
        $kameti = DB::table('ekametis')->where('invitation_code',$invitation_code)->first();
        if(empty($kameti))
        {
            $error2['msg'] = 'Invalid invitation code';
            return response(['response'=>$error2],200);
        }
        $user = DB::table('users')->where('id',$user_id)->first();
        if(empty($user)){
            $error1['msg'] = 'The user does not exits';
            return response(['response'=>$error1],200);
        }
        $member=DB::table('kameti_members')->where('member_id',$user_id)->where('ekameti_id',$kameti->id)->get();
       
        if(count($member)>0)
        {
            $error3['status'] = 'Error';
            $error3['msg'] = "Your Ekameti join request have already sent";
            return response(['response'=>$error3],200);
          }
        $check=$kameti->total_months-$kameti->allocated_kameties;
        $payable_amount = $kameti->installment *$total_ekameti;
       
        $kameti_member_count = DB::table('kameti_members')->where('ekameti_id',$kameti->id)->count();
        if($total_ekameti<=$check){
            $kameti_member = kameti_member::create([
                'member_id'=>$user_id,
                'ekameti_id'=>$kameti->id,
                'total_ekameti'=>$total_ekameti,
                'pending_kameti'=>$total_ekameti,
                'status'=>'Pending',
                'created_at'=>$kameti->created_at,
                'payable_amount'=> $payable_amount,
            ]);
              
        $isUserExist = reference_admin::where('member_id',$user_id)->where('admin_id',$kameti->user_id)->first();
        if($isUserExist == null){
            $reference_admin =  $reference_admin = reference_admin::create([
                'admin_id'=>$kameti->user_id,
                'member_id'=>$request->user_id,
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
        }
            $message =$user->user_name.' is requested to join your kameti';
            $this->notification($kameti->user_id,$user_id,$message);
        //$this->notification($ekameti->user_id,"You ");
            $success['status'] = 'Success';
            $success['msg'] = 'Your join kameti request sent to kameti Admin';
            return response(['response'=>$success],200);
        }
        else{
            $error['status'] = 'Fail';
            $error['msg'] = "Sorry you can't join kameti because this kameti members has filled";
            return response(['response'=>$error],200);
        }
     }
     public function Update_Kameti_Status(Request $request){
        $except = ['user_id','ekameti_id','status'];
        $request = request();
        $cleanup = $request->except($except);
        $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'ekameti_id'=>'required',
            'status'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(['response'=>["status" => "Error",$validator->errors()]],401);      
        }
        $user_id= $request->input('user_id');
        $ekameti_id = $request->input('ekameti_id');
        $status = $request->input('status');
        
        $ekameti = Ekameti::where('id',$ekameti_id)->first();
        $user=User::where('id',$user_id)->first();
       
          if(empty($ekameti)){
            $error1['status']= 'Error';
            $error1['msg'] = 'The Kameti does not exits';
            return response(['response'=>$error1],200);
        }
        $ekameti_pending_list = kameti_member::where('member_id',$user_id)->where('ekameti_id',$ekameti_id)->first();
       
         
        if(empty( $ekameti_pending_list ))
        {
            $error2['status']= 'Error';
            $error2['msg'] = 'The user does not exits';
            return response(['response'=>$error2],200);
        }
        
        $ekameti_update_active = kameti_member::where('member_id',$user_id)->where('ekameti_id',$ekameti_id)->update(['status'=>$status]);
        
       
        $sum = $ekameti_pending_list->total_ekameti+$ekameti->allocated_kameties;
        
        if($status == 'Active'){
            if($sum==$ekameti->total_months){
                $ekameti_update_member = Ekameti::where('id',$ekameti_id)->update(['status'=>'Active','allocated_kameties'=>$sum]);      
            }
            else{
                $ekameti_update_member = Ekameti::where('id',$ekameti_id)->update(['allocated_kameties'=>$sum]);
                $message =$ekameti->ekameti_Holder_full_name.' has approved your request to join kameti';
                $this->notification($user_id,$ekameti->user_id,$message);
            }
            
        if($ekameti_pending_list->add_by == 'Null'){
           
            $message =$ekameti->ekameti_Holder_full_name." to your join ekameti's request has been approved";
            $this->notification($ekameti->user_id,$user_id,$message);
            }
            else{
            $message =$user->user_name." has approved your request to join kameti";
            $this->notification($ekameti->user_id,$user_id,$message);    
           
            }
            $success['status'] = "Success";
            $success['msg'] = "Your Join Ekameti's Request Has Been Approved";
            return response()->json(['response'=>$success],200);
        }
        else{
            $error['status'] = "Error";
            $error['msg'] = "Your Join Ekameti's Request Has Been Rejected";
            return response()->json(['response'=>$success],200);
        }
    }
    public function term_condition(Request $request){
        $except = ['user_id'];
        $request = request();
        $cleanup = $request->except($except);
        $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['response'=>["status" => "Error",$validator->errors()]],401);      
        }

        $user = DB::table('users')->where('id',$request->input('user_id'))->first();

        if(empty($user)){
            $data = ["response" => ["status" => "Error",'msg'=>'User does not exits']];
            return $data;
        }
        $user_id = $request->input('user_id');

        $kameti_term_condition = DB::table('kameti_term_and_conditions')->where('user_id',$user_id)->get();
        $data = ["response" => ["status" => "Success","term_and_condition"=>$kameti_term_condition]];
        return $data;    }


    // public function user_list(Request $request){
    //     //$users = DB::table('users')->get();
    //     $users = User::all();
    //     $data = ["response" => ["status" => "Success",'data'=>$users]];
    //     return $data;
    // }
    
    public function user_List(Request $request){
        $except = ['user_id'];
        $request = request();
        $cleanup = $request->except($except);
        $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['response'=>$validator->errors()], 401);       
        }
        $user_id = $request->input('user_id');
        $reference_member = reference_admin::where('member_id',$user_id)->get();
     //   return $reference_member;
        $kameti_member = kameti_member::where('member_id',$user_id)->first();
        
        $users = User::select('users.*')
        ->join('reference_admins','reference_admins.member_id','users.id')
        ->where('reference_admins.admin_id',$user_id)
        ->get();
        $success['status'] = "Success";
        $success['data'] = $users;
        return response()->json(['response'=>$success],200);
    }
    public function ekameti_member(Request $request){
        $ekameti_member = DB::table('ekametis')->get();
        $data = ["response" => ["status" => "Success",'ekameti_members'=>$ekameti_member]];
        return $data;
    }
    public function kameti_member(Request $request){
        $except = ['user_name','password','user_cnic','cnic_expiry','ekameti_id','Mobile','DOB','upload_frontside_cnic','upload_backside_cnic','Email'];
        $request = request();
        $cleanup = $request->except($except);
        $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
        $validator = Validator::make($request->all(), [
            'user_name'=>'required',
            'user_cnic'=>'required',
            'cnic_expiry'=>'required',
            'ekameti_id'=>'required',
            'Mobile'=>'required',
            'DOB'=>'required',
            'upload_frontside_cnic'=>'required',
            'upload_backside_cnic'=>'required',
            //'Email'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(['response'=>$validator->errors()], 401);      
        }

      $user_name = $request->input('user_name');
      $user_cnic =$request->input('user_cnic');
      $cnic_expiry = $request->input('cnic_expiry');
      $Mobile = $request->input('Mobile');
      $DOB = $request->input('DOB');
      $Email =$request->input('Email');
      $gender = $request->input('gender');
      $ekameti_id = $request->input('ekameti_id');
      $password =$user_name.rand(1111,9999);
      $total_ekameti =$request->input('total_ekameti');

    //   $image = base64_decode($request->file('image'));
    //   $target_dir =  "public/img/user_img";
    //       $newFileName = $this->rename_file("hello.png","cnic");  
    //       $request->file('upload_frontside_cnic')->storeAs($target_dir,$newFileName);
    //       $path = "/storage/img/user_img/" . $newFileName;
      $target_dir =  "img/frontside_cnic/";
      $newFileName = $this->rename_file("hello.png","front_cnic"); 
      $imageName ='Hello.png'.'.'.'frontside_cnic';
      Storage::put($target_dir.$newFileName, base64_decode($request->input('upload_frontside_cnic')));
      $path = "/storage"."/".$target_dir . $newFileName;
      
      $target_dir =  "img/backside_cnic/";
      $newFileName = $this->rename_file("hello.png","backside_cnic"); 
      $imageName ='Hello.png'.'.'.'backside_cnic';
     //Storage::put($target_dir.$newFileName, base64_decode($image1));
      Storage::put($target_dir.$newFileName, base64_decode($request->input('upload_backside_cnic')));
      $path1 = "/storage"."/".$target_dir . $newFileName;
    
      //   $image = base64_decode($request->file('image'));
    //   $target_dir =  "public/img/upload_backside_cnic";
    //       $newFileName = $this->rename_file("hello.png","cnic");  
    //       $request->file('upload_backside_cnic')->storeAs($target_dir,$newFileName);
    //       $path = "/storage/img/upload_backside_cnic/" . $newFileName;

    $isUserExists = DB::table('users')
        //   ->select('users.id','users.user_name','users.Mobile','users.Email','users.user_cnic','users.upload_frontside_cnic','users.upload_backside_cnic',
        //   'ekameti.id','ekameti.installment','ekameti.ekameti_type','ekameti.starting_date','ekameti.ending_date','ekameti.status','ekameti.total_amount_kameti')
        //   ->join('ekameti','ekameti.user_id','=','ekameti.id')
          ->where('Mobile',$Mobile)
          ->first();

          $kametiExist=DB::table('ekametis')->where('id',$ekameti_id)->first();

          if (empty($kametiExist)) {
            $error['msg'] = 'This kamety id is not valid';
            return response()->json(['response'=>$error],401);
          }

          //return $kametiExist;

        
        if($isUserExists != null){
            $error['msg'] = 'This user has already existed';
            return response()->json(['response'=>$error],200);
        }
        else{
            $api_token = Str::random(60);
            $user=new User();
               $user->user_cnic=$user_cnic;
               $user->Email=$Email;
               $user->upload_frontside_cnic=$path;
               $user->upload_backside_cnic=$path;
               $user->Mobile=$Mobile;
               $user->password=$password;
               $user->user_name=$user_name;
               $user->gender=$gender;
               $user->DOB=$DOB;
               $user->api_token=$api_token;
               $user->save();

               if(!empty($user)){
               $ekameti_member =new kameti_member();
               $ekameti_member->member_id = $user->id;
               $ekameti_member->total_ekameti= $total_ekameti;
               $ekameti_member->ekameti_id	 = $ekameti_id;
               $ekameti_member->status = 'Active';
               $ekameti_member->save();
               
               $data = ["response" => ["status" => "Success","msg"=>"Congratulation you have added in kameti",'kameti_member'=>$ekameti_member]];
               return $data;
       }	
            }
      
        }  
    

    public function profile(Request $request){
        $except = ['id','DOB','upload_frontside_cnic','upload_backside_cnic','user_name','Email','Mobile','cnic_expiry','user_cnic'];
        $request = request();
        $cleanup = $request->except($except);
        $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['response'=>$validator->errors()], 401);
        }
        $user_id = $request->input('id');
       
        $query = DB::table('users')->where('id',$user_id)->get();

        if(count($query)){
          
            $date = Date('y-m-d-h-i-s');
            
           
            if(!empty($upload_frontside_cnic)){
                $target_dir =  "img/frontside_cnic/";
                $newFileName = $this->rename_file("hello.png","front_cnic"); 
                $imageName ='Hello.png'.'.'.'frontside_cnic';
                Storage::put($target_dir.$newFileName, base64_decode($request->input('upload_frontside_cnic')));
                $path = "/storage"."/".$target_dir . $newFileName;
            } else{
                $upload_frontside_cnic = $query[0]->upload_frontside_cnic;
            }
        
            if(!empty($upload_frontside_cnic)){
               $target_dir =  "img/frontside_cnic/";
               $newFileName = $this->rename_file("hello.png","front_cnic"); 
               $imageName ='Hello.png'.'.'.'frontside_cnic';
               //Storage::put($target_dir.$newFileName, base64_decode($request->file($image)));
               Storage::put($target_dir.$newFileName, base64_decode($request->input('upload_frontside_cnic')));
               $path = "/storage"."/".$target_dir . $newFileName;
            } else{
                $upload_frontside_cnic = $query[0]->upload_frontside_cnic;
            }
        
        
            if(!empty($upload_backside_cnic)){
                $target_dir =  "img/backside_cnic/";
                $newFileName = $this->rename_file("hello.png","backside_cnic"); 
                $imageName ='Hello.png'.'.'.'backside_cnic';
               //Storage::put($target_dir.$newFileName, base64_decode($image1));
                Storage::put($target_dir.$newFileName, base64_decode($request->input('upload_backside_cnic')));
                $path1 = "/storage"."/".$target_dir . $newFileName;;
            } else{
                $upload_backside_cnic = $query[0]->upload_backside_cnic;
            }

            // $image1=base64_encode(file_get_contents($request->file('upload_backside_cnic')));
            if(!empty($upload_backside_cnic)){
                $target_dir =  "img/backside_cnic/";
                $newFileName = $this->rename_file("hello.png","backside_cnic"); 
                $imageName ='Hello.png'.'.'.'backside_cnic';
                //Storage::put($target_dir.$newFileName, base64_decode($request->file($image)));
                Storage::put($target_dir.$newFileName, base64_decode($request->input('upload_backside_cnic')));
                $path1 = "/storage"."/".$target_dir . $newFileName;
             } else{
                 $upload_backside_cnic = $query[0]->upload_backside_cnic;
             }
            $user_name = $request->input('user_name');
            if(!empty($user_name)){
                $user_name = $request->input('user_name');
            } else {
                $user_name = $query[0]->user_name;
            }

            $Email = $request->input('Email');
            if(!empty($Email)){
                $Email = $request->input('Email');
            } else {
                $Email = $query[0]->Email;
            }
            $Mobile = $request->input('Mobile');
            if(!empty($Mobile)){
                $Mobile = $request->input('Mobile');
            } else {
                $Mobile = $query[0]->Mobile;
            }

            $cnic_expiry = $request->input('cnic_expiry');
            if(!empty($cnic_expiry)){
                $cnic_expiry = $request->input('cnic_expiry');
            } else {
                $cnic_expiry = $query[0]->cnic_expiry;
            }
            
            $user_cnic = $request->input('user_cnic');
            if(!empty($user_cnic)){
                $user_cnic = $request->input('user_cnic');
            } else {
                $user_cnic = $query[0]->user_cnic;
            }

            $DOB = $request->input('DOB');
            if(!empty($DOB)){
                $DOB = $request->input('DOB');
            } else {
                $DOB = $query[0]->DOB;
            }

           $update_data = DB::table('users')->where('id',$user_id)->update(['user_name'=>$user_name,'Email'=>$Email,'Mobile'=>$Mobile,'cnic_expiry'=>$cnic_expiry,
           'DOB'=>$DOB,'user_cnic'=>$user_cnic,'upload_backside_cnic'=>$upload_backside_cnic,'upload_frontside_cnic'=>$upload_frontside_cnic]);

           if($update_data)
           {

               $data = DB::table('users')->where('id',$user_id)->first();
               $success['status'] = "Success";
               $success['msg'] = 'Profile updated successfully.';
               $success['data'] = $data;
               return response()->json(['response'=>$success],200);
           }
           else {
               $error['status'] = "0";
               $error['msg'] = "Profile not updated!";
               return response()->json(['response'=>$error]);
           }
       } else {
           $error['status'] = "0";
           $error['msg'] = "User ID does not exits!";
           return response()->json(['response'=>$error]);
       }
    }
    public function logout(Request $request)
    {
        Auth::user()->token()->delete();

        return response()->json(array("response"=>[
            'result'=>1,
            'msg' => 'Successfully logged out'
        ]));
    }

    public  function kameti_terms_and_condition(Request $request){
        $except = ['user_id'];
        $request = request();
        $cleanup = $request->except($except);
        $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
        $user_id = $request->input('user_id');
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['response'=>$validator->errors()], 401);
        }
       
        // $kameti_user = DB::table('kameti_term_and_conditions')->where('user_id',$user_id)->select('*')->get();
        $kameti_user = kameti_term_and_condition::where('user_id',$user_id)->get();

        // $kameti_term_and_condition=new kameti_term_and_condition();
        //        $kameti_term_and_condition->user_id=$user_id;
        //        $kameti_term_and_condition->ekameti_id=$ekameti_id;
        //        $kameti_term_and_condition->terms_and_conditions=$terms_and_conditions;
        //        $kameti_term_and_condition->save();
            //return response(['response'=>$kameti_user],200); 
            $data = ["response" => ["status" => "Success",'data'=>$kameti_user]];
            return $data;
    }

    public function ekameti_type(Request $request){
        $ekameti_name = $request->input('ekameti_name');
        $status = $request->input('status');  
       
        $kameti = DB::table('ekameti_types')->select('*')->where('status','Enable')->first();
      
        $ekameti_type = new ekameti_type();
            $ekameti_type->ekameti_name = $ekameti_name;
            $ekameti_type->status = $status;
            $ekameti_type->save(); 
        return response(['response'=>$ekameti_type],200);  
           
    }

    public function ekameti_type_list(Request $request){
        $ekameti_list = DB::table('ekameti_types')->select('*')->get();
        $data = ["response" => ["status" => "Success",'type_list'=>$ekameti_list]];
        return $data;
    }

   public function adminLogin(Request $request){
       $validator = Validator::make($request->all(),[
          'user_name' => 'required',
          'password' => 'required'

    ]);
       if ($validator->fails()) {
        return response()->json(['result'=>'0','response'=>$validator->errors()], 401);
    }
    $user_name = $request->input("user_name");
    $password = $request->input("password");
    
    if(!is_numeric($user_name)){
        $result =  DB::table('admin')
            ->where('email' , $user_name)
            ->where('password' , $password)
            ->where('status','Enable')
            ->first();
    }
    if($result != null){
        $success['msg'] = 'Admin login is success';
        $success['user']= DB::table("admin")->where('email' , $user_name)->first();
        return response()->json(['response'=>$success],200);
    }
    else {
        $error['result'] = "0";
        $error['msg'] = "Admin login is failed!";
        return response()->json(['response'=>$error]);
    }
   }
   
   public function notification($receiver_id,$sender_id, $message){
    $get_deviceid=DB::table('users_devices')->select('id','did')->where('user_id',$receiver_id)->first();
    if(!empty($get_deviceid)){
        $to=$get_deviceid->did;
        $url = 'https://fcm.googleapis.com/fcm/send';

        $api_key = 'AAAAjGBdOSw:APA91bHju7pVynRPqcxradiD4Xwdfjk4lKo24uEdct_mA1LSsm4mYPy4YLhm1gQbDlEkKKKpYDkW2VdmNJIMOcE_nZ_3l73uyv9d41VGmLgpYbNwBhyHaJjhNy9HBlsZDDSQAhSWsHLA';

        $fields = array (
           'to' =>$to,
           'notification' => array( 'title'=>'Ekameti','body'=>$message)
    );
    //header includes Content type and api key
        $headers = array(
           'Content-Type:application/json',
           'Authorization:key='.$api_key
        );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    
    $push_notification = push_notification::create([
        'receiver_id'=>$receiver_id,
        'title'=>'Ekameti',
        'sender_id'=>$sender_id,
        'msg'=>$message,
        'created_at'=>now(),
        'updated_at'=>now(),
    ]);
}
    
   }
     
   public function Searching_User(Request $request){
        $except = ['Mobile'];
        $request = request();
        $cleanup = $request->except($except);
        $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
        $validator = Validator::make($request->all(), [
            'Mobile'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(['response'=>$validator->errors()], 401);      
        }
        $Mobile = $request->input('Mobile');
        $query = User::select('*')->where('Mobile',$Mobile)->first();
        
        if($query === null){
            $error['status'] = 'Error';
            $error['msg'] = 'Record Not Found';
            return response(['response'=>$error]);
        }
        else{
            $success['status'] = 'Success';
            $success['msg'] = 'Mobile number found';
            $success['data'] = $query;
            return response(['response'=>$success],200);
        }
   }
   public function Admin_Reference(Request $request){
    $except = ['member_id','admin_id'];
    $request = request();
    $cleanup = $request->except($except);
    $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
    $validator = Validator::make($request->all(), [
        'member_id'=>'required',
        'admin_id'=>'required'
    ]);
    if($validator->fails()){
        return response()->json(['response'=>$validator->errors()], 401);      
    }
    $member_id = $request->input('member_id');
    $admin_id = $request->input('admin_id');
    // return $member_id;

    $isUserExist = reference_admin::where('admin_id',$admin_id)->where('member_id',$member_id)->first();
    if($isUserExist != null){
        $error['status']='Error';
        $error['msg'] = 'This user has already existed';
        return response()->json(['response'=>$error],200);
    }
    $reference_admin =  $reference_admin = reference_admin::create([
                'admin_id'=>$admin_id,
                'member_id'=>$member_id,
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
//     $users = User::select('users.*')
//             ->join('reference_admins','reference_admins.member_id','users.id')
//             ->where('reference_admins.member_id',$member_id)
//             ->first();
        $users = User::select('users.*')
        ->join('reference_admins','reference_admins.member_id','users.id')
        ->where('reference_admins.member_id',$member_id)
        ->get();
            $success['status'] ='Success';
            $success['msg'] ='You have addited in kameti member';
            $success['data'] =$users;
            return response(['response'=>$success],200);
   }
   public function Pending_Kameti(Request $request){
    $except = ['ekameti_id'];
    $request = request();
    $cleanup = $request->except($except);
    $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
    $validator = Validator::make($request->all(), [
        'ekameti_id'=>'required'
    ]);
    if($validator->fails()){
        return response()->json(['response'=>$validator->errors()], 401);      
    }
    $ekameti_id = $request->input('ekameti_id');

    //$kameti_member= kameti_member::where('ekameti_id',$request->ekameti_id)->where("pending_kameti",">=",1)->get();
    $kameti_member = User::select('kameti_members.member_id','users.user_name')
    ->join('kameti_members','kameti_members.member_id','users.id')->where('kameti_members.ekameti_id',$ekameti_id)->where('kameti_members.pending_kameti',">=",1)->get();

    $success['status'] ='Success';
    $success['data'] =$kameti_member;
    return response(['response'=>$success],200);
   }
  
   public function Drop_Kameti(Request $request){
    $except = ['ekameti_id', 'member_id'];
    $request = request();
    $cleanup = $request->except($except);
    $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
    $validator = Validator::make($request->all(), [
       
        'type'=>'required'
    ]);
    if($validator->fails()){
        return response()->json(['response'=>$validator->errors()], 401);      
    }

    if ($request->input('type')=='NawoonWali') {
        $validator = Validator::make($request->all(), [
            
            'droplist'=>'required',
            
        ]);
        if($validator->fails()){
            return response()->json(['response'=>$validator->errors()], 401);      
        }

       
        $dropKameties=$request->input('droplist');

        if (empty($dropKameties)) {
                   
        }

        $ekameti= Ekameti::where('id',$dropKameties[0]['ekameti_id'])->first();
        
            $withdraw_kameti = $ekameti->withdraw_kameties +1;
    
            if($ekameti->withdraw_kameties == $ekameti->total_months){
                $success['status'] ='Error';
                $success['msg'] = 'All Kameties are dropped';
                $success['data'] = $drop;
            }else{
 
                foreach ($dropKameties as $drop) {
                    # code...
                    $drop=drop_kamety::create(
                        [
                            'ekameti_id'=>$drop['ekameti_id'],
                            'user_id'=>$drop['member_id'],
                            'kameti_number'=>$drop['kameti_no'],
                            'drop_date'=>$drop['drop_date'],
                            'status'=>'Pending'
                        ]);
    
                    $withdraw_kameti_update = Ekameti::where('id',$drop['ekameti_id'])
                    ->update(['withdraw_kameties'=>$withdraw_kameti]);
    
                    $message ='Congratulation! Your drop kameti is droped your kameti number is '.$drop['kameti_no'];
                    $this->notification($drop['member_id'],$ekameti->user_id,$message);
        
                }
        
                $success['status'] ='Success';
            $success['msg'] = 'Congratulation! kameti is added in list';
            $success['data'] = $drop;
            return response(['response'=>$success],200);
            }

           
            //return $drop;
           
            

    }else {
        $validator = Validator::make($request->all(), [
            'ekameti_id'=>'required',
            'member_id'=>'required',
            'type'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(['response'=>$validator->errors()], 401);      
        }
        
        $ekameti_id = $request->input('ekameti_id');
        $member_id =  $request->input('member_id');
        $user = User::where('id',$member_id)->first();
        $ekameti= Ekameti::where('id',$ekameti_id)->first();
        $kameti_member = kameti_member::where('member_id',$member_id)->where('ekameti_id',$request->ekameti_id)->first();
        $pending_kameti = $kameti_member->pending_kameti-1;
    

    $update_pending_kameti = kameti_member::where('member_id',$member_id)
    ->where('ekameti_id',$ekameti_id)->update(['pending_kameti'=>$pending_kameti]);
   
   
    
   
   $ekameti_update= Ekameti::where('user_id',$member_id)->where('id',$ekameti_id)->update(['withdraw_date'=>carbon::parse($ekameti->withdraw_date)->addmonths(1)]);
   $members =kameti_member::select('*','ekametis.user_id')
   ->join('ekametis','ekametis.id','kameti_members.ekameti_id')
   ->where('kameti_members.ekameti_id',$kameti_member->ekameti_id)
   ->where('kameti_members.status','Active')
   ->get();


   $drop=drop_kamety::create(
    [
        'ekameti_id'=>$ekameti_id,
        'user_id'=>$member_id,
        'kameti_number'=>0,
        'drop_date'=>$ekameti->withdraw_date,
        'status'=>'Pending'
    ]);


    
    foreach($members as $member){
        $message =$user->user_name.'  Kameti Has Dropped';
        $this->notification($member->member_id,$member->user_id,$message);
    }
    if($member_id == $ekameti->user_id){
        $message ='Congratulation! Your drop kameti is drop down '. $user->user_name.' '.$ekameti->starting_date.' '.$ekameti->total_amount_kameti;
        $this->notification($ekameti->user_id,$member_id,$message);
    }
    else{
        $message ='Prepare For Giving Kameti '. $user->user_name.' '.$ekameti->starting_date.' '.$ekameti->total_amount_kameti;
        $this->notification($ekameti->user_id,$member_id,$message);
    }
 
    $withdraw_kameti = $ekameti->withdraw_kameties +1;
    
    if($withdraw_kameti == $ekameti->total_months){
        $withdraw_kameti_update = Ekameti::where('id',$ekameti_id)
        ->update(['withdraw_kameties'=>$withdraw_kameti,'status'=>'Completed']);
    }else{
        $withdraw_kameti_update = Ekameti::where('id',$ekameti_id)
        ->update(['withdraw_kameties'=>$withdraw_kameti]);
    }
    
    $success['status'] ='Success';
    $success['msg'] = 'Congratulation! Your kameti has dropped';
    return response(['response'=>$success],200);

}

   } 
   public function Pending_Kametis(Request $request){
    $except = ['user_id'];
    $request = request();
    $cleanup = $request->except($except);
    $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
    $validator = Validator::make($request->all(), [
        'user_id'=>'required',
    ]);
    if($validator->fails()){
        return response()->json(['response'=>$validator->errors()], 401);      
    }
    $user_id = $request->input('user_id');
    $ekameti = kameti_member::where('member_id',$user_id)->first();
    // $isUserExists = DB::table('ekametis')
    //     ->where('user_id',$user_id)
    //     ->first();
        
       
    //    if ($isUserExists ==null) {
    //     $error['msg']="Invalid Users";
    //     return response(['response'=>$error],400);
    //    }
    $ekameti_member = Ekameti::select('ekametis.*','users.Mobile')
    ->join('kameti_members','kameti_members.ekameti_id','ekametis.id')
    ->join('users','users.id','ekametis.user_id')
    ->where('kameti_members.member_id',$user_id)->where('kameti_members.status','Pending')->get();
   
    $success['status'] ='Success';
    $success['data'] =   $ekameti_member;
    return response(['response'=>$success],200);
   }
   public function Delete_Member(Request $request){
    $except = ['member_id','admin_id'];
    $request = request();
    $cleanup = $request->except($except);
    $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
    $validator = Validator::make($request->all(), [
        'member_id'=>'required',
        'admin_id' => 'required',
    ]);
    if($validator->fails()){
        return response()->json(['response'=>$validator->errors()], 401);      
    }
    $member_id=$request->input('member_id');
    $admin_id =$request->input('admin_id');

    $member_delete = reference_admin::where('member_id',$member_id)->where('admin_id',$admin_id)->delete();

    $success['status'] ='Success';
    $success['msg'] =  'Kameti Member Has Been Deleted';
    return response(['response'=>$success],200);
   }
   public function Ekameti_Detail(Request $request){
    $except = ['ekameti_id'];
    $request = request();
    $cleanup = $request->except($except);
    $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
    $validator = Validator::make($request->all(), [
        'ekameti_id'=>'required',
    ]);
    if($validator->fails()){
        return response()->json(['response'=>$validator->errors()], 401);      
    }
    $ekameti_id = $request->input('ekameti_id');
    $kameti = Ekameti::where('id',$ekameti_id)->first();

    $success['status'] ='Success';
    $success['data'] =  $kameti;
    return response(['response'=>$success],200);
   }
   public function Update_Mobile(Request $request){
    $except = ['user_id','Mobile'];
    $request = request();
    $cleanup = $request->except($except);
    $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
    $validator = Validator::make($request->all(), [
        'user_id'=>'required',
        'Mobile'=>'required'
    ]);
    if($validator->fails()){
        return response()->json(['response'=>$validator->errors()], 401);      
    }
    $user_id=$request->input('user_id');
    $Mobile=$request->input('Mobile');

    $update_mobile = DB::table('users')  
    ->where('id',$user_id)
    ->update(['Mobile'=>$Mobile]);
if($update_mobile)    
{   $user = User::where('id',$user_id)->first();
    $success['status'] = 'Success';
    $success['msg'] = 'Mobile Number updated successfully';
    $success['data'] = $user;
    return response()->json(['response'=>$success]);
}
else {
    $error['status'] = "Fail";
    $error['msg'] = "Mobile Number is not updated";
    return response()->json(['response'=>$error]);
}
   }
   public function Fetch_Notification(Request $request){
    $except = ['user_id'];
    $request = request();
    $cleanup = $request->except($except);
    $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
    $validator = Validator::make($request->all(), [
        'user_id'=>'required',
    ]);
    if($validator->fails()){
        return response()->json(['response'=>$validator->errors()], 401);      
    }
    $user_id = $request->input('user_id');
    $count = push_notification::where('receiver_id',$user_id)->count();
    $fetch_notification = push_notification::where('receiver_id',$user_id)->orderBy('created_at','DESC')->get();
   
    $success['status'] = 'Success';
    $success['count'] = $count;
    $success['data'] = $fetch_notification;
    return response()->json(['response'=>$success]);
   }
   public function Delete_Kameti(Request $request){
    $except = ['ekameti_id'];
    $request = request();
    $cleanup = $request->except($except);
    $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
    $validator = Validator::make($request->all(), [
        'ekameti_id' => 'required',
        'user_id'=>'required'
    ]);
    if($validator->fails()){
        return response()->json(['response'=>$validator->errors()], 401);      
    }
    $ekameti_id =$request->input('ekameti_id');
    $user_id = $request->input('user_id');
   // $user = DB::table('users')->where('id',$user_id)->first();
    $ekameti_member_count= Ekameti::where('id',$ekameti_id)->where('user_id',$user_id)->count();

    if($ekameti_member_count < 1){
        $error['status'] = "Error";
        $error['msg'] = "Kameti Has Already Deleted";
        return response()->json(['response'=>$error]);
    }
    $kameti_member_count = kameti_member::where('ekameti_id',$ekameti_id)->count();
    // $members =kameti_member::select('*','ekametis.user_id')
    // ->join('ekametis','ekametis.id','kameti_members.ekameti_id')
    // ->where('kameti_members.ekameti_id',$ekameti_id)
    // ->where('kameti_members.status','Active')
    // ->get();
    
    // foreach($members as $member){
    //     $message =$user->user_name.'  Has Been Deleted';
    //     $this->notification($member->member_id,$member->user_id,$message);
    // }

    if($ekameti_member_count > 0 || $kameti_member_count >0){
    $kameti_member_delete = DB::table('kameti_members')->where('ekameti_id',$ekameti_id)->delete();
    $ekameti_delete = DB::table('ekametis')->where('user_id',$user_id)->where('id',$ekameti_id)->delete();


    $success['status'] = "Success";
    $success['msg'] = 'Kameti has been Deleted successfully.';
    return response()->json(['response'=>$success],200);
    }
}
    public function Drop_Kameti_list(Request $request){
        $except = ['ekameti_id'];
        $request = request();
        $cleanup = $request->except($except);
        $request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);
        $validator = Validator::make($request->all(), [
            'ekameti_id' => 'required',
            'user_id'=>'required',
            'type'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(['response'=>$validator->errors()], 401);      
        }
        $ekameti_id = $request->input('ekameti_id');
        $user_id = $request->input('user_id');

        $user = User::where('id',$user_id)->first();
        $ekameti = Ekameti::where('id',$ekameti_id)->first();
        
        if($request->input('type')=='Admin'){
            $drop_kametis_by_admin = DB::table('drop_kameties')->select('users.user_name','drop_kameties.*')
            ->join('users','users.id','drop_kameties.user_id')
            ->where('ekameti_id',$ekameti_id)->orderBy('drop_kameties.kameti_number','ASC')->get();
        
        $success['status'] = "Success";
        $success['data'] =  $drop_kametis_by_admin;
        return response(['response'=>$success],200);
        }
        else{
           
                $drop_kametis_by_user = DB::table('drop_kameties')->select('users.user_name','drop_kameties.*')
                ->join('users','users.id','drop_kameties.user_id')
                ->where('ekameti_id',$ekameti_id)->where('user_id',$user_id)->orderBy('drop_kameties.kameti_number','ASC')->get();
            
            $success['status'] = "Success";
            $success['data'] =  $drop_kametis_by_user;
            return response(['response'=>$success],200);
            }
        }
}
