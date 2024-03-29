<?php

namespace app\controllers;

use app\controllers\admin\ProductsController;
use app\models\AuthAssignment;
use app\models\ControllerRules;
use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\User;
use app\models\UserBasket;
use app\models\UserSearch;
use Exception;
use Yii;
use yii\base\InvalidParamException;
use app\classes\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => ControllerRules::getControllerRules(Yii::$app->controller->id),
            ]
        ];
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|\yii\web\Response
     *
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new User();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $model->addRoles([User::BASE_USER_ROLE]);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $allUserRoles = ArrayHelper::map(Yii::$app->authManager->roles, 'name', 'description');

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $newRoles = $this->request->post('User')['roles'];
            $oldRoles = $model->roles;
            $model->updateRoles($newRoles, $oldRoles);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'allRoles' => $allUserRoles
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                $user->addRoles([User::BASE_USER_ROLE]);
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'main';
        $passwordResetModel = new PasswordResetRequestForm();
        $arr = Yii::$app->request->post();
        if ($passwordResetModel->load($arr) && $passwordResetModel->validate()) {
            $user = User::findOne([
                'status' => User::STATUS_ACTIVE,
                'email' => $passwordResetModel->email,
            ]);
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
            $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/reset-password', 'token' => $user->password_reset_token]);
            return $this->render("mailView", [
                "link" => $resetLink,
                "userName" => $user->username
            ]);
        }

        return $this->render('requestPasswordResetToken', [
            'passwordResetModel' => $passwordResetModel,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     *
     * @throws BadRequestHttpException|\yii\base\Exception
     */

    public function actionResetPassword($token)
    {
        $this->layout = 'main';
        try {
            $resetPasswordModel = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($resetPasswordModel->load(Yii::$app->request->post())
            && $resetPasswordModel->validate()
            && $resetPasswordModel->resetPassword()
        ) {
            Yii::$app->session->setFlash('success', 'New password was saved.');
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'resetPasswordModel' => $resetPasswordModel,
        ]);
    }

    /**
     * @return string
     */
    public function actionProfile(): string
    {
        return $this->render('profile', [
            'user' => User::findOne(Yii::$app->user->id),
        ]);
    }

    /**
     * @return string
     */
    public function actionCart(): string
    {
        return $this->render('cart', [
            'user' => User::findOne(Yii::$app->user->id),
        ]);
    }

    /**
     * @return string
     */
    public function actionEditRules(): string
    {
        return $this->render('rules', [
            'user' => User::findOne(Yii::$app->request->get('id')),
        ]);
    }

    /**
     * @return string
     */
    public function actionSaveRules(): string
    {
        $user = User::findOne(['id' => Yii::$app->request->post('user_id')]);
        $userRules = explode(',', Yii::$app->request->post('rules'));
        unset($userRules[0]);

        $user->deleteAllUserRules();

        foreach ($userRules as $userRule) {
            $rulesModel = new AuthAssignment();
            $rulesModel->user_id = (string)$user->id;
            $rulesModel->item_name = $userRule;
            $rulesModel->save();
        }

        return $this->actionIndex();
    }

    public function actionAddToCartOne(): string
    {
        if (Yii::$app->request->isPost) {
            $newProduct['products_ids'] = json_encode([$this->request->post('product_id') => [
                'id' => (int)$this->request->post('product_id'),
                'number' => $this->request->post('number')
            ]]);

            $newProduct['user_id'] = $this->request->post('user_id');

            CatalogController::addProductToCart($newProduct);
        }

        return $this->actionCart();
    }

    public function actionAddToCartSome():string
    {
        if (!empty($this->request->post())) {
            $newProduct = [$this->request->post('product_id') => [
                'id' => (int)$this->request->post('product_id'),
                'number' => $this->request->post('number')
            ]];
            $basket = UserBasket::getByUser($this->request->post('user_id'));
            $products = json_decode($basket->products_ids, true);
            $products[key($newProduct)] = $newProduct[key($newProduct)];

            $basket->updateCart($products);
        }

        return $this->actionCart();
    }
}
