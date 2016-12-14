<footer class="footer">
  <div class="row">
    <div class="small-12 medium-4 columns">
      <?php if ($page['footer_first']): ?>
        <?php print render($page['footer_first']); ?>
      <?php endif; ?>
    </div>
    <div class="small-12 medium-4 columns">
      <?php if ($page['footer_second']): ?>
        <?php print render($page['footer_second']); ?>
      <?php endif; ?>
    </div>
    <div class="small-12 medium-4 columns">
      <?php if ($page['footer_third']): ?>
        <?php print render($page['footer_third']); ?>
      <?php endif; ?>
    </div>
  </div>
</footer>
<footer class="footer--bottom">
  <div class="row">
    <div class="small-12 column text-center">
      Copyright <?php print date('Y'); ?> <%= themeHumanName %>
    </div>
  </div>
</footer>
