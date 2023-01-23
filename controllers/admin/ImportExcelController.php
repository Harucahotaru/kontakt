<?php

namespace app\controllers\admin;

use app\classes\ParseExcel;
use app\models\Products;
use Yii;
use yii\web\Controller;

class ImportExcelController extends Controller
{
    public function actionIndex() {
        $excel = [];
        $formname = 'form-excel';
        $actionForm = '';
        $model = new Products();


        return $this->render('index', [
            'previewExcel' => $excel,
            'formname' => $formname,
            'actionForm' => $actionForm,
            'model' => $model
        ]);
    }

    public function actionRenderPreviewExcel() {
        if (Yii::$app->request->isPost) {
            $this->layout = false;
            $filepath = $_FILES['excel']['tmp_name'];
            $parseExcel = new ParseExcel();
            $excel = $parseExcel->preview($filepath);
            return $this->render('_preview', [
                'previewExcel' => $excel,
                'model' => new Products()
            ]);
        }
        return '';
    }

    public function actionIndexq() {
        return $this->render('index', [
            'time' => 'qwe'
        ]);
    }
}