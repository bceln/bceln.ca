<?php

/**
 * Expose menu items as context reactions.
 */
class context_reaction_menu_position extends context_reaction_menu {
  /**
   * Set active in all applicable menus.
   */
  function execute(&$vars = NULL) {
    if ($path = reset($this->get_active_paths())) {
      $result = db_query("SELECT menu_name FROM {menu_links} WHERE link_path = :path", array(':path' => $path));
      foreach ($result as $menu) {
        menu_tree_set_path($menu->menu_name, $path);
      }
    }
  }
}
