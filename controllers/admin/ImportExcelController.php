<?php

namespace app\controllers\admin;

use app\classes\AccessControl;
use app\classes\ParseExcel;
use app\exceptions\ImageException;
use app\exceptions\ImportException;
use app\models\ControllerRules;
use app\models\Products;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use Yii;
use yii\web\Controller;

class ImportExcelController extends BasicAdminController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
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

    /**
     * @return string
     * @throws Exception
     */
    public function actionRenderPreviewExcel(): string
    {
        if (Yii::$app->request->isPost) {
            $this->layout = false;
            $filepath = $_FILES['excel']['tmp_name'];
            $parseExcel = new ParseExcel();
            $excel = $parseExcel->preview($filepath);

            return $this->renderAjax('_preview', [
                'previewExcel' => $excel,
                'parsedExcel' => $parseExcel->parseToArray($filepath),
                'model' => new Products()
            ]);
        }
        return '';
    }

    /**
     * @return string
     *
     * @throws ImportException
     */
    public function actionProductPreview(): string
    {
        $post = Yii::$app->request->post();
        $parsedExcel = json_decode(Yii::$app->request->post()['parsedExcel'], true);
        if (!empty($post['offset'])) {
            $parsedExcel = array_slice($parsedExcel, $post['offset'] -= 1);
        }

        $parsedExcelPreview = array_slice($parsedExcel, 0, 1);
        $previewProducts = $this->createProducts($parsedExcelPreview, $post['Products']);

        return $this->render('products-preview', [
            'parsedExcel' => $parsedExcel,
            'productsExample' => $post['Products'],
            'previewProducts' => $previewProducts,
        ]);
    }

    public function actionProductsSave()
    {
        $parsedExcel = json_decode(Yii::$app->request->post('parsedExcel'), true);
        $productsExample = json_decode(Yii::$app->request->post('productsExample'), true);
        $products = $this->createProducts($parsedExcel, $productsExample);

        /** @var Products $product */
        foreach ($products as $product) {
            if (!$product->save()) {
                $errorMassage = "Ошибка импорта товаров, проверьте правильность заполнения полей\n\n";
                foreach ($product->errors as $field => $error) {
                    foreach ($error as $description)
                       $errorMassage .= "Поле $field -> $description\n";
                }

                throw new ImportException($errorMassage);
            } else {
                Yii::$app->session->setFlash('success', 'Импорт прошел успешно');
            }
        }

        return $this->redirect('/admin/import-excel');
    }

    /**
     * Преобразование товара из excel в модель товара
     *
     * @param array $parsedExcel
     * @param array $productExample
     *
     * @return array
     *
     * @throws ImportException
     */
    private function createProducts(array $parsedExcel, array $productExample)
    {
        foreach ($parsedExcel as $line) {
            $productToSave = new Products();
            foreach ($productExample as $productAttribute => $attributeCell) {
                if ($attributeCell !== ParseExcel::HEADER_NOT_STATE_KEY) {
                    $productToSave->$productAttribute = $line[$attributeCell];
                }
            }
            $newProducts[] = $productToSave;
        }

        if (empty($newProducts)) {
            throw new ImportException('Не удалось загрузить значения товаров');
        }

        return $newProducts;
    }

}