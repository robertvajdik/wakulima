<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = t('nav.about');
$pageDescription = t('meta.about.description');
$pageKeywords    = t('meta.about.keywords');
$members = $pdo->query("SELECT * FROM members WHERE is_active = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
$hasLightbox = (bool)array_filter($members, fn($m) => !empty($m['photo']));
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
  <div class="container">
    <span class="eyebrow"><?php echo e(t('section.who_we_are')); ?></span>
    <h1><?php echo e(setting('site_name')); ?></h1>
    <p class="lead"><?php echo e(setting('site_tagline')); ?></p>
  </div>
</section>

<section>
  <div class="container two-col">
    <div>
      <span class="eyebrow"><?php echo e(t('section.who_we_are')); ?></span>
      <h2><?php echo current_lang() === 'sw' ? 'Tumeundwa na wakulima, kwa wakulima.' : 'Built by farmers, for farmers.'; ?></h2>
      <p><?php echo e(setting('about_text')); ?></p>
      <p><?php echo current_lang() === 'sw'
          ? 'Tunawakusanya wakulima ili wabadilishane maarifa, wapate fursa, waimarishe akiba na mikopo, waboreshe uzalishaji wa kilimo, na wajenge maisha imara zaidi.'
          : 'We bring farmers together to share knowledge, access opportunities, strengthen savings and lending practices, improve agricultural productivity, and build more resilient livelihoods.'; ?></p>
      <p><?php echo current_lang() === 'sw'
          ? 'Mtazamo wetu unaanzia kwenye imani kwamba wakulima wakifanya kazi pamoja, wanaweza kushinda changamoto na kuunda mabadiliko ya kudumu ya kiuchumi na kijamii katika jamii zao.'
          : 'Our approach is rooted in the belief that when farmers work together, they can overcome challenges, access better opportunities, and create lasting economic and social change within their communities.'; ?></p>
    </div>
    <div>
      <img src="<?php echo SITE_URL; ?>/assets/images/wakulima_logo_bw.jpeg" alt="Wakulima" class="rounded-hero-img">
    </div>
  </div>
</section>

<section class="alt">
  <div class="container">
    <div class="pillars pillars-vm">
      <div class="pillar pillar-white">
        <h3><?php echo e(t('section.vision')); ?></h3>
        <p class="pillar-body-lg"><?php echo e(setting('vision_text')); ?></p>
      </div>
      <div class="pillar pillar-white">
        <h3><?php echo e(t('section.mission')); ?></h3>
        <p class="pillar-body-lg"><?php echo e(setting('mission_text')); ?></p>
      </div>
    </div>
  </div>
</section>

<?php if ($members): ?>
<section>
  <div class="container">
    <div class="section-head">
      <span class="eyebrow"><?php echo e(t('section.team')); ?></span>
      <h2><?php echo current_lang() === 'sw' ? 'Watu wanaosukuma harakati.' : 'The people driving the movement.'; ?></h2>
    </div>
    <div class="team-grid">
      <?php foreach ($members as $m):
          $photoUrl = image_url($m['photo'], SITE_URL . '/assets/images/wakulima_logo_bw.jpeg');
          $hasRealPhoto = !empty($m['photo']);
          [$pmw, $pmh] = $hasRealPhoto ? image_dimensions($m['photo']) : [1200, 1200]; ?>
        <div class="team-card">
          <div class="photo">
            <?php if ($hasRealPhoto): ?>
              <a class="photo-zoom" href="<?php echo e($photoUrl); ?>"
                 data-pswp-width="<?php echo (int)$pmw; ?>" data-pswp-height="<?php echo (int)$pmh; ?>"
                 aria-label="<?php echo e($m['full_name']); ?>">
                <img src="<?php echo e($photoUrl); ?>" alt="<?php echo e($m['full_name']); ?>">
              </a>
            <?php else: ?>
              <img src="<?php echo e($photoUrl); ?>" alt="<?php echo e($m['full_name']); ?>">
            <?php endif; ?>
          </div>
          <h3><?php echo e($m['full_name']); ?></h3>
          <div class="role"><?php echo e($m['role_title']); ?></div>
          <?php if ($m['bio']): ?><p class="bio-line"><?php echo e($m['bio']); ?></p><?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
