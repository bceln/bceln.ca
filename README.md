# Retainer Notes
----------------

## Patches
### Context Module
Menu Trails in Context are an ongoing issue which requires Context to be continuously patched. The current patch can be [found on Drupal.org](https://drupal.org/node/835090). The patch name is _context-835090-72.patch_.

**Do not update the Context module** unless it's a security update and please test thoroughly locally before applying on the live site. Look for Contexts that have a **Menu** or **Menu trail** reaction.

### Entity API
There was an issue with some Entity tokens that needed a patch to fix it. The patch can be [found on Drupal.org](https://drupal.org/node/1440928#comment-7239960).

**Do not update the Entity module** unless it's a security update and please test thoroughly locally before applying on the live site.
