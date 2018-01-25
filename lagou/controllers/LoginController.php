<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\db\ActiveRecord;
use yii\helpers\URL;
/**
* 
*/
class LoginController extends Controller
{
	public $enableCsrfValidation=false;

	public function actionLogin()
	{
		return $this->renderPartial('login');
	}

	public function actionRegister()
	{
		return $this->renderPartial('register');
	}

	public function actionRegister_do()
	{

		$email = $_POST['email'];
		
		Yii::$app->db->createCommand()->insert('user_particulars', [
		    'email' => $email,
		])->execute();
		$info_id = Yii::$app->db->getLastInsertID();

		$pwd   = md5($_POST['password']);
		$ip    = $_SERVER["REMOTE_ADDR"];
		Yii::$app->db->createCommand()->insert('user', [
		    'email' => $email,
		    'password' => $pwd,
		    'info_id'=>$info_id,
		    'create_time'=>time(),
		    'ip'=>$ip,
		])->execute();
		$id    = Yii::$app->db->getLastInsertID();
		if($id){
			Yii::$app->db->createCommand()->update('user_particulars', ['user_id' => $id], "if_id=$info_id")->execute();
			$session = Yii::$app->session;
			$session->set('user_id',$id);
			$data['success']=1;
		}else{
				$data['success']=0;
				$dat['content']="注册失败";
		}
		//var_dump($data);
		echo json_encode($data);
	}

	public function actionLogin_do()
	{
		$email = $_POST['email'];
		$pwd   = md5($_POST['password']);

		$user = Yii::$app->db->createCommand("SELECT * FROM user WHERE email='$email' and password='$pwd'")->queryOne();
		$id = $user['user_id'];
		$endtime = $user['create_time'];
		Yii::$app->db->createCommand()->update('user', ['create_time' => time(),'end_time'=>$endtime], "user_id=$id")->execute();
		if($user){
			$session = Yii::$app->session;
			$session->set('user_id',$id);
			$data['success']=1;
		}else{
				$data['success']=0;
				$data['content']="登录失败";
		}
		echo json_encode($data);
	}

	public function actionLogin_out()
	{
		$session = Yii::$app->session;
		$session->remove('user_id');
		$this->redirect(URL::to(['index/index']));
	}
}
?>