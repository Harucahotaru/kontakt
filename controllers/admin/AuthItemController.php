<?php

namespace app\controllers\admin;

use app\classes\AccessControl;
use app\models\AuthItem;
use app\models\AuthItemSearch;
use app\models\ControllerRules;
use app\models\User;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthItemController implements the CRUD actions for AuthItem model.
 */
class AuthItemController extends BasicAdminController
{
    /**
     * Lists all AuthItem models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $name Name
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($name)
    {
        return $this->render('view', [
            'model' => $this->findModel($name),
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AuthItem();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'name' => $model->name]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $name Name
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($name)
    {
        $model = $this->findModel($name);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'name' => $model->name]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name Name
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($name)
    {
        $this->findModel($name)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $name Name
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name): AuthItem
    {
        if (($model = AuthItem::findOne(['name' => $name])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionEditRules(): string
    {
        return $this->render('addAccess', [
            'authItem' => $this->findModel(Yii::$app->request->get('name')),
        ]);
    }

    /**
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionSaveTiles(): string
    {
        $authRules = [];

        $authItem = $this->findModel(Yii::$app->request->post('auth_item_name'));
        $newAdminTiles = explode(',', Yii::$app->request->post('rules'));
        if (is_string($authItem->admin_tiles)) {
            $authItem->admin_tiles = json_decode($authItem->admin_tiles);
        }
        if (!empty($authItem->admin_tiles)) {
            $authItem->admin_tiles = json_encode(array_unique(array_merge($newAdminTiles, $authItem->admin_tiles)));
        } else {
            $authItem->admin_tiles = json_encode($newAdminTiles);
        }

        if (Yii::$app->request->post('can_view_cost') == 1) {
            $authRules['can_view_cost'] = (bool)Yii::$app->request->post('can_view_cost');
        }

        if (Yii::$app->request->post('can_use_cart') == 1) {
            $authRules['can_use_cart'] = (bool)Yii::$app->request->post('can_use_cart');
        }

        $authItem->rules = json_encode($authRules);

        $authItem->save();

        if (!empty($authItem->errors)) {
            throw new Exception("Не удалось сохранить права роли $authItem->name");
        }

        return $this->actionIndex();
    }
}

