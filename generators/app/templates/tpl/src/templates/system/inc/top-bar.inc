<div class="title-bar" data-responsive-toggle="primary-menu" data-hide-for="medium">
  <button class="menu-icon" type="button" data-toggle></button>
  <div class="title-bar-title">Menu</div>
</div>
<div class="top-bar" id="primary-menu">
  <div class="top-bar-left">
    <?php if ($main_menu): ?>
      <ul class="menu dropdown" data-parent-link="true" data-submenu-toggle="true" data-responsive-menu="accordion medium-dropdown">
        <?php if ($site_name): ?>
          <li class="menu-text">
            <strong><?php print $site_name; ?></strong>
          </li>
        <?php endif; ?>
        <?php print render($main_menu); ?>
      </ul>
    <?php endif; ?>
  </div>
  <?php if ($page['top_bar_right']): ?>
    <div class="top-bar-right">
      <?php print render($page['top_bar_right']); ?>
    </div>
  <?php endif; ?>
</div>