<?php

namespace app\controllers\admin;

use app\models\Products;
use app\models\Reviews;
use Throwable;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ReviewsController extends Controller
{
    public function actionIndex($reviewType = 0)
    {
        return $this->render('index', [
            'reviewsType' => $reviewType,
            'dataProvider' => Reviews::getAllReviewsByTypeProvider($reviewType, true)
            ]);
    }

    /**
     * @param int $reviewId
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionDelete(int $reviewId): Response
    {
        $this->findModel($reviewId)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Разрешить показывать отзыв всем пользователям
     *
     * @param int $reviewId
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function actionAccept(int $reviewId): Response
    {
        /** @var Reviews $reviewModel */
        $reviewModel = $this->findModel($reviewId);
        $reviewModel->setAccepted();
        $reviewModel->save();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     *
     * @return Reviews|null
     *
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ?Reviews
    {
        if (($model = Reviews::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена');
    }
}