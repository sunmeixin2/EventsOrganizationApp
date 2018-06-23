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
		$uid=$_SESSION['uid'];
		$groupid=$_SESSION['groupid'];
		$username=$_SESSION['username'];

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
		$publisher = $_SESSION['username'];
		$publish_time = trim($this->input->post('publish_time'));
		$start_time = trim($this->input->post('start_time'));
		$over_time = trim($this->input->post('over_time'));
		$details = trim($this->input->post('details'));
		$place = trim($this->input->post('place'));
		
		if(!empty($ac_name) && !empty($publish_time) && !empty($start_time) && !empty($over_time) && !empty($details) && !empty($place)){
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
			$this->activity->insert($info);

		}
	}


	public function test(){
		$this->load->view('web/files.php');
	}
	/**
		* 添加照片
	*/
	public function do_upload(){
		
		// var_dump($_FILES);
		// $pictures=array();

		// $i = 0;
		// //三维数组转换成2维数组
  //  		foreach ($_FILES as $v){
  
	 //        if(is_string($v['name'])){ //单文件上传
	 //            $pictures[$i] = $v;
	 //            $i++;
	 //        }else{ // 多文件上传
	 //            foreach ($v['name'] as $key=>$val){//2维数组转换成1维数组
	 //                //取出一维数组的值，然后形成另一个数组
	 //                //新的数组的结构为：pictures=>i=>('name','size'.....)
	 //                $_FILES['pictures'][$i]['name'] = $v['name'][$key];
	 //                $_FILES['pictures'][$i]['size'] = $v['size'][$key];
	 //                $_FILES['pictures'][$i]['type'] = $v['type'][$key];
	 //                $_FILES['pictures'][$i]['tmp_name'] = $v['tmp_name'][$key];
	 //                $_FILES['pictures'][$i]['error'] = $v['error'][$key];
	 //                $i++;
	 //            }
	 //        }
  //   	}
  //   	var_dump($pictures);
		//   $this->load->library('upload');  
    	
		// //循环处理上传文件  
		// foreach ($pictures as $key => $val) {
		//  	var_dump($val);
		//  	$config['file_name'] = time().mt_rand(100,999);
		//  	$this->upload->initialize($config);
		 	
		//  		if($this->upload->do_upload($val['pictures'])){
		//  			//上传成功
		//  			print_r($this->upload->data()); 
		//  		}else{
		//  			//上传失败
		//  			echo $this->upload->display_errors();  
		//  		}
		//  } 
    	
		
		
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

