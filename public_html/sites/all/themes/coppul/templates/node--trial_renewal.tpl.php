<?php

/**
 * @file
 * Default theme implementation to display a node.
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
?>
<article id="node-<?php print $node->nid; ?>" class=" <?php print $classes; ?>"<?php print $attributes; ?>>

  <?php if ($user_picture || !$page): ?>
    <header class="entry-header">
      <?php print $user_picture; ?>

      <?php print render($title_prefix); ?>
      <?php if (!$page): ?>
        <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
      <?php endif; ?>
      <?php print render($title_suffix); ?>

      <?php if ($display_submitted): ?>
        <p class="submitted">
          <?php
            print t('Submitted by !username on !datetime',
              array('!username' => $name, '!datetime' => $date));
          ?>
        </p>
      <?php endif; ?>
    </header>
  <?php endif; ?>
      <?php print render($content['links']); ?>
  <div class="entry-content"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments, tags and links. We can render them later.
      hide($content['comments']);
      hide($content['links']);
      hide($content['field_tags']);
      hide($content['field_private_note']);
    ?>
    <?php
      print render($content['field_private_note']);
    ?>
    <h2><?php print $title; ?></h2>
    <?php   
      print render($content);
    ?>
    <?php if ($region['in_content_left'] || $region['in_content_right']): ?>
      <div class="row">
        <div class="six columns">
          <?php print render($region['in_content_left']); ?>
        </div>
        <div class="six columns">
          <?php print render($region['in_content_right']); ?>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <?php if (!empty($content['field_tags']) || !empty($content['links'])): ?>
    <footer>
      <?php print render($content['field_tags']); ?>
    </footer>
  <?php endif; ?>

  <?php print render($content['comments']); ?>

  <?php if ($display_submitted): ?>
  <p class="submitted"><?php print t('Last Updated %datetime', array('%datetime' => $date)); ?></p>
  <?php endif; ?>
</article>
