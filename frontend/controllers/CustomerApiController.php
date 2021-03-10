<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\CustomerMaster;
use backend\models\DropdownManagement;
use backend\models\TechnicianMaster;
use backend\models\ApiServiceLog;
use backend\models\CategoryManagement;
use backend\models\BrandMapping;
use backend\models\StatusModule;
use backend\models\ServiceModule;
use yii\web\UploadedFile;
use yii\db\Expression;
class CustomerApiController extends Controller
{  
	/** 
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function beforeAction($action) {
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
}
 //Related Videos End

 public function send_sms_number_transaction($mnumber="",$bodytxt=""){
  $mnumber=trim($mnumber);
  $return="SMSnotenabled";
  if($mnumber!="" && is_numeric($mnumber) && strlen($mnumber)=="10"){
         
        $return="SMS Send";           
        $user_name="prathap";
        $user_password="rohit";
        $user_senderid="123";
       $sms_url="http://api.clickatell.com/http/sendmsg?to";
        $mnumber='+91'.$mnumber;        
        $bodytxt=str_replace("&", 'and', "");
        $bodytxt=str_replace("+", '', "$bodytxt");
        $bodytxt=str_replace("/", '', "$bodytxt");
        $bodytxt=rawurlencode( "$bodytxt");
        //$url = "http://smstrans.adwise.org.in/sendsms.jsp?user=ryabank&password=123456a&mobiles=$to&sms=$body&senderid=RYABNK";
          $url = $sms_url."=".$mnumber."&msg=".$user_password."";
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_HEADER, true);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);          
        $return_m=curl_exec($ch);      
        $return=$return.'_'.$return_m; 
        }
  return $return;
}

 public function actionLogin(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('phonenumber','apimethod');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="login";
    $model_log->created_at=date("Y-m-d H:i:s");
    $model_log->save();
    $log_id=$model_log->autoid;

     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 
    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
    }else{

  $apimethod=$requestInput['apimethod'];
  $phonenumber=$requestInput['phonenumber'];
  if($apimethod=="poojaapi"){
  $str_rnd = mt_rand(1000, 9999);
 // $str_rnd="1234";
  $body = $str_rnd.' is your OTP for PoojaElectrical.';
  $student_mobile='8760776740';
  $this-> send_sms_number_transaction($student_mobile,$body);
  if($phonenumber!=""){
  $customer_master=CustomerMaster::find()
  ->where(['phone'=>$phonenumber])
  ->asArray()
  ->one();
  if(!empty($customer_master)){
    $otp=$str_rnd;
    $otpstatus="otp_sent";
    $platform="mobile";
    $active_status="1";
   $phonen=$customer_master['phone'];
   CustomerMaster::updateALL(['otp_number'=>$otp,'otp_status'=>$otpstatus,'platform'=>$platform,'active_status'=>$active_status],['phone'=>$phonen]); 
   }else{
    $model = new CustomerMaster();
    $model->phone=$phonenumber;
    $model->otp_number=$str_rnd;
    $model->otp_status="otp_sent";
    $model->platform="mobile";
    $model->active_status="1";
    if($model->save()){

    }else{
      echo "<pre>";print_r($model->getErrors());die;
    } 
  }
    }
    $list['status'] = "success";
    $list['otp'] = $str_rnd;
    $list['message'] = "OTP Send successfully";
  }
  }
//Log Table 
  if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
   $response['Output'][] = $list;
   return json_encode($response);
  }


  //ReSchdule or Cancellation

   public function actionUpdateservice(){
    //die;
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('booking_id','apimethod','date','time','cancelremarks','status');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="updateservice";
    $model_log->created_at=date("Y-m-d H:i:s");
    $model_log->save();
    $log_id=$model_log->autoid;
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 
    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
    }else{

  $apimethod=$requestInput['apimethod'];
  if($apimethod=="bookservicelist"){
  $booking_id=$requestInput['booking_id'];
  $date=$requestInput['date'];
  $cancelremarks=$requestInput['cancelremarks'];
  $time=$requestInput['time'];
  $status=$requestInput['status'];
  if($status=="R"){
   StatusModule::updateALL(['re_date'=>$date,'status'=>"Reschdule",'re_time'=>$time,'re_schedule'=>"yes"],['auto_id'=>$booking_id]);
  }else if($status=="C"){
    StatusModule::updateALL(['status'=>"Cancelled",'cancel_remarks'=>$cancelremarks,'re_schedule'=>"no"],['auto_id'=>$booking_id]);
  }
  $list['status'] = "success";
  $list['message'] = "Updated Successfully";
  }
  }
//Log Table 
  if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
   $response['Output'][]=$list;
   return json_encode($response);
  }
  public function actionVerifyotp(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('phonenumber','otp','apimethod');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="verifyotp";
    $model_log->created_at=date("Y-m-d H:i:s");
    $model_log->save();
    $log_id=$model_log->autoid;
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 
    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
    }else{
      $apimethod=$requestInput['apimethod'];
      $phonenumber=$requestInput['phonenumber'];
      $otp=$requestInput['otp'];
  if($apimethod=="poojaapi"){
    $customer_master=CustomerMaster::find()
  //  ->select('DATE_ADD(CREATION_DATE, INTERVAL 5 DAY) ');
    ->where(['phone'=>$phonenumber])
    ->asArray()
    ->one();
    
$date=$customer_master['updated_at'];
$date22 = date('Y-m-d H:i:s');
$date = strtotime($date);
$date = strtotime("+5 minute", $date);
$date = date('Y-m-d H:i:s', $date);
$datestart= strtotime($date);
$date22start= strtotime($date22);
    if(!empty($customer_master)){
    $otp2=$customer_master['otp_number'];
    $customer_name=$customer_master['customer_name'];
    if($customer_name!=""){
    $userlogintype="old";
    $userloginname=$customer_name;
    }else{
    $userlogintype="new";
     $userloginname="";
    }
    
    if($date22start <= $datestart){
    if($otp==$otp2){
    CustomerMaster::updateALL(['otp_status'=>'verified'],['phone'=>$phonenumber]);
    $list['status'] = "success";
    $list['user_role'] = $userlogintype;
    $list['name'] = $userloginname;
    $list['message'] = "OTP Verfied successfully";
    }else{
    $list['status'] = "error";
    $list['user_role'] = $userlogintype;
    $list['name'] = "";
    $list['message'] = "Enter OTP correctly";
    }
    }else{
      
    $list['status'] = "error";
    $list['user_role'] = $userlogintype;
    $list['name'] = "";
    $list['message'] = "OTP Expired.";

    }
    }else{
    $list['status']="error";
    $list['user_role']="";
    $list['name']="";
    $list['message']="Mobile Number Invalid";
    }
  }
  }
  if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
   $response['Output'][] = $list;
    return json_encode($response);
  }
  public function actionUpdateprofile(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Nill';
    $field_check=array('phonenumber','name','email','apimethod','address','lat','lan');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="updateprofile";
    $model_log->created_at=date("Y-m-d H:i:s");
    $model_log->save();
    $log_id=$model_log->autoid;
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 
    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
    }else{
      $apimethod=$requestInput['apimethod'];
      $phonenumber=$requestInput['phonenumber'];
      $name=$requestInput['name'];
      $address=$requestInput['address'];
      $email=$requestInput['email'];
     // die;
  if($apimethod=="beatme"){
    $customer_master=CustomerMaster::find()
    ->where(['phone'=>$phonenumber])
    ->asArray()
    ->one();
  if(!empty($customer_master)){
    $auth_key=Yii::$app->security->generateRandomString();
  $update=CustomerMaster::updateALL(['otp_status'=>'verified','user_type'=>'olduser','description'=>$address,'email'=>$email,'customer_name'=>$name,'auth_key'=>$auth_key,'platform'=>'mobile'],['phone'=>$phonenumber]);
  $customer_master_type=CustomerMaster::find()
    ->where(['phone'=>$phonenumber])
    ->asArray()
    ->one();
    $olduser=$customer_master_type['user_type'];
    $list['status'] = "success";
    $list['message'] = "User Updated Successfully";
    $list['user_type'] = $olduser;
    $list['auth_key'] = $auth_key;
    }else{
    $list['status'] = "error";
    $list['message'] = "Mobile Number Invalid";
    }
  }
  }
  if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
   $response['Output'][] = $list;
    return json_encode($response);
  }


//servicetypelist  

public function actionServicetypelist(){
  $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
     $list['status'] = 'error';
     $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="servicetypelist";
    $model_log->created_at=date("Y-m-d H:i:s");
    $model_log->save();
    $log_id=$model_log->autoid;
    $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 

    if ($is_error == "yes") {
    $list['status'] = 'error';
    $list['message'] = $is_error_note . ' is Mandatory.';
    }else{
    $apimethod=$requestInput['apimethod'];
    if($apimethod=="poojaapi"){

    $servicetypelists=DropdownManagement::find()
    ->where(['key'=>"service_type"])
    ->asArray()
    ->all();
    //echo "<pre>";  print_r($servicetypelists);die;
    $ceek=array();
    foreach ($servicetypelists as $key => $value) {
    $ceek[]=$value['value'];
    }
    if(!empty($servicetypelists)){
    $list['status'] = "success";
    $list['message'] = "Service Type List";
    $list['service_type']=$ceek;
    }else{
    $list['status'] = "error";
    $list['message'] = "Service Type No Data";
    $list['service_type']=$ceek;
    }
    }
    }
    if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
$response['Output'][] = $list;
return json_encode($response);
}


public function actionUpdatename(){
  $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
     $list['status'] = 'error';
     $list['message'] = 'Invalid Apimethod';
    $field_check=array('phonenumber','name','apimethod');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="updatename";
    $model_log->created_at=date("Y-m-d H:i:s");
    $model_log->save();
    $log_id=$model_log->autoid;
    $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 

    if ($is_error == "yes") {
    $list['status'] = 'error';
    $list['message'] = $is_error_note . ' is Mandatory.';
    }else{

    $apimethod=$requestInput['apimethod'];
    $phonenumber=$requestInput['phonenumber'];
    $name=$requestInput['name'];

    if($apimethod=="poojaapi"){
    $customer_master=CustomerMaster::find()
    ->where(['phone'=>$phonenumber])
    ->asArray()
    ->one();
     if(!empty($customer_master)){
    $auth_key=Yii::$app->security->generateRandomString();
  $update=CustomerMaster::updateALL(['otp_status'=>'verified','user_type'=>'olduser','customer_name'=>$name,'auth_key'=>$auth_key,'platform'=>'mobile'],['phone'=>$phonenumber]);
  $customer_master_type=CustomerMaster::find()
    ->where(['phone'=>$phonenumber])
    ->asArray()
    ->one();
    $olduser=$customer_master_type['user_type'];
    $list['status'] = "success";
    $list['message'] = "User Updated Successfully";
    $list['user_type'] = $olduser;
    $list['auth_key'] = $auth_key;
    }else{
    $list['status'] = "error";
    $list['message'] = "Mobile Number Invalid";
    }
    }
    }
    if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
$response['Output'][] = $list;
return json_encode($response);
}
public function actionProcessdetails(){
  $list = array();
   $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
     $list['status'] = 'error';
     $list['message'] = 'Nill';
      $field_check=array('service_id');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="processdetails";
    $model_log->created_at=date("Y-m-d H:i:s");
    $model_log->save();
    $log_id=$model_log->autoid;
          $is_error = '';
 
foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 


     if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
    }else{

      $list['status'] = "success";
      $list['message'] = "Process details";
      $list['process_status'] = "1";
      $list['brand'] = "Haier";
       $list['date'] = "13/02/2019";
          $list['time'] = "04:45 PM";
           $list['service_type'] = "General service";
            $list['service_person_name'] = "MR. Jagan";
             $list['phone_no'] = "9876543210";

if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }

 $response['Output'][] = $list;
    return json_encode($response);

    
}
}


//Boooked Save
public function actionBookservice(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','phone_number','product_id','brand_id','service_id','date','time','address','remarks');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="bookservice";
    $model_log->created_at=date("Y-m-d H:i:s");
    $model_log->save();
    $log_id=$model_log->autoid;
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 
    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
    }else{

    $apimethod=$requestInput['apimethod'];
    $product_id=$requestInput['product_id'];
    $brand_id=$requestInput['brand_id'];
    $phone_number=$requestInput['phone_number'];
    $service_id=$requestInput['service_id'];
    $date=$requestInput['date'];
    $time=$requestInput['time'];
    $address=$requestInput['address'];
    $remarks=$requestInput['remarks'];
  if($apimethod=="bookservice"){
    
    $model = new StatusModule();
    $model->product_id=$brand_id;
    $model->brand_id=$brand_id;
    $model->service_type=$service_id;
    $model->phone_number=$phone_number;
    $model->date=$date;
    $model->time=$time;
    $model->address=$address;
    $model->remarks=$remarks;
    $model->status="pending";
    $model->re_schedule="no";
    if($model->save()){
    }else{
    echo "<pre>";print_r($model->getErrors());die;
    }
    $list['status'] = "success";
    $list['message'] = "booking created successfully";
  }
  }
//Log Table 
  if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
   $response['Output'][] = $list;
   return json_encode($response);
  }

//BookService List
  public function actionBookservicelist(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','phone_number');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="bookservicelist";
    $model_log->created_at=date("Y-m-d H:i:s");
    $model_log->save();
    $log_id=$model_log->autoid;
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 
    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
    }else{


    $apimethod=$requestInput['apimethod'];
    $phone_number=$requestInput['phone_number'];
  
    if($apimethod=="bookservicelist"){
   
 //  echo "<pre>";
    $booklisttable=StatusModule::find()
    ->where(['phone_number'=>$phone_number])
    ->andWhere(['NOT IN','phone_number',array(0)])
    ->orderBy(['created_at'=>SORT_DESC])
    ->asArray()
    ->all();

//print_r($booklisttable);die;

    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();

    $technician=TechnicianMaster::find()
    ->asArray()
    ->all();

  if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
  }
  if(!empty($categorylist)){  
  $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
  }

    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');

   }
    if(!empty($booklisttable)){
       $listva=array();
      foreach ($booklisttable as $key => $value) {
        
        $technician_id=$value['technician_id'];

        $product_id=$value['product_id'];
        $service_type=$value['service_type'];
        $categoryname="";
        if(isset($categorylistindex[$product_id])){
          $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
        }
        $servicenames="";
        if(isset($servicelistindex[$service_type])){
          $servicenames=ucfirst($servicelistindex[$product_id]['service_type']);
        }
        $listva['id']=$value['auto_id'];
        $listva['service_type']=$categoryname.' - '.$servicenames;
        $listva['status']=$value['status'];
        $listva['date']=$value['date'];
        $listva['phone_number']=$value['phone_number'];
        $listva['time']=$value['time'];
        $listva['cancel_remarks']="";
        if($value['cancel_remarks']!=""){

        $listva['cancel_remarks']=$value['cancel_remarks'];
        }
        $listva['re_schedule']="no";
        if($value['re_schedule']!=""){
        $listva['re_schedule']=$value['re_schedule'];
        }
        $listva['re_date']="";
        if($value['re_date']!=""){
        $listva['re_date']=$value['re_date'];
        }
        $listva['re_time']="";
        if($value['re_time']!=""){
        $listva['re_time']=$value['re_time'];
        }
        $listva['address']=$value['address'];
        if($technician_id!=""){
        if($technicianindex[$technician_id]){
        $listva['technician']=$technicianindex[$technician_id]['technician_name'];
        }
        }else{
        $listva['technician']="";
        }

        $listva['created_at']=$value['created_at'];
        $list['bookinglist'][]=$listva;
        $list['status'] = "success";
        $list['message'] = "List of service.";
      }
    }else{
    $list['status'] = "success";
    $list['message'] = "No Service Data.";
    }
  }
  }
//Log Table 
   if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
   $response['Output'][] = $list;
   return json_encode($response);
  }

  //History Service

  //BookService List
  public function actionBookservicelisthistory(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','servicehistory');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="bookservicelist";
    $model_log->created_at=date("Y-m-d H:i:s");
    $model_log->save();
    $log_id=$model_log->autoid;
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 
    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
    }else{


    $apimethod=$requestInput['apimethod'];
    $phone_number=$requestInput['phone_number'];
  
    if($apimethod=="servicehistory"){

    $booklisttable=StatusModule::find()
    ->where(['IN','status',array('Cancelled','Completed')])
    ->andWhere(['phone_number'=>$phone_number])
    ->andWhere(['NOT IN','phone_number',array(0)])
    ->orderBy(['created_at'=>SORT_DESC])
    ->asArray()
    ->all();


    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();

    $technician=TechnicianMaster::find()
    ->asArray()
    ->all();

  if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
  }
  if(!empty($categorylist)){  
  $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
  }

    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');

   }
    if(!empty($booklisttable)){
       $listva=array();
      foreach ($booklisttable as $key => $value) {
        
        $technician_id=$value['technician_id'];

        $product_id=$value['product_id'];
        $service_type=$value['service_type'];
        $categoryname="";
        if(isset($categorylistindex[$product_id])){
          $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
        }
        $servicenames="";
        if(isset($servicelistindex[$service_type])){
          $servicenames=ucfirst($servicelistindex[$product_id]['service_type']);
        }
        $listva['id']=$value['auto_id'];
        $listva['service_type']=$categoryname.' - '.$servicenames;
        $listva['status']=$value['status'];
        $listva['phone_number']=$value['phone_number'];
        $listva['date']=$value['date'];
        $listva['time']=$value['time'];
        $listva['cancel_remarks']="";
        if($value['cancel_remarks']!=""){

        $listva['cancel_remarks']=$value['cancel_remarks'];
        }
        $listva['re_schedule']="no";
        if($value['re_schedule']!=""){
        $listva['re_schedule']=$value['re_schedule'];
        }
        $listva['re_date']="";
        if($value['re_date']!=""){
        $listva['re_date']=$value['re_date'];
        }
        $listva['re_time']="";
        if($value['re_time']!=""){
        $listva['re_time']=$value['re_time'];
        }
        $listva['address']=$value['address'];
        if($technician_id!=""){
        if($technicianindex[$technician_id]){
        $listva['technician']=$technicianindex[$technician_id]['technician_name'];
        }
        }else{
        $listva['technician']="";
        }

        $listva['created_at']=$value['created_at'];
        $list['bookinglist'][]=$listva;
        $list['status'] = "success";
        $list['message'] = "List of service.";
      }
    }else{
    $list['status'] = "success";
    $list['message'] = "No Service Data.";
    }
  }
  }
//Log Table 
   if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
   $response['Output'][] = $list;
   return json_encode($response);
  }

  //BookService List
  public function actionBookservicelisthistoryview(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','service_id');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="historyview";
    $model_log->created_at=date("Y-m-d H:i:s");
    $model_log->save();
    $log_id=$model_log->autoid;
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 
    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
    }else{


    $apimethod=$requestInput['apimethod'];
    $service_id=$requestInput['service_id'];
  
    if($apimethod=="servicehistory"){

    $booklisttable=StatusModule::find()
    ->where(['auto_id'=>$service_id])
    ->andWhere(['IN','status',array('Cancelled','Completed')])
    ->orderBy(['created_at'=>SORT_DESC])
    ->asArray()
    ->all();


    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();

    $technician=TechnicianMaster::find()
    ->asArray()
    ->all();

  if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
  }
  if(!empty($categorylist)){  
  $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
  }

    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');

   }
    if(!empty($booklisttable)){
       $listva=array();
      foreach ($booklisttable as $key => $value) {
        
        $technician_id=$value['technician_id'];

        $product_id=$value['product_id'];
        $service_type=$value['service_type'];
        $categoryname="";
        if(isset($categorylistindex[$product_id])){
          $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
        }
        $servicenames="";
        if(isset($servicelistindex[$service_type])){
          $servicenames=ucfirst($servicelistindex[$product_id]['service_type']);
        }
        $listva['id']=$value['auto_id'];
        $listva['service_type']=$categoryname.' - '.$servicenames;
        $listva['status']=$value['status'];
        $listva['date']=$value['date'];
        $listva['phone_number']=$value['phone_number'];
        $listva['time']=$value['time'];
        $listva['cancel_remarks']="";
        if($value['cancel_remarks']!=""){

        $listva['cancel_remarks']=$value['cancel_remarks'];
        }
        $listva['re_schedule']="no";
        if($value['re_schedule']!=""){
        $listva['re_schedule']=$value['re_schedule'];
        }
        $listva['re_date']="";
        if($value['re_date']!=""){
        $listva['re_date']=$value['re_date'];
        }
        $listva['re_time']="";
        if($value['re_time']!=""){
        $listva['re_time']=$value['re_time'];
        }
        $listva['address']=$value['address'];
        if($technician_id!=""){
        if($technicianindex[$technician_id]){
        $listva['technician']=$technicianindex[$technician_id]['technician_name'];
        }
        }else{
        $listva['technician']="";
        }

        $listva['created_at']=$value['created_at'];
        $list['bookinglist'][]=$listva;
        $list['status'] = "success";
        $list['message'] = "List of service.";
      }
    }else{
    $list['status'] = "success";
    $list['message'] = "No Service Data.";
    }
  }
  }
//Log Table 
   if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
   $response['Output'][] = $list;
   return json_encode($response);
  }
  
  public function actionBookservicelistdetails(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','booking_id');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="bookservicelistdetails";
    $model_log->created_at=date("Y-m-d H:i:s");
    $model_log->save();
    $log_id=$model_log->autoid;
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 
    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
    }else{
    $apimethod=$requestInput['apimethod'];
    $booking_id=$requestInput['booking_id'];
    if($apimethod=="bookservicelist"){
    $booklisttable=StatusModule::find()
    ->where(['auto_id'=>$booking_id])
    ->orderBy(['created_at'=>SORT_DESC])
    ->asArray()
    ->all();
    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();

     $technician=TechnicianMaster::find()
    ->asArray()
    ->all();

    if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
    }

    if(!empty($categorylist)){  
     $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
    } 
    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');

   }
    if(!empty($booklisttable)){
       $listva=array();
       $listvade=array();
       $listvadess=array();
      foreach ($booklisttable as $key => $value) {
        
        $technician_id=$value['technician_id'];
        $product_id=$value['product_id'];
        $service_type=$value['service_type'];
        $categoryname="";
        if(isset($categorylistindex[$product_id])){
          $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
        }
        $servicenames="";
        if(isset($servicelistindex[$service_type])){
          $servicenames=ucfirst($servicelistindex[$product_id]['service_type']);
        }
        $listva['id']=$value['auto_id'];
        $listva['service_type']=$categoryname.' - '.$servicenames;
        $listva['status']=$value['status'];
        $listva['date']=$value['date'];
        $listva['time']=$value['time'];
        $listva['cancel_remarks']="";
        if($value['cancel_remarks']!=""){

        $listva['cancel_remarks']=$value['cancel_remarks'];
        }
        $listva['re_schedule']="no";
        if($value['re_schedule']!=""){
        $listva['re_schedule']=$value['re_schedule'];
        }
        $listva['re_date']="";
        if($value['re_date']!=""){
        $listva['re_date']=$value['re_date'];
        }
        $listva['re_time']="";
        if($value['re_time']!=""){
        $listva['re_time']=$value['re_time'];
        }
        $listva['address']=$value['address'];
        if($technician_id!=""){
        if($technicianindex[$technician_id]){
        $listva['technician']=$technicianindex[$technician_id]['technician_name'];

        $name=$technicianindex[$technician_id]['technician_name'];
        $phone_no=$technicianindex[$technician_id]['phone_no'];
        $email_id=$technicianindex[$technician_id]['email_id'];

        $listvadess['name']=$name;
        $listvadess['phone_no']=$phone_no;
        $listvadess['email_id']=$email_id;
        }
        }else{
        $listva['technician']="";
        $listvadess['name']="";
        $listvadess['phone_no']="";
        $listvadess['email_id']="";
        }
        $listva['created_at']=$value['created_at'];
        $listva['technician_details'][]=$listvadess;
        $list['bookinglist'][]=$listva;
        $list['status'] = "success";
        $list['message'] = "List of service.";
      }
    }else{
    $list['status'] = "success";
    $list['message'] = "No Service Data.";
    }
  }
  }
//Log Table 
  if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
   $response['Output'][] = $list;
   return json_encode($response);
  }

/*Service Module LisT*/

public function actionServicedetails(){
  $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
     $list['status'] = 'error';
     $list['message'] = 'Invalid Apimethod';
    $field_check=array('category_key','apimethod');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="servicedetails";
    $model_log->created_at=date("Y-m-d H:i:s");
    $model_log->save();
    $log_id=$model_log->autoid;
    $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 
    if ($is_error == "yes") {
    $list['status'] = 'error';
    $list['message'] = $is_error_note . ' is Mandatory.';
    }else{
    $apimethod=$requestInput['apimethod'];
    $catageory_key=$requestInput['category_key'];

    if($apimethod=="poojaapi"){

    $brand_mapping=BrandMapping::find()
    ->where(['service_id'=>$catageory_key])
    ->asArray()
    ->all();
   //echo "<pre>";print_r($brand_mapping);die;
    $service_module=ServiceModule::find()
    ->where(['service_id'=>$catageory_key])
    ->asArray()
    ->all(); 
  $det_list1=array();
    if($brand_mapping!="" && $service_module !=""){
    foreach ($brand_mapping as $key => $value) {
    $det['service_list']=$value['service_id'];
    $det['brands']=$value['brands'];
    $det['brand_id']=$value['autoid'];
    $det['description']=$value['description'];
    $det1[]=$det;
    }  
    foreach ($service_module as $key => $value) {
    $det_list['auto_id']=$value['auto_id'];
    $det_list['service_list']=$value['service_id'];
    $det_list['service_type']=$value['service_type'];
    $det_list['description']=$value['description'];
    $det_list1[]=$det_list;
    }    
    $list['status']='success';
    $list['message']='success';
    $list['brands']=$det1;
    $list['service_type']=$det_list1;
    }
    else if($brand_mapping!=""){
    foreach ($brand_mapping as $key => $value) {
    $det['service_list']=$value['service_id'];
    $det['brands']=$value['brands'];
    $det['brand_id']=$value['autoid'];
    $det['description']=$value['description'];
    $det1[]=$det;
    $list['status']='success';
    $list['message']='success';
    $list['brands']=$det1;
    $list['service_type']=array();
    }  
    }
    elseif($service_module!=""){
     foreach ($service_module as $key => $value) {
    $det_list['auto_id']=$value['auto_id'];
    $det_list['service_list']=$value['service_id'];
    $det_list['service_type']=$value['service_type'];
    $det_list['description']=$value['description'];
    $det_list1[]=$det_list;
    }
    $list['status']='success';
    $list['message']='success';
    $list['brands']=array();
    $list['service_type']=$det_list1;
    }    
    }
    else{
      $list['status']='success';
      $list['message']='List not Available';
      $list['brands']=array();
      $list['service_type']=array();
      }

     }
  if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
$response['Output'][] = $list;
return json_encode($response);
}

}
