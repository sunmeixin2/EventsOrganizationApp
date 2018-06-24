<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 	主页
*/
class Home_controller extends CI_Controller
{

	private $sql=NULL;
	/**
		* 返回主页所有活动信息
	*/
	public function index(){

		//用户是否登录
		if(isset($_SESSION['uid']) && isset($_SESSION['groupid']) 
			&& isset($_SESSION['username'])){

			$uid=$_SESSION['uid'];
			$groupid=$_SESSION['groupid'];
			$username=$_SESSION['username'];

		}else{		//用户未登录  以游客身份闲逛
			$uid='';
			$groupid='';
			$username='';
		}

		
		$sql="select id,ac_name,publisher,publish_time,start_time,over_time,details,picture 
		 	from activity";

		$this->load->model('activity_model','activity');
		$activity_info_all=$this->activity->select($sql);

		$error_code=0;
		$data['user']=array(
			'uid' => $uid,
			'groupid' => $groupid,
			'username' => $username
		);
		$data['activities']=$activity_info_all;
		$error_message="";

		$json = $this->json($error_code,$data,$error_message);
		echo json_encode($json);
	}

	/**
		* 添加活动
	*/
	public function add_Activity(){

		$ac_name = trim($this->input->post('ac_name'));
		$publish_time = trim($this->input->post('publish_time'));
		$start_time = trim($this->input->post('start_time'));
		$over_time = trim($this->input->post('over_time'));
		$details = trim($this->input->post('details'));
		$place = trim($this->input->post('place'));


		//判断用户是否登录
		if(isset($_SESSION['username'])){
			$publisher = $_SESSION['username'];
		}else{
			$error_code=1003;
			$data=array();
			$error_message="用户还未登录";
		}
		
		//提交表单信息
		if(empty($publisher) || empty($ac_name) || empty($publish_time) || empty($start_time) || empty($over_time) || empty($details) || empty($place) ){
			
			$error_code=1004;
			$data=array();
			$error_message="表单信息不完整";
		}
		else{
			
			$info = array(
				'ac_name' => $ac_name,
				'publisher' => $publisher,
				'publish_time' => $publish_time,
				'start_time' => $start_time,
				'over_time' => $over_time,
				'details' => $details,
				'place' => $place
			);

			$this->load->model('Activity_model','activity');
			$result = $this->activity->insert($info);

			if($result){
				$error_code=0;
				$data=array(
					'id' =>$result
				);
				$error_message="";
			}else{
				$error_code=1005;
				$data=array();
				$error_message="表单提交出错";
			}
		}

		$json = $this->json($error_code,$data,$error_message);
		echo json_encode($json);
	}

	/**
		* 上传照片
	*/
	public function do_upload(){

		$id=trim($this->input->post('id'));
		

		if(empty($id)){
			$error_code=1006;
			$data=array();
			$error_message="没有活动id";
		}else{

			//载入文件上传类
			$this->load->library('Upload');

			$upload = new Upload('image');  
			$res = $upload->uploadFile();
			
			$image = "";
			foreach ($res as  $val) {
				if($val['errno'] === '000'){
					$sub_str=explode('/', $val['dest']);
					$image .= '|'.$sub_str[count($sub_str)-1];
					
				}else{
					$image="";
					$error=$val['error'];
					break;
				}
			}

			if(empty($image)){	//上传照片过程中出错
				
				$error_code=1008;
				$data=array();
				$error_message=$error;
			}	
			else{

				$info = array(
					'picture' => substr($image,1),
					'id' => $id
				);
				
				//图片保存到数据库中
				$this->load->model('Activity_model','activity');
				if($this->activity->edit($info)){
					$error_code=0;
					$data['success_message']="上传图片成功";
					$error_message="";
					
				}else{
					$error_code=1008;
					$data=array();
					$error_message=$error;
				}
			}		
				
		}
		
		$json = $this->json($error_code,$data,$error_message);
		echo json_encode($json);
		
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

}

