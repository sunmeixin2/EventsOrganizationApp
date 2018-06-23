<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 	登录页面
*/
class Login_controller extends CI_Controller
{

	/**
	*	加载登录/注册界面视图
	*/

	public function index($page = "login"){
		
		if ( ! file_exists(APPPATH.'views/web/'.$page.'.php'))
        	show_404();

   	 	$page=ucfirst($page).'.php';

   	 	$this->load->view("web/".$page);
	
	}

	/**
	*	处理用户提交的登录信息
	*/

	public function sign_in(){
	
		$username=trim($this->input->post('username'));
		$pwd=trim($this->input->post('pwd')); 
		
		//根据用户名查询用户信息
		if(!empty($username) && !empty($pwd)){
			

			$sql="select uid,pwd,groupid from user where username = ?";
			$where=array('username'=>$username);
			$user_info_one=$this->check($sql,$where);
			
			 var_dump($user_info_one);
			 exit();
			//判断用户是否存在或密码是否正确
			if(!empty($user_info_one)){

				if($pwd == $user_info_one[0]['pwd']){		//密码md5()加密
					
					//设置session
					$_SESSION['uid']=$user_info_one[0]['uid'];
					$_SESSION['groupid']=$user_info_one[0]['groupid'];
					$_SESSION['username']=$username;

					$error_code=0;
					$data=array(
						'uid'=>$user_info_one[0]['uid'],
						'groupid'=>$user_info_one[0]['groupid'],
						'username'=>$username
					);
					$error_message="";		

					//$this->load->view('web/index.php');
				}else{
					$error_code=1001;
					$data=array();
					$error_message="密码错误";
				}

			}else{
				$error_code=1002;
				$data=array();
				$error_message="此用户不存在";
			}

		}else{
			$error_code=1003;
			$data=array();
			$error_message="用户名或密码不能为空";
		}

		$json=$this->json($error_code,$data,$error_message);
		echo json_encode($json);
	}

	/**
	*	处理用户提交的注册信息
	*/

	public function sign_up(){

		$username=trim($this->input->post('username'));
		$pwd=trim($this->input->post('pwd')); 
		$pwd2=trim($this->input->post('pwd2'));
		$captcha=trim($this->input->post('captcha'));
		
		if(!empty($username) && !empty($pwd) && !empty($pwd2) && !empty($captcha)){
			if($pwd2 != $pwd){
				$error_code=1004;
				$data=array();
				$error_message="两次输入密码不一致";
			}
			elseif($captcha !=$_SESSION['captcha']){
				$error_code=1008;
				$data=array();
				$error_message="验证码输入不正确";
			}
			else{				

				$sql="select uid from user where username = ? ";
				$where=array('username'=>$username); 

			
				//查询此用户名是否已经被注册过
				
				$result=$this->check($sql,$where);

				if(empty($result)){		//用户未被注册

					$info=array(
						'username'=>$username,
						'pwd' =>$pwd,
						'reg_time'=>date('Y-m-d H:i:s',time()),
						'update_time'=>date('Y-m-d H:i:s',time())
					);
				
					$this->load->model('user_model','user');
					$status=$this->user->insert($info);
					if($status){
						$error_code=0;
						$data['success_message']="注册成功";
						$error_message=""; 
					}else{
						$error_code=1005;
						$data=array();
						$error_message="注册失败";
					}
				}else{		//用户名已被注册
					$error_code=1006;
					$data=array();
					$error_message="用户名已被注册";
				}
			}
		}
		else{
			$error_code=1007;
			$data=array();
			$error_message="信息不能为空";
		}
		$json = $this->json($error_code,$data,$error_message);
		echo json_encode($json);
	}

	/**
	*	查询某用户是否存在
	*/

	protected function check($sql,$where){

		$this->load->model("user_model","user");
		$result=$this->user->select($sql,$where);

		return $result;
	}

	/**
		** 打包json信息
		* $error_code     错误状态码
		* $data  	      数据
		* $error_message  错误信息解释
	*/
	protected function json($error_code,$data,$error_message){
		if($error_code!=0){
			$result=array(
				'error_code'=>$error_code,
				'error_message'=>$error_message
			);
		}else{
			$result=array(
				'error_code'=>$error_code,
				'data'=>$data
			);
		}
		return $result;
	}

	/**
	*	验证码
	*/
 	public  function captcha(){

 		$this->load->library('ValidateCode');

 		$_vc=new ValidateCode();

 		$_vc->doimg();
 		$_SESSION['captcha'] = $_vc->getCode();//验证码保存到SESSION中
		
 	}


}

?>