/**
 * Christmas Sweets custom Gutenberg block
 *
 * @link https://github.com/ahmadawais/Gutenberg-Boilerplate
 * Licensed under GPL v3.0.
 * Copyrighted to the WordPress Gutenberg team and WGA - AhmadAwais.com
 *
 * @package Christmas Sweets
 */

( function() {
	var __ = wp.i18n.__; // The __() for internationalization.
	var el = wp.element.createElement; // The wp.element.createElement() function to create elements.
	/**
	 * Register Basic Block.
	 *
	 * Registers a new block provided a unique name and an object defining its
	 * behavior. Once registered, the block is made available as an option to any
	 * editor interface where blocks are implemented.
	 *
	 * @param  {string}   name     Block name.
	 * @param  {Object}   settings Block settings.
	 * @return {?WPBlock}          The block, if it has been successfully
	 *                             registered; otherwise `undefined`.
	 */
	wp.blocks.registerBlockType( 'christmas-sweets/sweets', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Christmas Sweets: Candy', 'christmas-sweets' ), // Block title.
		keywords: [ 'image', 'christmas' ],
		icon: 'format-image', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
			attributes: {
			url: { type: 'string' },
		},


		// The "edit" property must be a valid function.
		edit: function( props ) {
			//Sets the src to our localized image url
			props.setAttributes( { url: christmas_sweets_candy.sweets_image_url } );
			// Creates a <img class='wp-block-gb-01-basic'></p>.
			return el(
				'img', // Tag type.
				// The class name is generated using the block's name prefixed with wp-block-, replacing the / namespace separator with a single -.
				{ className: props.className, src: props.attributes.url },
			);
		},

		// The "save" property must be specified and must be a valid function.
		save: function( props ) {
			return el(
				'img', // Tag type.
				// The class name is generated using the block's name prefixed with wp-block-, replacing the / namespace separator with a single -.
				{ className: props.className, src: props.attributes.url }, 
			);
		},
	});

	wp.blocks.registerBlockType( 'christmas-sweets/gingerbread', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Christmas Sweets: Gingerbread', 'christmas-sweets' ), // Block title.
		keywords: [ 'image', 'christmas' ],
		icon: 'format-image', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
			attributes: {
			url: { type: 'string' },
		},


		// The "edit" property must be a valid function.
		edit: function( props ) {
			//Sets the src to our localized image url
			props.setAttributes( { url: christmas_sweets_gingerbread.sweets_ginger_image_url } );
			// Creates a <img class='wp-block-gb-01-basic'></p>.
			return el(
				'img', // Tag type.
				// The class name is generated using the block's name prefixed with wp-block-, replacing the / namespace separator with a single -.
				{ className: props.className, src: props.attributes.url },
			);
		},

		// The "save" property must be specified and must be a valid function.
		save: function( props ) {
			return el(
				'img', // Tag type.
				// The class name is generated using the block's name prefixed with wp-block-, replacing the / namespace separator with a single -.
				{ className: props.className, src: props.attributes.url }, 
			);
		},
	});

})();