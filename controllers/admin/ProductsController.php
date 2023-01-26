<?php

namespace app\controllers\admin;

use app\exceptions\ProductException;
use app\models\Images;
use app\models\Products;
use app\models\ProductsImgs;
use app\models\ProductsSearch;
use app\models\UserBasket;
use Exception;
use Throwable;
use Yii;
use yii\data\Pagination;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Products models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param int $id ID
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
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Products();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Изображение загружено');
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
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Изображение загружено');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(int $id): Response
    {
        $this->actionDelete($id);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param int $productId
     *
     * @return bool
     *
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function actionDeleteImg(int $productId): bool
    {
        $result = false;

        $product = Products::findOne(['id' => $productId]);

        if ($product !== null) {
            $imagesIds = ProductsImgs::findOne(['id' => $product->img_id]);
            if (!empty($imagesIds)) {
                $imagesIds->delete();
                if ($images = Images::findAll(['id' => json_decode($imagesIds->imgs_ids)])) {
                    foreach ($images as $image) {
                        $image->delete();
                    }
                }
            }
            $product->img_id = null;
            $result = $product->save();

            if (!empty($product->errors)) {
               Yii::$app->session->setFlash('error', implode(', ', $product->errors));
            }
        }

        return $result;
    }

    /**
     * @param int $id
     *
     * @return int|false
     *
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function deleteProduct(int $id)
    {
        if ($this->actionDeleteImg($id) === true) {
            return $this->findModel($id)->delete();
        }

        return false;
    }

    /**
     * Массовое удаление товаров
     *
     * @throws ProductException
     * @throws Throwable
     */
    public function actionMassDelete()
    {
        $productsIds = Yii::$app->request->post('selection');
        if (!empty($productsIds)) {
            foreach ($productsIds as $productId) {
                try {
                    if ($this->deleteProduct($productId) === false) {
                        throw new ProductException('Ошибка удаления товара');
                    }
                } catch (Exception $e) {
                    throw new ProductException('Ошибка удаления товара');
                }
            }
        }

        return $this->redirect(['index']);
    }
}
