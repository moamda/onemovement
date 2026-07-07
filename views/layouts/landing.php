<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\LandingAsset;
use yii\bootstrap5\Html;

LandingAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? 'Affordable, professional websites for local businesses in the Philippines.']);
$this->registerMetaTag(['name' => 'keywords',    'content' => $this->params['meta_keywords']    ?? 'website, local business, water refilling, laundry, affordable website Philippines']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <!-- ===================== STICKY NAVBAR ===================== -->
    <nav id="landingNav" class="navbar navbar-expand-lg lp-navbar fixed-top">
        <div class="container">
            <a class="navbar-brand lp-brand" href="#hero">
                <img src="images/loge.png" alt="ONE Movement Inc." class="lp-logo">

                <span>
                    ONE <span class="lp-brand-accent">Movement Inc.</span>
                </span>
            </a>

            <button class="navbar-toggler lp-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="lp-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link lp-nav-link" href="#programs">Programs</a></li>
                    <li class="nav-item"><a class="nav-link lp-nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link lp-nav-link" href="#why-us">Why Us</a></li>
                    <li class="nav-item"><a class="nav-link lp-nav-link" href="#process">How It Works</a></li>
                    <li class="nav-item"><a class="nav-link lp-nav-link" href="#testimonials">Reviews</a></li>
                    <li class="nav-item"><a class="nav-link lp-nav-link" href="#faq">FAQ</a></li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <?= \yii\helpers\Html::a(
                            'Join The Movement',
                            ['site/applicant-form'],
                            [
                                'class' => 'btn lp-btn-primary px-4',
                                'target' => '_blank',
                            ]
                        ) ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ===================== PAGE CONTENT ===================== -->
    <?= $content ?>

    <!-- ===================== FOOTER ===================== -->
    <footer id="footer" class="lp-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="lp-footer-brand mb-3">
                        One <span class="lp-brand-accent">Movement Inc.</span>
                    </div>

                    <p class="lp-footer-tagline">
                        A volunteer-driven non-governmental organization committed to empowering
                        communities through socio-economic programs, environmental stewardship,
                        and active citizen participation.
                    </p>
                    <div class="lp-social-links mt-3">
                        <a href="#" class="lp-social-link" aria-label="Facebook">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="lp-social-link" aria-label="Messenger">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.373 0 0 4.974 0 11.111c0 3.498 1.744 6.614 4.469 8.652V24l4.088-2.242c1.092.3 2.246.464 3.443.464 6.627 0 12-4.975 12-11.111S18.627 0 12 0zm1.191 14.963l-3.055-3.26-5.963 3.26L10.732 8l3.131 3.259L19.752 8l-6.561 6.963z" />
                            </svg>
                        </a>
                        <a href="#" class="lp-social-link" aria-label="Instagram">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                            </svg>
                        </a>
                        <a href="#" class="lp-social-link" aria-label="TikTok">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.34 6.34 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.17 8.17 0 004.77 1.52V6.76a4.85 4.85 0 01-1-.07z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-6 mb-4">
                    <h6 class="lp-footer-heading">Navigate</h6>

                    <ul class="lp-footer-nav">
                        <li><a href="#hero">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#programs">Programs</a></li>
                        <li><a href="#why-us">Why Join Us</a></li>
                        <li><a href="#contact">Membership</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 col-6 mb-4">
                    <h6 class="lp-footer-heading">Programs</h6>

                    <ul class="lp-footer-nav">
                        <li><a href="#programs">Environmental Protection</a></li>
                        <li><a href="#programs">Community Development</a></li>
                        <li><a href="#programs">Livelihood Support</a></li>
                        <li><a href="#programs">Leadership Development</a></li>
                        <li><a href="#programs">Volunteer Activities</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <h6 class="lp-footer-heading">Contact Us</h6>
                    <ul class="lp-footer-contact">
                        <li>
                            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                            </svg>
                            info@onemovement.org
                        </li>
                        <li>
                            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
                            </svg>
                            +63 XXX XXX XXXX
                        </li>
                        <li>
                            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                            </svg>
                            Philippines
                        </li>

                    </ul>
                </div>
            </div>
            <hr class="lp-footer-divider mt-2">
            <div class="row align-items-center py-3">
                <div class="col-md-6 text-center text-md-left lp-footer-copy">
                    &copy; <?= date('Y') ?> One Movement. All Rights Reserved.
                </div>

                <div class="col-md-6 text-center text-md-right lp-footer-copy">
                    Together in Service. Together for the Nation.
                </div>
            </div>
        </div>
    </footer>

    <!-- ===================== FLOATING CONTACT BUTTON ===================== -->
    <a href="#contact" class="lp-float-btn" title="Get a Website" aria-label="Get a Website">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z" />
        </svg>
    </a>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>