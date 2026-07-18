<?php

namespace app\controllers;

use yii\filters\AccessControl;
use Yii;
use app\models\Applicant;
use app\models\ApplicantSearch;
use app\models\Member;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;
use app\components\UploadService;
use app\models\Alliance;
use app\models\Beneficiary;
use app\models\GroupOrganic;
use app\models\GroupSectorial;
use Yii2\Extensions\DynamicForm\Models\Model;

/**
 * ApplicantController implements the CRUD actions for Applicant model.
 */
class ApplicantController extends Controller
{
    public $layout = 'adminlte';


    /**
     * @inheritdoc
     */
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['post'],
    //                 'bulkdelete' => ['post'],
    //             ],
    //         ],
    //     ];
    // }

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

    /**
     * Lists all Applicant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApplicantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Applicant model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Applicant #" . $id,
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
     * Creates a new Applicant model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Applicant();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " Applicant",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Create'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " Applicant",
                    'content' => '<span class="text-success">' . Yii::t('yii2-ajaxcrud', 'Create') . ' Applicant ' . Yii::t('yii2-ajaxcrud', 'Success') . '</span>',
                    'footer' =>  Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::a(Yii::t('yii2-ajaxcrud', 'Create More'), ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " Applicant",
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
     * Updates an existing Applicant model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        $modelBeneficiaries = $model->beneficiaries;

        if (empty($modelBeneficiaries)) {
            $modelBeneficiaries = [new Beneficiary()];
        }

        $transaction = Yii::$app->db->beginTransaction();

        $oldId = $model->document_verification_uplink_id;
        $oldSignature = $model->document_verification_uplink_signature;

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($request->isGet) {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Update') . " Applicant #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                        'modelBeneficiaries' => $modelBeneficiaries,
                    ]),
                    'footer' =>
                    Html::button(Yii::t('yii2-ajaxcrud', 'Close'), [
                        'class' => 'btn btn-default pull-left',
                        'data-dismiss' => 'modal'
                    ]) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), [
                            'class' => 'btn btn-primary',
                            'type' => 'submit'
                        ])
                ];
            }
        }

        // =====================================================
        // ONE upload/save logic only
        // =====================================================

        if ($model->load($request->post())) {
            // =====================================================
            // Dynamic Beneficiaries
            // =====================================================

            // Existing beneficiary IDs
            $oldIDs = array_column($modelBeneficiaries, 'id');

            // Create models from submitted data
            $modelBeneficiaries = Model::createMultiple(
                Beneficiary::class,
                $modelBeneficiaries
            );

            foreach ($modelBeneficiaries as $beneficiary) {
                $beneficiary->scenario = 'applicant-form';
            }

            // Load submitted beneficiary data
            Model::loadMultiple($modelBeneficiaries, $request->post());

            // Determine deleted beneficiaries
            $deletedIDs = array_diff(
                $oldIDs,
                array_filter(array_column($modelBeneficiaries, 'id'))
            );

            try {
                // Picture ID

                $uploadId = UploadedFile::getInstance($model, 'document_verification_uplink_id');

                $newId = null;

                if ($uploadId) {

                    $newId = UploadService::upload(
                        $uploadId,
                        'ids'
                    );

                    $model->document_verification_uplink_id = $newId;
                } else {

                    $model->document_verification_uplink_id = $oldId;
                }

                // Signature

                $uploadSignature = UploadedFile::getInstance($model, 'document_verification_uplink_signature');

                $newSignature = null;

                if ($uploadSignature) {

                    $newSignature = UploadService::upload(
                        $uploadSignature,
                        'signatures'
                    );

                    $model->document_verification_uplink_signature = $newSignature;
                } else {

                    $model->document_verification_uplink_signature = $oldSignature;
                }


                if ($model->save()) {
                    // =====================================================
                    // Save Beneficiaries
                    // =====================================================

                    // Delete removed beneficiaries
                    if (!empty($deletedIDs)) {
                        Beneficiary::deleteAll([
                            'id' => $deletedIDs
                        ]);
                    }

                    // Insert / Update beneficiaries
                    foreach ($modelBeneficiaries as $beneficiary) {

                        $beneficiary->applicant_id = $model->id;

                        if (!$beneficiary->save(false)) {
                            throw new \Exception('Unable to save beneficiary.');
                        }
                    }
                    $transaction->commit();

                    // Delete old Picture ID
                    if ($newId && $oldId) {
                        UploadService::delete(
                            'ids',
                            $oldId
                        );
                    }

                    // Delete old Signature
                    if ($newSignature && $oldSignature) {
                        UploadService::delete(
                            'signatures',
                            $oldSignature
                        );
                    }

                    if ($request->isAjax) {

                        return [
                            'forceReload' => '#crud-datatable-pjax',
                            'title' => "Applicant #" . $id,
                            'content' => $this->renderAjax('view', [
                                'model' => $model,
                            ]),
                            'footer' =>
                            Html::button(Yii::t('yii2-ajaxcrud', 'Close'), [
                                'class' => 'btn btn-default pull-left',
                                'data-dismiss' => 'modal'
                            ]) .
                                Html::a(Yii::t('yii2-ajaxcrud', 'Update'), [
                                    'update',
                                    'id' => $id
                                ], [
                                    'class' => 'btn btn-primary',
                                    'role' => 'modal-remote'
                                ])
                        ];
                    }

                    return $this->redirect([
                        'view',
                        'id' => $model->id,
                    ]);
                }

                $transaction->rollBack();

                // Cleanup newly uploaded files
                if ($newId) {
                    UploadService::delete('ids', $newId);
                }

                if ($newSignature) {
                    UploadService::delete('signatures', $newSignature);
                }
            } catch (\Throwable $e) {
                if ($transaction->isActive) {
                    $transaction->rollBack();
                }

                // Delete newly uploaded files
                if (!empty($newId)) {
                    UploadService::delete('ids', $newId);
                }

                if (!empty($newSignature)) {
                    UploadService::delete('signatures', $newSignature);
                }

                throw $e;
            }
        }

        // =====================================================
        // Render form
        // =====================================================

        if ($request->isAjax) {

            return [
                'title' => Yii::t('yii2-ajaxcrud', 'Update') . " Applicant #" . $id,
                'content' => $this->renderAjax('update', [
                    'model' => $model,
                    'modelBeneficiaries' => $modelBeneficiaries,
                ]),
                'footer' =>
                Html::button(Yii::t('yii2-ajaxcrud', 'Close'), [
                    'class' => 'btn btn-default pull-left',
                    'data-dismiss' => 'modal'
                ]) .
                    Html::button(Yii::t('yii2-ajaxcrud', 'Save'), [
                        'class' => 'btn btn-primary',
                        'type' => 'submit'
                    ])
            ];
        }

        return $this->render('update', [
            'model' => $model,
            'modelBeneficiaries' => $modelBeneficiaries,
        ]);
    }

    /**
     * Delete an existing Applicant model.
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
     * Delete multiple existing Applicant model.
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

    public function actionApprove($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        // Already approved
        if ($model->status === Applicant::STATUS_APPROVED) {

            if ($request->isAjax) {

                Yii::$app->response->format = Response::FORMAT_JSON;

                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => 'Already Approved',
                    'content' => '<span class="text-warning">This application has already been approved.</span>',
                    'footer' => Html::button(
                        Yii::t('yii2-ajaxcrud', 'Close'),
                        [
                            'class' => 'btn btn-default pull-left',
                            'data-dismiss' => 'modal',
                        ]
                    ),
                ];
            }

            Yii::$app->session->setFlash('warning', 'This application has already been approved.');

            return $this->redirect(['index']);
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {

            // Update applicant status
            $model->status = Applicant::STATUS_APPROVED;

            if (!$model->save(false)) {
                throw new \Exception('Unable to approve applicant.');
            }

            // Check if applicant already exists in Member table
            $member = Member::find()
                ->where([
                    'applicant_id' => $model->id,
                ])
                ->one();

            if ($member === null) {

                $member = new Member();
                $member->applicant_id = $model->id;
                $member->alliance_id = $model->volunteer_details_group_name;

                if (!$member->save()) {

                    $errors = [];

                    foreach ($member->getErrors() as $attributeErrors) {
                        $errors[] = implode(', ', $attributeErrors);
                    }

                    throw new \Exception(implode('<br>', $errors));
                }
            }

            $transaction->commit();

            if ($request->isAjax) {

                Yii::$app->response->format = Response::FORMAT_JSON;

                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => 'Application Approved',
                    'content' => '<span class="text-success">The application has been approved successfully.</span>',
                    'footer' => Html::button(
                        Yii::t('yii2-ajaxcrud', 'Close'),
                        [
                            'class' => 'btn btn-default pull-left',
                            'data-dismiss' => 'modal',
                        ]
                    ),
                ];
            }

            Yii::$app->session->setFlash('success', 'Application approved successfully.');

            return $this->redirect(['index']);
        } catch (\Throwable $e) {

            $transaction->rollBack();

            if ($request->isAjax) {

                Yii::$app->response->format = Response::FORMAT_JSON;

                return [
                    'title' => 'Error',
                    'content' => '<div class="alert alert-danger">' . $e->getMessage() . '</div>',
                    'footer' => Html::button(
                        Yii::t('yii2-ajaxcrud', 'Close'),
                        [
                            'class' => 'btn btn-default pull-left',
                            'data-dismiss' => 'modal',
                        ]
                    ),
                ];
            }

            Yii::$app->session->setFlash('error', $e->getMessage());

            return $this->redirect(['index']);
        }
    }

    public function actionReject($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $model->status = Applicant::STATUS_REJECTED;
            $model->save(false);

            return [
                'forceReload' => '#crud-datatable-pjax',
                'title' => 'Application Rejected',
                'content' => '<span class="text-danger">The application has been rejected.</span>',
                'footer' =>
                \yii\helpers\Html::button(
                    Yii::t('yii2-ajaxcrud', 'Close'),
                    [
                        'class' => 'btn btn-default pull-left',
                        'data-dismiss' => 'modal'
                    ]
                ),
            ];
        }

        $model->status = Applicant::STATUS_REJECTED;
        $model->save(false);

        Yii::$app->session->setFlash('success', 'Application rejected successfully.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Applicant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Applicant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Applicant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Returns the absolute path of a stored upload.
     */
    private function getUploadPath(string $folder, string $filename): string
    {
        return Yii::getAlias("@app/data/uploads/{$folder}/{$filename}");
    }

    /**
     * Streams a stored file to the browser.
     */
    private function sendStoredFile(string $folder, ?string $filename)
    {
        if (empty($filename)) {
            throw new \yii\web\NotFoundHttpException('File not found.');
        }

        $path = $this->getUploadPath($folder, $filename);

        if (!is_file($path)) {
            throw new \yii\web\NotFoundHttpException('File not found.');
        }

        Yii::$app->response->headers->set(
            'Content-Type',
            mime_content_type($path)
        );

        Yii::$app->response->headers->set(
            'Content-Disposition',
            'inline; filename="' . basename($path) . '"'
        );

        return Yii::$app->response->sendFile($path);
    }

    public function actionViewId($id)
    {
        $model = Applicant::findOne($id);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException();
        }

        /*
     * Dito tayo maglalagay mamaya ng RBAC.
     */

        return $this->sendStoredFile(
            'ids',
            $model->document_verification_uplink_id
        );
    }

    public function actionViewSignature($id)
    {
        $model = Applicant::findOne($id);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException();
        }

        return $this->sendStoredFile(
            'signatures',
            $model->document_verification_uplink_signature
        );
    }

    public function actionGroupList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $output = [];

        if (isset($_POST['depdrop_parents'])) {

            $registrationType = $_POST['depdrop_parents'][0];

            // Convert enum value to its label
            $registrationTypes = Applicant::optsVolunteerDetailsRegistrationType();
            $registrationLabel = $registrationTypes[$registrationType] ?? '';

            switch ($registrationLabel) {

                case Applicant::VOLUNTEER_DETAILS_REGISTRATION_TYPE_ALLIANCE:

                    $items = Alliance::find()
                        ->where(['status' => Alliance::STATUS_ACTIVE])
                        ->orderBy(['organization' => SORT_ASC])
                        ->all();

                    foreach ($items as $item) {
                        $output[] = [
                            'id' => $item->id,
                            'name' => $item->organization,
                        ];
                    }

                    break;

                case Applicant::VOLUNTEER_DETAILS_REGISTRATION_TYPE_SECTORIAL:

                    $items = GroupSectorial::find()
                        ->where(['status' => GroupSectorial::STATUS_ACTIVE])
                        ->orderBy(['group_name' => SORT_ASC])
                        ->all();

                    foreach ($items as $item) {
                        $output[] = [
                            'id' => $item->id,
                            'name' => $item->group_name,
                        ];
                    }

                    break;

                case Applicant::VOLUNTEER_DETAILS_REGISTRATION_TYPE_ONEMOVEMENT_ORGANIC:

                    $items = GroupOrganic::find()
                        ->where(['status' => GroupOrganic::STATUS_ACTIVE])
                        ->orderBy(['group_name' => SORT_ASC])
                        ->all();

                    foreach ($items as $item) {
                        $output[] = [
                            'id' => $item->id,
                            'name' => $item->group_name,
                        ];
                    }

                    break;
            }

            return [
                'output' => $output,
                'selected' => '',
            ];
        }

        return [
            'output' => [],
            'selected' => '',
        ];
    }
}
