<?php

// If the image is not set, terminate here
if ( empty( $params['image'] ) ) {
	return false;
}
?>

<div class="row">
    <div class="col-xs-12 tyche-adsense-banner">
		<?php echo $params['adsense_code'] ?>
    </div>
</div>
