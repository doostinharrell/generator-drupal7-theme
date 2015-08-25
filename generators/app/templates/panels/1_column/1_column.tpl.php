<?php !empty($css_id) ? print '<div id="' . $css_id . '>' : ''; ?>

    <?php if ($content['header']): ?>
      <div class="row">
        <div class="large-12 columns">
  			  <?php print $content['header']; ?>
        </div>
  		</div>
    <?php endif ?>

    <?php if ($content['column']): ?>
      <div class="row">
        <div class="large-12 columns">
          <?php print $content['column']; ?>
        </div>
      </div>
    <?php endif ?>

<?php !empty($css_id) ? print '</div>' : ''; ?>
