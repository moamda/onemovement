<?php

/** @var yii\web\View $this */ ?>
<!-- ===================================================
     WHY ONE MOVEMENT SECTION
     =================================================== -->
<section id="why-us" class="lp-section lp-section-light">
    <div class="container">

        <div class="row justify-content-center text-center mb-5" data-aos="fade-up">
            <div class="col-lg-7">
                <span class="lp-section-badge">Why One Movement</span>

                <h2 class="lp-section-title mt-2">
                    Building Stronger Communities
                    <span class="lp-text-gradient">Through Unity & Service</span>
                </h2>

                <p class="lp-section-subtitle">
                    One Movement believes that meaningful change begins when
                    individuals, communities, and organizations work together
                    toward a shared purpose of nation-building and sustainable development.
                </p>
            </div>
        </div>

        <div class="row align-items-center">

            <!-- LEFT -->
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">

                <?php
                $features = [

                    [
                        'title' => 'Volunteer-Driven Leadership',
                        'desc'  => 'Dedicated volunteers lead initiatives that inspire service, collaboration, and positive community impact.',
                        'icon'  => '<path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/>',
                    ],

                    [
                        'title' => 'Community Empowerment',
                        'desc'  => 'Programs are designed to strengthen communities through participation, education, and sustainable opportunities.',
                        'icon'  => '<path d="M12 2L2 7v2c0 5.5 3.8 10.7 10 13 6.2-2.3 10-7.5 10-13V7l-10-5z"/>',
                    ],

                    [
                        'title' => 'Environmental Responsibility',
                        'desc'  => 'Promoting environmental protection through community engagement and responsible stewardship.',
                        'icon'  => '<path d="M12 2C8 6 6 9.5 6 13a6 6 0 0012 0c0-3.5-2-7-6-11z"/>',
                    ],

                    [
                        'title' => 'Partnership for Nation-Building',
                        'desc'  => 'Working alongside government agencies, civic organizations, and local communities to create lasting impact.',
                        'icon'  => '<path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V20h14v-3.5C15 14.17 10.33 13 8 13zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.95 1.97 3.45V20h6v-3.5c0-2.33-4.67-3.5-7-3.5z"/>',
                    ],
                ];

                foreach ($features as $i => $f):
                ?>

                    <div class="lp-feature-item d-flex mb-4"
                        data-aos="fade-up"
                        data-aos-delay="<?= $i * 80 ?>">

                        <div class="lp-feature-icon flex-shrink-0 me-3">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <?= $f['icon'] ?>
                            </svg>
                        </div>

                        <div>
                            <h5 class="lp-feature-title"><?= $f['title'] ?></h5>
                            <p class="lp-feature-desc"><?= $f['desc'] ?></p>
                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-6"
                data-aos="fade-left"
                data-aos-delay="100">

                <div class="lp-trust-panel">

                    <div class="lp-trust-panel-header">
                        <h4>Our Commitment</h4>
                        <p>
                            Every initiative we undertake is guided by values that
                            promote responsible leadership, unity, and meaningful public service.
                        </p>
                    </div>

                    <ul class="lp-includes-list mt-4">

                        <?php

                        $includes = [

                            'Integrity and accountability in every action',

                            'Respect, equality, and compassion for all',

                            'Volunteerism and active civic participation',

                            'Unity through collaboration and shared purpose',

                            'Environmental protection and sustainability',

                            'Community-centered socio-economic development',

                            'Transparent and responsible partnerships',

                            'Commitment to nation-building',

                        ];

                        foreach ($includes as $item):
                        ?>

                            <li>
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z" />
                                </svg>

                                <?= $item ?>

                            </li>

                        <?php endforeach; ?>

                    </ul>

                    <div class="lp-award-badges mt-4">

                        <span class="lp-award-badge">
                            🌱 Environmental Protection
                        </span>

                        <span class="lp-award-badge">
                            🤝 Volunteerism
                        </span>

                        <span class="lp-award-badge">
                            🇵🇭 Nation-Building
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>
</section>