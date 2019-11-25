<?php


namespace app\commands;

use app\models\User;
use Yii;

use yii\console\Controller;
use yii\helpers\ArrayHelper;

class RbacController extends Controller
{
    public function actionInit(){

        $auth = Yii::$app->getAuthManager();
        $auth->removeAll();

        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update a post';
        $auth->add($updatePost);

        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Update a own post';
        $auth->add($updateOwnPost);




        $user = $auth->createRole('user');
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $auth->addChild($admin, $user);
        $auth->addChild($admin, $createPost);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $updateOwnPost);


        $this->stdout('Done!' . PHP_EOL);

    }

    public function actionTest(){

        Yii::$app->set('request', new \yii\web\Request(
            [
                'cookieValidationKey' => 'AEQ7fyviYuSUSt5Klm75mzu7BYc0EkIX',

                'enableCookieValidation' => false,
                'enableCsrfCookie' => false,
                'enableCsrfValidation' => false,
            ]
        ));

//        debugf(Yii::$app, 'app');


        $user = new User([
            'id' => 1,
            'username' => 'User',

            ]);
        $admin = new User([
            'id' => 2,
            'username' => 'Admin',

            ]);

        $auth = Yii::$app->getAuthManager();

        $auth->revokeAll($user->id);
        $auth->revokeAll($admin->id);

        echo 'Roles for user:' . PHP_EOL;

        print_r($auth->getRolesByUser($user->id));

        $auth->assign($auth->getRole('user'), $user->id);
        $auth->assign($auth->getRole('admin'), $admin->id);

        echo 'New roles for user:' . PHP_EOL;
//
//        print_r(
//            ArrayHelper::map($auth->getRolesByUser($user->id), 'name', 'name')
//        );

        Yii::$app->user->login($user);
        var_dump(Yii::$app->user->can('admin'));
        Yii::$app->user->logout();

        Yii::$app->user->login($admin);
        var_dump(Yii::$app->user->can('admin'));


        echo PHP_EOL;


    }

}