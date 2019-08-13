<?php
function fn_adv_rev_admin_settings(){

	if ( isset( $_POST['fn_adv_rev'] ) ) {

		//update_option( 'fn_adv_rev', $_POST['fn_adv_rev'] );

	} else {

	}

	?><div id="fn-admin-content">
		<header>
			<div class="uk-flex uk-flex-middle" uk-grid>
				<div class="uk-width-2-3">
					<h3 class="uk-margin-remove">Advanced Reviews</h3>
					<h1 class="uk-margin-remove">Einstellungen</h1>
				</div>
				<div class="uk-width-1-3 uk-text-right">
					<a class="uk-display-block logo" target="_blank" rel="noopener" href="https://www.firmennest.de"><img src="<?php echo FN_ADV_REV_URL; ?>assets/images/firmennest_Logo.svg" alt=""></a>
				</div>
			</div>
		</header>
		<main>
			<hr>
			<form action="" method="post" class="uk-form">
				<?php wp_nonce_field( 'fn-adv-rev-submenu-page-save', 'fn-adv-rev-submenu-page-save-nonce' ); ?>
				<div class="uk-grid">
					<div class="uk-width-1-4"><input class="uk-input" type="text" name="fn_adv_rev_api_apiID" value="<?php echo get_option('fn_adv_rev'); ?>" placeholder="Ich weiß noch nicht welche" required></div>
					<div class="uk-width-1-1"><button type="submit" class="uk-button uk-button-primary">Speichern</button></div>
				</div>
			</form>
			<hr>
			<!-- <button type="button" aria-disabled="true" aria-expanded="false" class="fn-adv-rev-api-import uk-button uk-button-primary">Import starten</button>
				<div id="fn-adv-rev-api-response"></div>
				<script>
					jQuery(function($){
						$('.fn-adv-rev-api-import').click(function(){
							$.ajax({
								url: ajaxurl,
								data: {
									action: 'fn_adv_rev_import'
								},
								beforeSend:function(xhr){
								},
								success:function(data){
									$('#fn-adv-rev-api-response').html(data);
								}
							});
						});
					});
				</script> -->
		</main>
	</div>
	<?php
}
