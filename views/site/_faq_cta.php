<?php

/** @var yii\web\View $this */ ?>
<!-- ===================================================
     FAQ SECTION
     =================================================== -->
<section id="faq" class="lp-section lp-section-light">
    <div class="container">
        <div class="row justify-content-center text-center mb-5" data-aos="fade-up">
            <div class="col-lg-7">
                <span class="lp-section-badge">Frequently Asked Questions</span>
                <h2 class="lp-section-title mt-2">
                    Membership <span class="lp-text-gradient">FAQs</span>
                </h2>
                <p class="lp-section-subtitle">
                    Find answers to the most frequently asked questions about
                    membership, applications, and volunteering with One Movement.
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <?php
                $faqs = [

                    [
                        'q' => 'Who can join One Movement?',
                        'a' => 'Any Filipino who shares the organization\'s mission, values, and commitment to community service may apply for membership.',
                    ],

                    [
                        'q' => 'How do I become a member?',
                        'a' => 'Simply complete the online Membership Application Form. Once submitted, your application will be reviewed by our team. Approved applicants will be notified and officially welcomed as members.',
                    ],

                    [
                        'q' => 'Is there a membership fee?',
                        'a' => 'Membership requirements and applicable fees, if any, will be communicated during the application and approval process.',
                    ],

                    [
                        'q' => 'Can I volunteer even if I am not yet a member?',
                        'a' => 'Some volunteer activities may be open to non-members, while others require active membership. Please contact us for more information about upcoming activities.',
                    ],

                    [
                        'q' => 'How long does the application review take?',
                        'a' => 'Application review times may vary depending on the volume of applications. Applicants will be contacted once the evaluation has been completed.',
                    ],

                    [
                        'q' => 'How will I know if my application has been approved?',
                        'a' => 'Our team will contact you using the contact information you provided in your application to inform you of the result and the next steps.',
                    ],

                ];
                ?>
                <div id="faqAccordion">
                    <?php foreach ($faqs as $i => $faq): ?>
                        <div class="lp-acc-item mb-2">
                            <div class="lp-acc-header" id="faqHead<?= $i ?>">
                                <button class="lp-acc-btn <?= $i !== 0 ? 'collapsed' : '' ?>"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqCollapse<?= $i ?>"
                                    aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>"
                                    aria-controls="faqCollapse<?= $i ?>">
                                    <?= htmlspecialchars($faq['q']) ?>
                                    <span class="lp-acc-icon">
                                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M7 10l5 5 5-5z" />
                                        </svg>
                                    </span>
                                </button>
                            </div>
                            <div id="faqCollapse<?= $i ?>"
                                class="collapse <?= $i === 0 ? 'show' : '' ?>"
                                aria-labelledby="faqHead<?= $i ?>"
                                data-bs-parent="#faqAccordion">
                                <div class="lp-acc-body">
                                    <?= htmlspecialchars($faq['a']) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>