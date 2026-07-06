<?php

/** @var yii\web\View $this */ ?>
<!-- ===================================================
     HERO SECTION
     =================================================== -->

<section id="hero" class="lp-hero d-flex align-items-center">

    <!-- Hero Background Image -->
    <div class="lp-hero-visual">
        <img
            src="<?= Yii::getAlias('@web/images/hero.webp') ?>"
            alt="One Movement Volunteers"
            class="lp-hero-image">
    </div>

    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-10" data-aos="fade-right">
                <span class="lp-hero-badge">
                    One Movement • Volunteer-Driven NGO
                </span>

                <h1 class="lp-hero-title mt-3">
                    Creating Change,
                    <span class="lp-text-gradient">One Community at a Time</span>
                </h1>

                <p class="lp-hero-subtitle mt-4">
                    We connect volunteers and communities through meaningful
                    socio-economic programs that improve lives, strengthen local
                    communities, and protect the environment for future generations.
                </p>

                <div class="lp-hero-actions mt-5">
                    <a href="#programs" class="btn lp-btn-primary lp-btn-lg me-3 mb-3">
                        Discover Our Programs
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="ms-2">
                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                        </svg>
                    </a>

                    <a href="#contact" class="btn lp-btn-outline-hero lp-btn-lg mb-3">
                        Join the Movement
                    </a>
                </div>
                <div class="lp-hero-stats mt-4">
                    <div class="lp-stat-item">
                        <span class="lp-stat-number" data-count="12345">0</span><span class="lp-stat-number">+</span>
                        <span class="lp-stat-label">Volunteers</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>