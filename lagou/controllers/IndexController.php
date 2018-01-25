<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\URL;

/**
* 
*/
class IndexController extends Controller
{
	public $enableCsrfValidation=false; 

	public function actionIndex()
	{
		return $this->renderPartial('index');
	}

	public function actionResume()
	{
		$session = Yii::$app->session;
		$userid  = $session->get('user_id');
		if(empty($userid))
		{
			return $this->redirect(URL::to(['login/login']));
		}
		return $this->renderPartial('resume');
	}

	public function actionResume_do()
	{
		$session = Yii::$app->session;
		$userid  = $session->get('user_id');
		$res = Yii::$app->db->createCommand()->update('user_particulars',$_POST,"user_id=$userid")->execute();
		if($res){
			$data['success']=true;
		}else{
			$data['success']=false;
		}
		echo json_encode($data);
	}
	public function actionExpect()
	{
		$session = Yii::$app->session;
		$userid  = $session->get('user_id');
		$_POST['user_id']=$userid;
		$res = Yii::$app->db->createCommand()->insert('job_want',$_POST)->execute();
		if($res){
			$data['success']=true;
		}else{
			$data['success']=false;
		}
		echo json_encode($data);
	}
	public function actionSave()
	{
		$session = Yii::$app->session;
		$userid  = $session->get('user_id');
		$_POST['user_id']=$userid;
		$res = Yii::$app->db->createCommand()->insert('job_undergo',$_POST)->execute();
		if($res){
			$data['success']=true;
		}else{
			$data['success']=false;
		}
		echo json_encode($data);
	}
}
?>