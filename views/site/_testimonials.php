<?php

/** @var yii\web\View $this */ ?>

<!-- ===================================================
     VOICES OF SERVICE
     =================================================== -->
<section id="testimonials" class="lp-section lp-section-light">
    <div class="container">

        <div class="row justify-content-center text-center mb-5" data-aos="fade-up">
            <div class="col-lg-7">
                <span class="lp-section-badge">Voices of Service</span>

                <h2 class="lp-section-title mt-2">
                    Together, We Make a
                    <span class="lp-text-gradient">Difference</span>
                </h2>

                <p class="lp-section-subtitle">
                    One Movement is built on the shared commitment of volunteers,
                    partners, and communities working together for a better future.
                </p>
            </div>
        </div>

        <div class="row">

            <?php

            $testimonials = [

                [
                    'name'    => 'Community Volunteer',
                    'role'    => 'One Movement Member',
                    'content' => 'Serving others has given me the opportunity to grow while making a positive impact in my community.',
                    'avatar'  => 'CV',
                    'emoji'   => '🤝',
                ],

                [
                    'name'    => 'Youth Volunteer',
                    'role'    => 'Environmental Program',
                    'content' => 'Every activity reminds us that even small actions can create meaningful change when we work together.',
                    'avatar'  => 'YV',
                    'emoji'   => '🌱',
                ],

                [
                    'name'    => 'Community Partner',
                    'role'    => 'Local Organization',
                    'content' => 'Partnership and volunteerism have strengthened our community and inspired more people to serve.',
                    'avatar'  => 'CP',
                    'emoji'   => '🇵🇭',
                ],

            ];

            foreach ($testimonials as $i => $t):
            ?>

                <div class="col-lg-4 col-md-6 mb-4"
                    data-aos="fade-up"
                    data-aos-delay="<?= $i * 100 ?>">

                    <div class="lp-testimonial-card h-100">

                        <div class="lp-tcard-biz-emoji">
                            <?= $t['emoji'] ?>
                        </div>

                        <p class="lp-tcard-content">
                            &ldquo;<?= $t['content'] ?>&rdquo;
                        </p>

                        <div class="lp-tcard-author d-flex align-items-center mt-auto">

                            <div class="lp-tcard-avatar me-3">
                                <?= $t['avatar'] ?>
                            </div>

                            <div>
                                <div class="lp-tcard-name">
                                    <?= $t['name'] ?>
                                </div>

                                <div class="lp-tcard-role">
                                    <?= $t['role'] ?>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>
</section>