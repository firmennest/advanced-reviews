<?php

defined( 'ABSPATH' ) || exit;

function fn_adv_rev_admin_settings(){
	if ( isset( $_POST['fn_adv_rev_setting'] ) ) {
		$settings = $_POST['fn_adv_rev_setting'];
		foreach ($settings as $setting => $settingAr) {
			if($setting === 'general'){
				$gValues = array();
				$fieldKey = 'fn_adv_rev_setting['. $setting . ']';
				foreach ($settingAr as $key => $value) {
					if(is_array($value)){
						$arrayKey = $key;
						foreach ($value as $key => $content) {
						 $gValues[$arrayKey][$key] = $content;
						}
					}else{
						$gValues[$key] = $value;
					}
					update_option( $fieldKey, $gValues );
				}
			}else if($setting === 'fields'){
				$fieldKey = 'fn_adv_rev_setting['. $setting . ']';
				$fValues = array();
				foreach ($settingAr as $key => $field) {
					if (!empty($field['label'])) {
						array_push($fValues ,$field);
					}
				}
				update_option( $fieldKey, $fValues );
			}else if($setting === 'questions'){
				$qValues = array();
				$fieldKey = 'fn_adv_rev_setting['. $setting . ']';
				foreach ($settingAr as $key => $value) {
					 $qValues[$key] = $value;
				}
				$qValues = array_filter($qValues);
				update_option( $fieldKey, $qValues );
			}
		}
		if (!array_key_exists('general', $settings)) {
			$fieldKey = 'fn_adv_rev_setting['. 'general' . ']';
			update_option( $fieldKey, array() );
		}

	} else {

	}

	$settingsGeneral = get_option('fn_adv_rev_setting[general]');

	?><div id="fn-admin-content">
		<header>
			<div class="uk-flex uk-flex-middle" uk-grid>
				<div class="uk-width-2-3">
					<h3 class="uk-margin-remove">Advanced Reviews</h3>
					<h1 class="uk-margin-remove">Einstellungen</h1>
				</div>
				<div class="uk-width-1-3 uk-text-right">
					<a class="uk-display-block logo" target="_blank" rel="noopener" href="https://www.firmennest.de"><img src="<?php echo FN_ADV_REV_URL; ?>admin/assets/images/firmennest_Logo.svg" alt=""></a>
				</div>
			</div>
		</header>
		<main>
			<hr>
			<form action="" method="post" class="uk-form">
				<?php wp_nonce_field( 'fn-adv-rev-submenu-page-save', 'fn-adv-rev-submenu-page-save-nonce' ); ?>
				<div class="uk-grid">
					<div class="uk-width-1-1@m">
						<ul uk-accordion>
					    <li>
					        <a class="uk-accordion-title" href="#"><div class="uk-h3 uk-margin-remove">Allgemein</div></a>
					        <div class="uk-accordion-content">
										<div class="uk-h4">Bewertungen kategorisieren</div>
										<fieldset class="uk-fieldset">
											<div class="uk-margin uk-grid-small uk-child-width-1-1 uk-grid">
						            <label class="uk-h6 uk-margin-remove"><input class="uk-checkbox uk-margin-small-right" type="checkbox" name="fn_adv_rev_setting[general][taxonomy]" <?php if (isset($settingsGeneral['taxonomy']) && $settingsGeneral['taxonomy'] === 'on') echo 'checked'; ?>> Kategorien aktivieren</label>
							        </div>
										</fieldset>
										<div class="uk-h4">E-Mail Benachrichtigung neuer Bewertung senden an</div>
										<fieldset class="uk-fieldset">
											<div class="uk-margin uk-grid-small uk-child-width-1-3 uk-grid">
												<div class=""><input class="uk-input" type="text" name="fn_adv_rev_setting[general][notificationmail]" value="<?php if (!empty($settingsGeneral['notificationmail'])) echo $settingsGeneral['notificationmail']; ?>" placeholder="E-Mail"></div>
											</div>
										</fieldset>
										<div class="uk-h4">Labels</div>
										<fieldset class="uk-fieldset">
											<div class="uk-margin uk-grid-small uk-child-width-1-3 uk-grid">
												<div class=""><input class="uk-input" type="text" name="fn_adv_rev_setting[general][label][name]" value="<?php if (!empty($settingsGeneral['label']['name'])) echo $settingsGeneral['label']['name']; ?>" placeholder="Eigene Beschriftung für Name"></div>
											</div>
											<div class="uk-margin uk-grid-small uk-child-width-1-3 uk-grid">
												<div class=""><input class="uk-input" type="text" name="fn_adv_rev_setting[general][label][message]" value="<?php if (!empty($settingsGeneral['label']['message'])) echo $settingsGeneral['label']['message']; ?>" placeholder="Eigene Beschriftung für Nachricht"></div>
											</div>
										</fieldset>
										<div class="uk-h4">Überschriften</div>
										<fieldset class="uk-fieldset">
											<div class="uk-margin uk-grid-small uk-child-width-1-1 uk-grid">
												<div class=""><input class="uk-input" type="text" name="fn_adv_rev_setting[general][headline][questions]" value="<?php if (!empty($settingsGeneral['headline']['questions'])) echo $settingsGeneral['headline']['questions']; ?>" placeholder="Eigene Überschrift für den Sternebereich im Formular"></div>
											</div>
										</fieldset>
					        </div>
					    </li>
							<li>
								<a class="uk-accordion-title" href="#"><div class="uk-h3 uk-margin-remove">Bilder</div></a>
								<div class="uk-accordion-content">
									<fieldset class="uk-fieldset">
										<label class="uk-h6 uk-margin-remove"><input class="uk-checkbox uk-margin-small-right" type="checkbox" name="fn_adv_rev_setting[general][placeholderImageStatus]" <?php if (isset($settingsGeneral['placeholderImageStatus']) && $settingsGeneral['placeholderImageStatus'] === 'on') echo 'checked'; ?>> Bild pro Bewertung aktivieren</label>
									</fieldset>
									<div class="uk-h4">Platzhalterbild</div>
									<fieldset class="uk-fieldset">
										<div class="uk-margin uk-grid-small uk-child-width-1-1 uk-grid">
											<?php
											$image_id = intVal($settingsGeneral['placeholderImage']);
											if( intval( $image_id ) > 0 ) {
												// Change with the image size you want to use
												$image = wp_get_attachment_image( $image_id, 'thumbnail', false, array( 'id' => 'fn_adv_rev_setting-preview-image' ) );
											} else {
												// Some default image
												$image = '<div class="uk-margin-small"><img id="fn_adv_rev_setting-preview-image" src="" /></div>';
											} ?>
										 <?php echo '<div class="uk-margin-small">'.$image.'</div>'; ?>
										 <div>
											<input type="hidden" name="fn_adv_rev_setting[general][placeholderImage]" id="fn_adv_rev_setting_image_id" value="<?php echo esc_attr( $image_id ); ?>" />
											<input type='button' class="uk-button uk-button-primary" value="<?php esc_attr_e( 'Bild auswählen', 'firmennest | Advanced Reviews' ); ?>" id="fn_adv_rev_setting_media_manager"/>
											<?php if( intval( $image_id ) > 0 ) {
												?><input type='button' class="uk-button uk-button-danger" value="<?php esc_attr_e( 'Bild löschen', 'firmennest | Advanced Reviews' ); ?>" id="fn_adv_rev_setting_media_delete"/><?php
											} ?>
										 </div>
										</div>
									</fieldset>
								</div>
							</li>
							<li>
								<a class="uk-accordion-title" href="#"><div class="uk-h3 uk-margin-remove">Felder</div></a>
								<div class="uk-accordion-content">
									<fieldset class="uk-fieldset"><?php
											$fields = get_option('fn_adv_rev_setting[fields]');
											if($fields){
												foreach ($fields as $key => $field) {
													$req = intVal($field['required']);
													?><div class="fn_adv_rev_add_field_frame uk-margin-small uk-grid-small uk-child-width-auto uk-grid">
														<div class="">
															<label for="">Beschriftung</label>
															<input class="uk-input" type="text" name="fn_adv_rev_setting[fields][<?php echo $key; ?>][label]" value="<?php echo $field['label']; ?>">
														</div>
														<div class="">
															<label for="">Typ</label>
															<select class="uk-select" name="fn_adv_rev_setting[fields][<?php echo $key; ?>][type]" id="">
																<option value="text" selected>text</option>
															</select>
														</div>
														<div class="">
															<label for="">Pflichtfeld</label>
															<select class="uk-select" name="fn_adv_rev_setting[fields][<?php echo $key; ?>][required]" id="">
																<option value="0" <?php if(!$req)echo 'selected'; ?>>Optional</option>
																<option value="1" <?php if($req)echo 'selected';?>>Pflicht</option>
															</select>
														</div>
														<div class="">
															<label for="">Ausgabeposition</label>
															<select class="uk-select" name="fn_adv_rev_setting[fields][<?php echo $key; ?>][position]" id="">
																<option value="">Bitte wählen...</option>
																<option value="topText" <?php if($field['position'] === 'topText') echo 'selected'; ?>>Über der Nachricht</option>
																<option value="bottomText" <?php if($field['position'] === 'bottomText') echo 'selected'; ?>>Unter der Nachricht</option>
																<option value="nextToName" <?php if($field['position'] === 'nextToName') echo 'selected'; ?>>Neben dem Namen</option>
																<option value="topName" <?php if($field['position'] === 'topName') echo 'selected'; ?>>Über dem Namen</option>
																<option value="bottomName" <?php if($field['position'] === 'bottomName') echo 'selected'; ?>>Unter dem Namen</option>
															</select>
														</div>
													</div><?php
												}
											}else{
												?><div class="fn_adv_rev_add_field_frame uk-margin-small uk-grid-small uk-child-width-auto uk-grid">
													<div class=""><input class="uk-input" type="text" name="fn_adv_rev_setting[fields][0][label]" value="" placeholder="Bezeichnung"></div>
													<div class="">
														<select class="uk-select" name="fn_adv_rev_setting[fields][0][type]" id="">
															<option value="text" selected>text</option>
														</select>
													</div>
													<div class="">
														<select class="uk-select" name="fn_adv_rev_setting[fields][0][required]" id="">
															<option value="0" selected>Optional</option>
															<option value="1">Pflicht</option>
														</select>
													</div>
												</div><?php
											}
						        ?>
									</fieldset>
									<div onclick="fn_adv_rev_add_field(jQuery(this),'fn_adv_rev_setting[fields]');" class="uk-button uk-button-small uk-button-secondary">Feld hinzufügen</div>
								</div>
							</li>
							<li>
								<a class="uk-accordion-title" href="#"><div class="uk-h3 uk-margin-remove">Fragen (Sternebewertungen)</div></a>
								<div class="uk-accordion-content">
									<fieldset class="uk-fieldset">
										<?php
											$questions = get_option('fn_adv_rev_setting[questions]');
											if($questions){
												foreach ($questions as $key => $value) {
													?><div class="fn_adv_rev_add_field_frame uk-margin-small uk-grid-small uk-child-width-expand uk-grid">
														<div><input class="uk-input" type="text" name="fn_adv_rev_setting[questions][<?php echo $key; ?>]" value="<?php echo $value; ?>"></div>
													</div><?php
												}
											}else{
												?><div class="fn_adv_rev_add_field_frame uk-margin-small uk-grid-small uk-child-width-expand uk-grid">
													<div><input class="uk-input" type="text" name="fn_adv_rev_setting[questions][0]" value=""></div>
												</div><?php
											}
										?>
									</fieldset>
									<div onclick="fn_adv_rev_add_field(jQuery(this),'fn_adv_rev_setting[questions]' );" class="uk-button uk-button-small uk-button-secondary">Frage hinzufügen</div>
									<?php /* if (is_array($questions) && count($questions) > 0){
										?><div class="uk-h4">Ausgabeposition</div>
										<fieldset class="uk-fieldset">
											<div class="uk-margin uk-grid-small uk-child-width-1-1 uk-grid">
												<div class="">
													<select class="uk-select" name="fn_adv_rev_setting[general][questions][position]" id="">
														<option value="">Bitte wählen...</option>
														<option value="topText" <?php if (!empty($settingsGeneral['general']['questions']['position']) && $settingsGeneral['general']['questions']['position'] === 'topText') echo $settingsGeneral['selected']; ?>>Über der Nachricht</option>
														<option value="bottomText" <?php if (!empty($settingsGeneral['general']['questions']['position']) && $settingsGeneral['general']['questions']['position'] === 'bottomText') echo $settingsGeneral['selected']; ?>>Unter der Nachricht</option>
														<option value="nextToName" <?php if (!empty($settingsGeneral['general']['questions']['position']) && $settingsGeneral['general']['questions']['position'] === 'nextToName') echo $settingsGeneral['selected']; ?>>Neben dem Namen</option>
														<option value="topName" <?php if (!empty($settingsGeneral['general']['questions']['position']) && $settingsGeneral['general']['questions']['position'] === 'topName') echo $settingsGeneral['selected']; ?>>Über dem Namen</option>
														<option value="bottomName" <?php if (!empty($settingsGeneral['general']['questions']['position']) && $settingsGeneral['general']['questions']['position'] === 'bottomName') echo $settingsGeneral['selected']; ?>>Unter dem Namen</option>
													</select>
												</div>
											</div>
										</fieldset><?php
									} */ ?>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<hr>
				<button type="submit" class="uk-button uk-button-primary">Einstellungen speichern</button>
			</form>
			<hr>
		</main>
	</div>
	<?php
}
