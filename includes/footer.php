</main>
<?php
// Newsletter block above the footer
$nlSuccess = flash('newsletter_success');
$nlError   = flash('newsletter_error');
?>
<section class="newsletter-band" id="newsletter">
  <div class="container newsletter-inner">
    <div class="newsletter-copy">
      <span class="eyebrow"><?php echo e(t('newsletter.eyebrow', 'Newsletter')); ?></span>
      <h2><?php echo e(t('newsletter.title', 'Stay in the loop.')); ?></h2>
      <p><?php echo e(t('newsletter.lead', 'Get occasional updates on our programs, harvests, and community stories. No spam — ever.')); ?></p>
    </div>
    <form class="newsletter-form" method="post" action="<?php echo SITE_URL; ?>/newsletter-subscribe.php" novalidate>
      <?php echo csrf_field(); ?>
      <?php echo recaptcha_field('newsletter'); ?>
      <label for="nl-email" class="sr-only"><?php echo e(t('newsletter.email_label', 'Email address')); ?></label>
      <div class="newsletter-row">
        <input id="nl-email" type="email" name="email" required maxlength="190"
               autocomplete="email"
               placeholder="<?php echo e(t('newsletter.placeholder', 'you@example.com')); ?>">
        <button type="submit" class="btn"><?php echo e(t('newsletter.subscribe', 'Subscribe')); ?></button>
      </div>
      <?php if ($nlSuccess): ?>
        <div class="newsletter-msg newsletter-msg-ok" role="status"><?php echo e($nlSuccess); ?></div>
      <?php elseif ($nlError): ?>
        <div class="newsletter-msg newsletter-msg-err" role="alert"><?php echo e($nlError); ?></div>
      <?php endif; ?>
      <p class="newsletter-fine"><?php echo e(t('newsletter.privacy', 'We only use your email to send our newsletter. You can unsubscribe any time.')); ?></p>
    </form>
  </div>
</section>
<footer class="site-footer">
  <div class="container footer-grid">
    <div>
      <div class="footer-brand">
        <img src="<?php echo SITE_URL; ?>/assets/images/wakulima_logo_bw.jpeg" alt="">
        <span><?php echo e(setting('site_name')); ?></span>
      </div>
      <p><?php echo e(t('footer.about_short')); ?></p>
    </div>
    <div>
      <h4><?php echo e(t('footer.quick_links')); ?></h4>
      <ul class="footer-links">
        <li><a href="<?php echo SITE_URL; ?>/about.php"><?php echo e(t('nav.about')); ?></a></li>
        <li><a href="<?php echo SITE_URL; ?>/what-we-do.php"><?php echo e(t('nav.what_we_do')); ?></a></li>
        <li><a href="<?php echo SITE_URL; ?>/programs.php"><?php echo e(t('nav.programs')); ?></a></li>
        <li><a href="<?php echo SITE_URL; ?>/news.php"><?php echo e(t('nav.news')); ?></a></li>
        <li><a href="<?php echo SITE_URL; ?>/gallery.php"><?php echo e(t('nav.gallery')); ?></a></li>
      </ul>
    </div>
    <div>
      <h4><?php echo e(t('footer.contact')); ?></h4>
      <ul class="footer-links">
        <li><?php echo e(setting('contact_address')); ?></li>
        <li><?php echo safe_email(setting('contact_email')); ?></li>
        <li><a href="tel:<?php echo e(setting('contact_phone')); ?>"><?php echo e(setting('contact_phone')); ?></a></li>
      </ul>
    </div>
    <div>
      <h4><?php echo e(t('footer.follow')); ?></h4>
      <div class="socials">
        <?php if (setting('facebook_url')): ?><a href="<?php echo e(setting('facebook_url')); ?>" target="_blank" rel="noopener">Facebook</a><?php endif; ?>
        <?php if (setting('twitter_url')): ?><a href="<?php echo e(setting('twitter_url')); ?>" target="_blank" rel="noopener">Twitter</a><?php endif; ?>
        <?php if (setting('instagram_url')): ?><a href="<?php echo e(setting('instagram_url')); ?>" target="_blank" rel="noopener">Instagram</a><?php endif; ?>
      </div>
    </div>
  </div>
  <div class="footer-bottom container">
    <div><a href="<?php echo SITE_URL; ?>/admin/index.php" class="admin-dot" aria-label="Admin" rel="nofollow">&copy;</a> <?php echo date('Y'); ?> <?php echo e(setting('site_name')); ?>. <?php echo e(t('footer.rights')); ?></div>
    <div class="partner">
      <span>In partnership with</span>
      <a href="https://maendeleo.cz/" target="_blank" rel="noopener">Nadace Maendeleo — maendeleo.cz</a>
    </div>
  </div>
</footer>
<script nonce="<?php echo e(csp_nonce()); ?>" src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
<?php if (!empty($hasGallery) || !empty($hasLightbox)): ?>
<script type="module" nonce="<?php echo e(csp_nonce()); ?>">
import PhotoSwipeLightbox from 'https://cdn.jsdelivr.net/npm/photoswipe@5.4.4/dist/photoswipe-lightbox.esm.min.js';
const pswpModule = () => import('https://cdn.jsdelivr.net/npm/photoswipe@5.4.4/dist/photoswipe.esm.min.js');

// Standalone photo-zoom items (news heroes, team photos, any wrapped image).
// One lightbox instance per gallery container; if items are direct children of body
// (no container), they behave as independent single-image popups.
if (document.querySelector('a.photo-zoom')) {
  new PhotoSwipeLightbox({
    gallery: 'body',
    children: 'a.photo-zoom',
    pswpModule,
    showHideAnimationType: 'fade',
    bgOpacity: 0.94,
    loop: true,
  }).init();
}

if (!document.querySelector('.gallery-grid')) { /* skip gallery init below */ } else {
const lightbox = new PhotoSwipeLightbox({
  gallery: '.gallery-grid',
  // Function form so category filters that toggle display:none are respected.
  children: (gallery) => Array.from(gallery.querySelectorAll('a.gallery-item')).filter(el => el.offsetParent !== null),
  pswpModule,
  showHideAnimationType: 'fade',
  bgOpacity: 0.94,
  loop: true,
});
lightbox.on('uiRegister', () => {
  // Caption bar (sits above the thumbnail strip)
  lightbox.pswp.ui.registerElement({
    name: 'caption',
    order: 9,
    isButton: false,
    appendTo: 'root',
    html: '',
    onInit: (el, pswp) => {
      pswp.on('change', () => {
        const slideEl = pswp.currSlide.data.element;
        const cap = slideEl ? slideEl.querySelector('.caption') : null;
        el.innerHTML = cap ? cap.innerHTML : '';
        el.style.display = cap ? 'block' : 'none';
      });
    }
  });

  // Bottom thumbnail filmstrip — click to jump, auto-scrolls to current slide
  lightbox.pswp.ui.registerElement({
    name: 'thumbs',
    order: 10,
    isButton: false,
    appendTo: 'root',
    html: '<div class="pswp-thumbs-inner"></div>',
    onInit: (el, pswp) => {
      const inner = el.querySelector('.pswp-thumbs-inner');
      const n = pswp.getNumItems();
      // Hide the strip entirely for single-image galleries
      if (n <= 1) { el.style.display = 'none'; return; }
      for (let i = 0; i < n; i++) {
        const data = pswp.getItemData(i);
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'pswp-thumb';
        btn.setAttribute('aria-label', 'Show image ' + (i + 1));
        const img = document.createElement('img');
        img.src = data.msrc || data.src;
        img.alt = '';
        img.loading = 'lazy';
        btn.appendChild(img);
        btn.addEventListener('click', () => pswp.goTo(i));
        inner.appendChild(btn);
      }
      const highlight = () => {
        const thumbs = inner.querySelectorAll('.pswp-thumb');
        thumbs.forEach((b, i) => b.classList.toggle('is-current', i === pswp.currIndex));
        const cur = inner.querySelector('.pswp-thumb.is-current');
        if (cur) cur.scrollIntoView({ block: 'nearest', inline: 'center', behavior: 'smooth' });
      };
      pswp.on('change', highlight);
      highlight();
    }
  });
});
lightbox.init();
}
</script>
<?php endif; ?>
</body>
</html>
