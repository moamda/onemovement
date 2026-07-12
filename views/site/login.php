<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="login-logo text-center mb-4">
                <a href="#"><b>ONE MOVEMENT </b>Inc.</a>
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

                    <?= $form->field($model, 'username', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>',
                        'template' => '{beginWrapper}{input}{error}{endWrapper}',
                        'wrapperOptions' => ['class' => 'input-group mb-3']
                    ])
                        ->label(false)
                        ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

                    <?= $form->field($model, 'password', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
                        'template' => '{beginWrapper}{input}{error}{endWrapper}',
                        'wrapperOptions' => ['class' => 'input-group mb-3']
                    ])
                        ->label(false)
                        ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

                    <!-- <div class="form-group">
                        <= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n{error}"
                        ]) ?>
                    </div> -->

                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                    </div>

                    <!-- <p class="mb-1 text-right">
                        <= Html::a('Forgot Password?', ['site/request-password-reset']) ?>
                    </p> -->

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>