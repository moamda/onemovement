<?php

/** @var yii\web\View $this */

$programs = [
    [
        'image' => 'images/p1.webp',
        'title' => 'Food Security',
        'desc'  => 'Implemented urban gardening projects covering approximately 1.5 hectares in Culabasa, Bamban, Tarlac, planting lemongrass, chili, eggplant, tomato, camote kahoy, and peanuts, with crops harvested for community consumption.',
    ],
    [
        'image' => 'images/p2.webp',
        'title' => 'Disaster Response and Relief Operations',
        'desc'  => 'The Disaster Response program is designed to provide timely and organized humanitarian assistance during emergencies and natural disasters, ensuring relief reaches affected communities efficiently.',
    ],
    [
        'image' => 'images/p3.webp',
        'title' => 'Skills & Livelihood',
        'desc'  => 'Conducted livelihood trainings, including urban gardening, handicrafts, and small enterprise management.',
    ],
    [
        'image' => 'images/p1.webp',
        'title' => 'Community Watch',
        'desc'  => 'The Community Watch program is designed to enhance local safety, security, and early warning systems, enabling communities to respond proactively to incidents and emergencies.',
    ],
    [
        'image' => 'images/p2.webp',
        'title' => 'Moral Recovery & Enhancement',
        'desc'  => 'Delivered recollections, values formation and team building modules to volunteers and partner communities.',
    ],
    [
        'image' => 'images/p3.webp',
        'title' => 'Environmental Protection	',
        'desc'  => 'Organized four waves of tree planting at Sitio San Ysiro, Purok Canumay, Brgy. San Jose, Antipolo City.',
    ],
];
?>

<!-- ===================================================
     PROGRAMS SECTION
=================================================== -->
<section id="programs" class="lp-section lp-section-light">

    <div class="container">

        <div class="row justify-content-center text-center mb-5" data-aos="fade-up">

            <div class="col-lg-8">

                <span class="lp-section-badge">
                    Our Programs
                </span>

                <h2 class="lp-section-title mt-2">
                    Creating Lasting Impact Through
                    <span class="lp-text-gradient">
                        Community Development
                    </span>
                </h2>

                <p class="lp-section-subtitle">
                    One Movement empowers communities through socio-economic programs that promote
                    volunteerism, environmental stewardship, leadership, and sustainable development.
                </p>

            </div>

        </div>

        <div class="row">

            <?php foreach ($programs as $i => $program): ?>

                <div class="col-lg-4 col-md-6 mb-4"
                    data-aos="fade-up"
                    data-aos-delay="<?= $i * 80 ?>">

                    <div class="card border-0 shadow-sm h-100 overflow-hidden">

                        <img
                            src="<?= Yii::getAlias('@web/' . $program['image']) ?>"
                            class="card-img-top"
                            style="height:240px; object-fit:cover;"
                            alt="<?= $program['title'] ?>">

                        <div class="card-body d-flex flex-column">

                            <h4 class="mb-3">
                                <?= $program['title'] ?>
                            </h4>

                            <p class="text-muted flex-grow-1">
                                <?= $program['desc'] ?>
                            </p>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

        <div class="row mt-5">

            <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">

                <h4 class="mb-3">
                    Become Part of the Movement
                </h4>

                <p class="text-muted">
                    Together with volunteers, communities, and partner organizations,
                    we continue building a stronger, more sustainable, and empowered Philippines.
                </p>

                <a href="#contact" class="btn lp-btn-primary lp-btn-lg mt-3">

                    Join as a Volunteer

                </a>

            </div>

        </div>

    </div>

</section>