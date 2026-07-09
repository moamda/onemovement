<?php

namespace app\controllers;

use app\models\Alliance;
use app\models\Applicant;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\LeadForm;
use app\models\PasswordResetRequestForm;
use app\models\SignupForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{

    const FLASH_SUCCESS = 'success';
    const FLASH_ERROR = 'error';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'landing';
        $model = new Applicant();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $adminEmail = Yii::$app->params['adminEmail'] ?? 'admin@1okay.com';
                $model->sendLead($adminEmail);
                Yii::$app->session->setFlash('leadSubmitted');
                return $this->refresh();
            }
        }
        return $this->render('index', ['model' => $model]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = '/blank';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->can('access admin module')) {
                return $this->redirect(['/admin/dashboard/v1']);
            } elseif (Yii::$app->user->can('access admin module')) {
                return $this->redirect(['/admin/dashboard/v1']);
            } else {
                return $this->goHome();
            }
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
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRequestPasswordReset()
    {
        $this->layout = '/blank';

        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Kindly wait for the administrator to reset your password.');
                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            return $this->goHome();
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }



    public function actionApplicantForm()
    {
        $this->layout = 'landing';

        $model = new Applicant();

        $model->scenario = 'applicant-form';

        if ($model->load(Yii::$app->request->post())) {

            // Uploads
            $uploadId = UploadedFile::getInstance($model, 'document_verification_uplink_id');
            $uploadSignature = UploadedFile::getInstance($model, 'document_verification_uplink_signature');

            // Assign muna para sa validation
            $model->document_verification_uplink_id = $uploadId;
            $model->document_verification_uplink_signature = $uploadSignature;

            if ($model->validate()) {

                /* ================= ID ================= */

                if ($uploadId !== null) {

                    $idPath = Yii::getAlias('@webroot/uploads/ids');

                    if (!is_dir($idPath)) {
                        mkdir($idPath, 0775, true);
                    }

                    $idFilename = Yii::$app->security->generateRandomString(40)
                        . '.' . $uploadId->extension;

                    $uploadId->saveAs($idPath . '/' . $idFilename);

                    $model->document_verification_uplink_id = 'uploads/ids/' . $idFilename;
                }

                /* ================= Signature ================= */

                if ($uploadSignature !== null) {

                    $signaturePath = Yii::getAlias('@webroot/uploads/signatures');

                    if (!is_dir($signaturePath)) {
                        mkdir($signaturePath, 0775, true);
                    }

                    $signatureFilename = Yii::$app->security->generateRandomString(40)
                        . '.' . $uploadSignature->extension;

                    $uploadSignature->saveAs($signaturePath . '/' . $signatureFilename);

                    $model->document_verification_uplink_signature = 'uploads/signatures/' . $signatureFilename;
                }

                if ($model->save(false)) {

                    Yii::$app->session->setFlash(
                        'success',
                        'Application submitted successfully.'
                    );

                    return $this->refresh();
                }
            } else {

                echo '<pre>';
                print_r($model->getErrors());
                die;
            }
        }

        return $this->render('applicant-form', [
            'model' => $model,
        ]);
    }
}
