/**
 * Champ de fichier personnalisé accessible
 *
 * Le champ natif n'est pas correctement accessible sur une petite taille de fenêtre.
 * Le champ de fichier (input[type="file"]) est reconstruit visuellement afin que le texte associé, qui affiche "Aucun fichier sélectionné" puis le nom du fichier, puisse aller à la ligne.
 * 
 * Source originelle : https://codepen.io/Tanaguru/pen/GRpaOZr, le code hébergé sur CodePen est sous licence MIT - https://blog.codepen.io/documentation/licensing/ - https://opensource.org/license/mit/
 */

/** -----------------------------------------------------------------
 * Fonction pour convertir les bytes vers des KB, MB, etc.
 * https://stackoverflow.com/questions/15900485/correct-way-to-convert-size-in-bytes-to-kb-mb-gb-in-javascript
 */
function formatBytes(bytes, decimals = 0) {
	if (bytes === 0) return '0 Bytes';

	const k = 1024;
	const dm = decimals < 0 ? 0 : decimals;
	const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

	const i = Math.floor(Math.log(bytes) / Math.log(k));

	return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

jQuery.noConflict();
jQuery( document ).ready( function( $ ) {

	/** -----------------------------------------------------------------
	 * Le <label> doit être avant l'<input> dans le DOM donc nous avons besoin de JavaScript pour ajouter une classe au <label> quand son <input> a le focus.
	 * Ça ne peut être fait en CSS uniquement.
	 */
	$( '.form-field-file' )
		.blur( function() {
			$( this ).siblings( '.form-label-file' ).removeClass( 'has-focus' );
		})
		.focus( function() {
			$( this ).siblings( '.form-label-file' ).addClass( 'has-focus' );
		});

	/** -----------------------------------------------------------------
	 * Récupérer le nom et la taille du fichier téléversé dans le champ fichier
	 */
	$( '.form-field-file' ).change(function(e){

		var fileName = e.target.files[0].name;
		var fileSize = e.target.files[0].size;
		
		$( this ).siblings( '.form-file-information' )
		.empty()
		.append( 'Fichier choisi : ' + fileName + ' (' + formatBytes(fileSize) + ( ')' ) );

	});

});
