<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\Member;
use app\models\MemberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Activity;
use app\models\MemberActivity;
use yii\web\UploadedFile;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class MemberController extends Controller
{
    public $layout = 'adminlte';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['admin', 'validator'],
                        ],
                        [
                            'allow' => false,
                        ],
                    ],
                ],
            ]
        );
    }

    public function actionAssignActivities($id)
    {
        $request = Yii::$app->request;

        $member = Member::findOne($id);

        if (!$member) {
            throw new \yii\web\NotFoundHttpException('Member not found.');
        }

        $assignedIds = MemberActivity::find()
            ->select('activity_id')
            ->where([
                'member_id' => $member->id,
            ])
            ->column();

        $availableActivities = ArrayHelper::map(
            Activity::find()
                ->andWhere(['not in', 'id', $assignedIds])
                ->orderBy('activity_name')
                ->all(),
            'id',
            'activity_name'
        );

        $assignedActivities = ArrayHelper::map(
            Activity::find()
                ->where(['id' => $assignedIds])
                ->orderBy('activity_name')
                ->all(),
            'id',
            'activity_name'
        );

        if ($request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            return [

                'title' => 'Assign Activities',

                'content' => $this->renderAjax('assign-activities', [
                    'member' => $member,
                    'availableActivities' => $availableActivities,
                    'assignedActivities' => $assignedActivities,
                ]),

                'footer' =>
                Html::button(
                    'Close',
                    [
                        'class' => 'btn btn-secondary',
                        'data-dismiss' => 'modal',
                    ]
                ),

            ];
        }

        return $this->render('assign-activities', [
            'member' => $member,
            'availableActivities' => $availableActivities,
            'assignedActivities' => $assignedActivities,
        ]);
    }

    public function actionRemoveActivity()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $memberId = Yii::$app->request->post('member_id');
        $activityId = Yii::$app->request->post('activity_id');

        MemberActivity::deleteAll([
            'member_id' => $memberId,
            'activity_id' => $activityId,
        ]);

        return [
            'success' => true,
        ];
    }

    public function actionAssignActivity()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $memberId = Yii::$app->request->post('member_id');
        $activityId = Yii::$app->request->post('activity_id');

        if (empty($memberId) || empty($activityId)) {
            return [
                'success' => false,
                'message' => 'Invalid request.',
            ];
        }

        $exists = MemberActivity::find()
            ->where([
                'member_id' => $memberId,
                'activity_id' => $activityId,
            ])
            ->exists();

        if (!$exists) {

            $memberActivity = new MemberActivity();

            $memberActivity->member_id = $memberId;
            $memberActivity->activity_id = $activityId;

            if (!$memberActivity->save()) {
                return [
                    'success' => false,
                    'errors' => $memberActivity->getErrors(),
                ];
            }
        }

        return [
            'success' => true,
        ];
    }

    public function actionActivityLists($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $assignedIds = MemberActivity::find()
            ->select('activity_id')
            ->where(['member_id' => $id])
            ->column();

        $available = Activity::find()
            ->andFilterWhere(['not in', 'id', $assignedIds])
            ->orderBy('activity_name')
            ->all();

        $assigned = Activity::find()
            ->where(['id' => $assignedIds])
            ->orderBy('activity_name')
            ->all();

        return [
            'available' => \yii\helpers\ArrayHelper::map(
                $available,
                'id',
                'activity_name'
            ),
            'assigned' => \yii\helpers\ArrayHelper::map(
                $assigned,
                'id',
                'activity_name'
            ),
        ];
    }

    /**
     * Lists all Member models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Member model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Member #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                    Html::a(Yii::t('yii2-ajaxcrud', 'Update'), ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Member model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Member();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " Member",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Create'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " Member",
                    'content' => '<span class="text-success">' . Yii::t('yii2-ajaxcrud', 'Create') . ' Member ' . Yii::t('yii2-ajaxcrud', 'Success') . '</span>',
                    'footer' =>  Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::a(Yii::t('yii2-ajaxcrud', 'Create More'), ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " Member",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing Member model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;

        $member = $this->findModel($id);
        $model = $member->applicant;

        // Store old file paths
        $oldId = $model->document_verification_uplink_id;
        $oldSignature = $model->document_verification_uplink_signature;

        if ($request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($request->isGet) {

                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Update') . " Member #" . $member->id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                        'member' => $member,
                    ]),
                    'footer' =>
                    Html::button(Yii::t('yii2-ajaxcrud', 'Close'), [
                        'class' => 'btn btn-default pull-left',
                        'data-dismiss' => 'modal',
                    ]) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), [
                            'class' => 'btn btn-primary',
                            'type' => 'submit',
                        ]),
                ];
            }

            if ($model->load($request->post())) {

                // =========================
                // Government ID Upload
                // =========================

                $uploadId = UploadedFile::getInstance($model, 'document_verification_uplink_id');

                if ($uploadId) {

                    $idPath = Yii::getAlias('@app/data/uploads/ids');

                    if (!is_dir($idPath)) {
                        mkdir($idPath, 0775, true);
                    }

                    $idFilename = Yii::$app->security->generateRandomString(40)
                        . '.' . $uploadId->extension;

                    $uploadId->saveAs($idPath . '/' . $idFilename);

                    $model->document_verification_uplink_id = $idFilename;
                } else {

                    $model->document_verification_uplink_id = $oldId;
                }

                // =========================
                // Signature Upload
                // =========================

                $uploadSignature = UploadedFile::getInstance($model, 'document_verification_uplink_signature');

                if ($uploadSignature) {

                    $signaturePath = Yii::getAlias('@app/data/uploads/signatures');

                    if (!is_dir($signaturePath)) {
                        mkdir($signaturePath, 0775, true);
                    }

                    $signatureFilename = Yii::$app->security->generateRandomString(40)
                        . '.' . $uploadSignature->extension;

                    $uploadSignature->saveAs($signaturePath . '/' . $signatureFilename);

                    $model->document_verification_uplink_signature = $signatureFilename;
                } else {

                    $model->document_verification_uplink_signature = $oldSignature;
                }

                if ($model->save()) {

                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'title' => "Member #" . $member->id,
                        'content' => $this->renderAjax('view', [
                            'model' => $member,
                        ]),
                        'footer' =>
                        Html::button(Yii::t('yii2-ajaxcrud', 'Close'), [
                            'class' => 'btn btn-default pull-left',
                            'data-dismiss' => 'modal',
                        ]) .
                            Html::a(Yii::t('yii2-ajaxcrud', 'Update'), [
                                'update',
                                'id' => $member->id,
                            ], [
                                'class' => 'btn btn-primary',
                                'role' => 'modal-remote',
                            ]),
                    ];
                }
            }

            return [
                'title' => Yii::t('yii2-ajaxcrud', 'Update') . " Member #" . $member->id,
                'content' => $this->renderAjax('update', [
                    'model' => $model,
                    'member' => $member,
                ]),
                'footer' =>
                Html::button(Yii::t('yii2-ajaxcrud', 'Close'), [
                    'class' => 'btn btn-default pull-left',
                    'data-dismiss' => 'modal',
                ]) .
                    Html::button(Yii::t('yii2-ajaxcrud', 'Save'), [
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                    ]),
            ];
        } else {

            if ($model->load($request->post())) {

                // =========================
                // Government ID Upload
                // =========================

                $uploadId = UploadedFile::getInstance($model, 'document_verification_uplink_id');

                if ($uploadId) {

                    $idPath = Yii::getAlias('@app/data/uploads/ids');

                    if (!is_dir($idPath)) {
                        mkdir($idPath, 0775, true);
                    }

                    $idFilename = Yii::$app->security->generateRandomString(40)
                        . '.' . $uploadId->extension;

                    $uploadId->saveAs($idPath . '/' . $idFilename);

                    $model->document_verification_uplink_id = $idFilename;
                } else {

                    $model->document_verification_uplink_id = $oldId;
                }

                // =========================
                // Signature Upload
                // =========================

                $uploadSignature = UploadedFile::getInstance($model, 'document_verification_uplink_signature');

                if ($uploadSignature) {

                    $signaturePath = Yii::getAlias('@app/data/uploads/signatures');

                    if (!is_dir($signaturePath)) {
                        mkdir($signaturePath, 0775, true);
                    }

                    $signatureFilename = Yii::$app->security->generateRandomString(40)
                        . '.' . $uploadSignature->extension;

                    $uploadSignature->saveAs($signaturePath . '/' . $signatureFilename);

                    $model->document_verification_uplink_signature = $signatureFilename;
                } else {

                    $model->document_verification_uplink_signature = $oldSignature;
                }

                if ($model->save()) {
                    return $this->redirect([
                        'view',
                        'id' => $member->id,
                    ]);
                }
            }

            return $this->render('update', [
                'model' => $model,
                'member' => $member,
            ]);
        }
    }

    /**
     * Delete an existing Member model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing Member model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    public function actionActivate($id)
    {
        $model = $this->findModel($id);

        $model->status = Member::STATUS_ACTIVE;
        $model->save(false);

        return $this->redirect(['index']);
    }

    public function actionDeactivate($id)
    {
        $model = $this->findModel($id);

        $model->status = Member::STATUS_INACTIVE;
        $model->save(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
