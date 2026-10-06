<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = t('nav.gallery');
$pageDescription = t('meta.gallery.description');
$pageKeywords    = t('meta.gallery.keywords');

$images = $pdo->query("SELECT * FROM gallery ORDER BY sort_order ASC, id DESC")->fetchAll();
$categories = [];
foreach ($images as $img) {
    if (!empty($img['category']) && !in_array($img['category'], $categories, true)) $categories[] = $img['category'];
}
$hasGallery = (bool)$images;
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
  <div class="container">
    <span class="eyebrow"><?php echo e(t('section.gallery')); ?></span>
    <h1><?php echo current_lang() === 'sw' ? 'Picha kutoka kwenye harakati zetu.' : 'Photos from our work.'; ?></h1>
    <p class="lead"><?php echo current_lang() === 'sw'
        ? 'Mafunzo, siku za shambani, na wanachama wetu.'
        : 'Trainings, field days, and the members that make it possible.'; ?></p>
  </div>
</section>

<section>
  <div class="container">
    <?php if (!$images): ?>
      <p><?php echo e(t('gallery.empty')); ?></p>
    <?php else: ?>
      <?php if ($categories): ?>
        <div class="gallery-filter">
          <button class="active" data-filter="all"><?php echo e(t('gallery.all')); ?></button>
          <?php foreach ($categories as $c): ?>
            <button data-filter="<?php echo e($c); ?>"><?php echo e($c); ?></button>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <div class="gallery-grid" id="galleryGrid">
        <?php foreach ($images as $g): ?>
          <a href="<?php echo e(image_url($g['image'])); ?>"
             class="gallery-item"
             data-fancybox="gallery"
             <?php if ($g['caption']): ?>data-caption="<?php echo e($g['caption']); ?>"<?php endif; ?>
             data-category="<?php echo e($g['category'] ?: 'uncat'); ?>">
            <img src="<?php echo e(image_url($g['image'])); ?>" alt="<?php echo e($g['caption']); ?>" loading="lazy">
            <?php if ($g['caption']): ?><div class="caption"><?php echo e($g['caption']); ?></div><?php endif; ?>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
