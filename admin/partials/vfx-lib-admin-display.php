<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/tikifez
 * @since      1.0.0
 *
 * @package    Vfx_Lib
 * @subpackage Vfx_Lib/admin/partials
 */

 $plugin_name = 'vfx-lib'; // TODO: call plugin name dynamically
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
<h1>VFX Libraries</h1>

<form method="post" action="options.php">
<?php

  do_settings_sections('vfx-lib');
  settings_fields("vfx-libraries");
  submit_button();
?>

</form>
</div>