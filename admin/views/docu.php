<?php
function fn_adv_rev_admin_docu(){
	?><div id="fn-admin-content">
		<header>
			<div class="uk-flex uk-flex-middle" uk-grid>
				<div class="uk-width-2-3">
					<h3 class="uk-margin-remove">Advanced Reviews</h3>
					<h1 class="uk-margin-remove">Documentation</h1>
				</div>
				<div class="uk-width-1-3 uk-text-right">
					<a class="logo" target="_blank" rel="noopener" href="https://www.firmennest.de"><img src="<?php echo FN_ADV_REV_URL; ?>assets/images/firmennest_Logo.svg" alt=""></a>
				</div>
			</div>
		</header>
		<main>
			<hr>
			<table class="uk-table uk-table-divider">
		    <thead>
		        <tr>
		            <th>Shortcodes</th>
		            <th>Attribute</th>
								<th>Beispiel</th>
								<th>Hinweis</th>
		        </tr>
		    </thead>
		    <tbody>
		        <tr>
		            <td>[advanced-reviews-slider]</td>
		            <td>
									anzahl<br />
									offset<br />
									set<br />
									review
								</td>
								<td>[advanced-reviews-slider anzahl="4" offset="20" set="3" review="14,12,16"]</td>
		            <td>
									<strong>anzahl:</strong> Wieviele Bewertung ausgegeben werden. Bitte beachten Sie, dass <strong>offset</strong> nur funktioniert, wenn es eine <strong>anzahl</strong> gibt.
									<br />
									<strong>offset:</strong> Anzahl der ausgelassenen Bewertungen (neu -> alt).
									<br />
									<strong>set:</strong> Anzahl der Bewertung welche nebeneinander erscheinen.
									<br />
									<strong>review:</strong> Kommagetrennte IDs der relevanten Bewertungen. Die Reihenfolge der IDs ist gleichzeitig die Ausgabereihenfolge.
								</td>
		        </tr>
						<tr>
		            <td>[advanced-reviews-overview]</td>
		            <td>
									anzahl<br />
									offset<br />
									grid<br />
									masonry<br />
									review
								</td>
								<td>[advanced-reviews-overview grid="3"]</td>
								<td>
									<strong>anzahl:</strong> Wieviele Bewertung ausgegeben werden. Bitte beachten Sie, dass <strong>offset</strong> nur funktioniert, wenn es eine <strong>anzahl</strong> gibt.
									<br />
									<strong>offset:</strong> Anzahl der ausgelassenen Bewertungen (neu -> alt).
									<br />
									<strong>grid:</strong> Anzahl der Bewertung welche nebeneinander erscheinen.
									<br />
									<strong>masonry:</strong> 0 (aus) oder 1 (an).
									<br />
									<strong>review:</strong> Kommagetrennte IDs der relevanten Bewertungen. Die Reihenfolge der IDs ist gleichzeitig die Ausgabereihenfolge.
								</td>
		        </tr>
						<tr>
		            <td>[advanced-reviews-snippet]</td>
		            <td>-</td>
								<td>-</td>
		            <td>Shortcode am besten in den Footer packen. Wird automatisch auf der Startseite ausgeblendet.</td>
		        </tr>
						<tr>
		            <td>[advanced-reviews-form]</td>
		            <td>-</td>
								<td>-</td>
		            <td>Formular für Webseite für eingehende Bewertungen</td>
		        </tr>
		    </tbody>
			</table>
			<hr>
		</main>
	</div>
	<?php
}
