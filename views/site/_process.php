<?php

/** @var yii\web\View $this */ ?>
<!-- ===================================================
     PROCESS SECTION
     =================================================== -->
<section id="process" class="lp-section lp-section-dark">
    <div class="container">
        <div class="row justify-content-center text-center mb-5" data-aos="fade-up">
            <div class="col-lg-7">
                <span class="lp-section-badge lp-badge-light">Join One Movement</span>
                <h2 class="lp-section-title lp-title-light mt-2">Become a Volunteer in <span class="lp-text-gradient">3 Simple Steps</span></h2>
                <p class="lp-section-subtitle lp-subtitle-light">
                    Joining One Movement is easy. Submit your application, wait for approval,
                    and become part of a community dedicated to service and nation-building.
                </p>
            </div>
        </div>
        <div class="lp-process-timeline">
            <?php
            $steps = [
                [
                    'num'   => '01',
                    'title' => 'Submit Your Application',
                    'desc'  => 'Complete the membership application form and provide the required personal information.',
                ],
                [
                    'num'   => '02',
                    'title' => 'Application Review',
                    'desc'  => 'Our team will review your application and verify the information before approval.',
                ],
                [
                    'num'   => '03',
                    'title' => 'Become a Member',
                    'desc'  => 'Once approved, you will officially become a One Movement member and receive updates on programs and volunteer activities.',
                ],
            ];
            foreach ($steps as $i => $step):
            ?>
                <div class="lp-process-step text-center" data-aos="fade-up" data-aos-delay="<?= $i * 120 ?>">
                    <div class="lp-ps-num"><?= $step['num'] ?></div>
                    <?php if ($i < count($steps) - 1): ?>
                        <div class="lp-ps-connector"></div>
                    <?php endif; ?>
                    <div class="lp-ps-card">
                        <h5 class="lp-ps-title"><?= $step['title'] ?></h5>
                        <p class="lp-ps-desc"><?= $step['desc'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>