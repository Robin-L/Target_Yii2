<?php

namespace backend\controllers;

use Yii;
use backend\models\MarketingImage;
use backend\models\search\MarketingImageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use common\models\PermissionHelpers;
use yii\web\UploadedFile;
use yii\imagine\Image;

/**
 * MarketingImageController implements the CRUD actions for MarketingImage model.
 */
class MarketingImageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only'  => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return PermissionHelpers::requireMinimumRole('Admin') && PermissionHelpers::requireStatus('Active');
                        }
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all MarketingImage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MarketingImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MarketingImage model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MarketingImage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MarketingImage();
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post())) {

            $imageName = $model->marketing_image_name;
            $model->file = UploadedFile::getInstance($model, 'file');

            $fileName = 'uploads/'.$imageName.'.'.$model->file->extension;
            $fileName = preg_replace('/\s+/', '', $fileName);

            $thumbName = 'uploads/' . 'thumbnail/' . $imageName . 'thumb.' . $model->file->extension;
            $thumbName = preg_replace('/\s+/', '', $thumbName);

            $model->marketing_image_path = $fileName;
            $model->marketing_thumb_path = $thumbName;

            $model->save();

            $model->file->saveAs($fileName);

            Image::thumbnail($fileName, 60, 60)->save($thumbName, ['quality' => 50]);

            return $this->redirect(['view', 'id' => $model->id, 'model' => $model,]);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }

    /**
     * Updates an existing MarketingImage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $imageName = $model->marketing_image_name;
            $oldImage = MarketingImage::find('marketing_image_name')->where(['id' => $id])->one();

            if ($oldImage->marketing_image_name != $imageName) {
                throw new ForbiddenHttpException('You cannot change the name, you must delete instead.');
            }

            if( $model->file = UploadedFile::getInstance($model, 'file')) {
                $thumbName = 'uploads/' . 'thumbnail/' . $imageName. 'thumb.' . $model->file->extension;
                $model->save();
            } else {
                $model->save();
            }

            if ($model->file) {
                $fileName = 'uploads/' . $imageName . '.' . $model->file->extension;
                $model->file->saveAs($fileName);

                Image::thumbnail($fileName, 60, 60)->save($thumbName, ['quality' => 50]);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', ['model' => $model]);
        }
    }

    /**
     * Deletes an existing MarketingImage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        try {
            unlink($model->marketing_image_path);
            unlink($model->marketing_thumb_path);
            $model->delete();
            return $this->redirect(['index']);
        } catch (\Exception $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    /**
     * Finds the MarketingImage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MarketingImage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MarketingImage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
