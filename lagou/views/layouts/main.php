<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\URL;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$session = Yii::$app->session;
    $userid  = $session->get('user_id');
    $userid  = $userid?$userid:'';
    if($userid){
        $command = Yii::$app->db->createCommand('SELECT * FROM user WHERE user_id=:id');
        $user    = $command->bindValue(':id',$userid)->queryOne();
        $user_name = $user['username'];
    }
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    
</head>
<body>
<?php $this->beginBody() ?>

    <div id="header">
        <div class="wrapper">
            <a href="index.html" class="logo">
                <img src="style/images/logo.png" width="229" height="43" alt="拉勾招聘-专注互联网招聘" />
            </a>
            <ul class="reset" id="navheader">
                <li class="current"><a href="index.html">首页</a></li>
                <li ><a href="companylist.html" >公司</a></li>
                <li ><a href="#" target="_blank">论坛</a></li>
                                    <li ><a href="<?= URL::to(['index/resume'])?>" rel="nofollow">我的简历</a></li>
                                                    <li ><a href="create.html" rel="nofollow">发布职位</a></li>
                            </ul>
                        <ul class="loginTop">
                        <?php if(empty($user_name)) {?>
                <li><a href="<?= URL::to(['login/login'])?>" rel="nofollow">登录</a></li> 
                <li>|</li>
                <li><a href="<?= URL::to(['login/register'])?>" rel="nofollow">注册</a></li>
                        <?php }?>
                
            </ul>
            <?php if(!empty($user_name)){?>
            <dl class="collapsible_menu">
                <dt>
                    <span><?= $user_name?>&nbsp;</span> 
                    <span class="red dn" id="noticeDot-0"></span>
                    <i></i>
                </dt>
                <dd><a rel="nofollow" href="jianli.html">我的简历</a></dd>
                <dd><a href="collections.html">我收藏的职位</a></dd>
                <dd class="btm"><a href="subscribe.html">我的订阅</a></dd>
                <dd><a href="create.html">我要招人</a></dd>
                <dd><a href="accountBind.html">帐号设置</a></dd>
                <dd class="logout"><a rel="nofollow" href="<?= URL::to(['login/login_out'])?>">退出</a></dd>
            </dl>
            <?php }?>
                                </div>
    </div><!-- end #header -->
        <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
