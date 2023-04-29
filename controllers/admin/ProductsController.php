<?php

namespace app\controllers\admin;

use app\classes\AccessControl;
use app\exceptions\ProductException;
use app\models\ControllerRules;
use app\models\Images;
use app\models\Products;
use app\models\ProductsCategories;
use app\models\ProductsImgs;
use app\models\ProductsSearch;
use Exception;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends BasicAdminController
{
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
     * Массовые действия с товарами товаров
     *
     * @throws ProductException
     * @throws Throwable
     */
    public function actionMassChange()
    {
        $actionType = Yii::$app->request->post('action');
        $value = Yii::$app->request->post('value');

        if (empty(Yii::$app->request->post('selection'))) {
            Yii::$app->session->setFlash('error', 'Товары не выбраны !');
            return $this->redirect(['index']);
        }
        $productsIds = json_decode(Yii::$app->request->post('selection'));

        if (!isset($value) || !isset($actionType) || $actionType === 0) {
            throw new ProductException('Неверные аргументы, попробуйте еще раз');
        }

        switch ($actionType) {
            case Products::ACTION_DELETE:
                foreach ($productsIds as $productId) {
                    try {
                        $result = $this->deleteProduct($productId);
                    } catch (Exception $e) {
                        throw new ProductException('Ошибка удаления товара');
                    }
                    if ($result === false) {
                        throw new ProductException('Ошибка удаления товара');
                    }
                }
                break;
            case Products::ACTION_SALE_STATUS:
                Products::updateAll(['on_sale' => $value], ['id' => $productsIds]);
                break;
            case Products::ACTION_CHANGE_CATEGORY:
                Products::updateAll(['category_id' => $value], ['id' => $productsIds]);
                break;
            case Products::ACTION_CHANGE_ACTIVE:
                Products::updateAll(['active' => $value], ['id' => $productsIds]);
                break;
        }

        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**`
     * Получение списка значений для массовых действий
     *
     * @return false|string|null
     */
    public function actionGetList()
    {
        $action = Yii::$app->request->post('depdrop_parents')[0];

        switch ($action) {
            case Products::ACTION_CHANGE_CATEGORY:
                $list = ProductsCategories::formatListToKartik(ProductsCategories::getAllCategoriesList());
                break;
            case Products::ACTION_SALE_STATUS:
                $list = [
                    ['id' => Products::STATUS_ACTIVE, 'name' => 'Скидка активна'],
                    ['id' => Products::STATUS_DISABLE, 'name' => 'Скидка не активна']
                ];
                break;
            case Products::ACTION_CHANGE_PROMOTION:
                $list = [
                    'Тут пока пусто...'
                ];
                break;
            case Products::ACTION_DELETE:
                $list = [['id' => 0, 'name' => 'Для этого действия не нужно выбирать значение']];
                break;
            case Products::ACTION_CHANGE_ACTIVE:
                $list = [
                    ['id' => Products::STATUS_ACTIVE, 'name' => 'Товар активен'],
                    ['id' => Products::STATUS_DISABLE, 'name' => 'Товар не активен']
                ];
                break;
            default:
                return null;

        }

        return json_encode(['output' => $list, 'selected' => '']);
    }

    /**
     * Сохранение пагинации товаров в куки
     *
     * @return Response
     */
    public function actionChangePagination(): Response
    {
        $paginationSize =  Yii::$app->request->post('paginationSize');

        if (!empty(Yii::$app->request->cookies->get('productsPagination'))) {
            Yii::$app->response->cookies->remove('productsPagination');
        }

        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'productsPagination',
            'value' => $paginationSize,
        ]));

        return $this->redirect('/admin/products');
    }
}
