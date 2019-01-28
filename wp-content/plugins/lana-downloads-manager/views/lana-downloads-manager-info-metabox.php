<?php defined( 'ABSPATH' ) or die(); ?>

<table class="form-table lana-downloads-manager-info">
    <tr>
        <th>
			<?php _e( 'Download Identification:', 'lana-downloads-manager' ); ?>
        </th>
        <td>
			<?php echo esc_html( '#' . $post->ID ); ?>
        </td>
    </tr>
    <tr>
        <th>
			<?php _e( 'Download Count:', 'lana-downloads-manager' ); ?>
        </th>
        <td>
			<?php echo absint( lana_downloads_manager_get_download_count() ); ?>
        </td>
    </tr>
</table>