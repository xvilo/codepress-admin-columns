<?php
/**
 * Custom field column, displaying the contents of meta fields.
 * Suited for all storage models supporting WordPress' default way of handling meta data.
 *
 * Supports different types of meta fields, including dates, serialized data, linked content,
 * and boolean values.
 *
 * @since 1.0
 */
class CPAC_Column_Custom_Field extends CPAC_Column {

	/**
	 * @see CPAC_Column::init()
	 * @since 2.2.1
	 */
	public function init() {

		parent::init();

		// Properties
		$this->properties['type']	 		= 'column-meta';
		$this->properties['label']	 		= __( 'Custom Field', 'cpac' );
		$this->properties['classes']		= 'cpac-box-metafield';
		$this->properties['is_cloneable']	= true;

		// Options
		$this->options['field']					= '';
		$this->options['field_type']			= '';
		$this->options['before']				= '';
		$this->options['after']					= '';

		$this->options['image_size']			= '';
		$this->options['image_size_w']			= 80;
		$this->options['image_size_h']			= 80;

		$this->options['excerpt_length']		= 15;

		$this->options['date_format']			= '';
		$this->options['date_save_format']		= '';

		$this->options['taxonomy']				= '';

		$this->options['decimal_places']		= 0;

		$this->options['post_property_display'] = 'title';
		$this->options['post_link_to']			= 'edit_post';

		$this->options['text_output']			= 'raw';
	}

	/**
	 * @since 3.2.1
	 */
	public function is_field_type( $type ) {
		return $type === $this->get_field_type();
	}

	/**
	 * @since 3.2.1
	 */
	public function is_field( $field ) {
		return $field === $this->get_field();
	}

	/**
	 * @since 3.2.1
	 */
	public function get_field_type() {
		return $this->options->field_type;
	}

	/**
	 * @since 3.2.1
	 */
	public function get_field() {
		return $this->options->field;
	}

	/**
	 * @see CPAC_Column::sanitize_options()
	 * @since 1.0
	 */
	public function sanitize_options( $options ) {

		if ( empty( $options['date_format'] ) ) {
			$options['date_format'] = get_option( 'date_format' );
		}

		return $options;
	}

	/**
	 * @since 1.0
	 */
	public function get_custom_field_types() {
/*
case 'text':
case 'textarea':
case 'number':
case 'email':
case 'password':
case 'url':
case 'image':
case 'file':
case 'post':
case 'term':
case 'user':
case 'checkbox':
case 'color':
case 'count':
case 'date':
*/
		$custom_field_types = array(
			// Basic
			'text'			=> (object) array(
				'label' 		=>	__( 'Text', 'cpac' ),
				'group' 		=> 'basic'
			),
			'textarea'		=> (object) array(
				'label' 		=>	__( 'Text Area', 'cpac' ),
				'group' 		=> 'basic'
			),
			'number'		=> (object) array(
				'label' 		=>	__( 'Number', 'cpac' ),
				'group' 		=> 'basic'
			),
			'email'			=> (object) array(
				'label' 		=>	__( 'Email', 'cpac' ),
				'group' 		=> 'basic'
			),
			'password'		=> (object) array(
				'label' 		=>	__( 'Password', 'cpac' ),
				'group' 		=> 'basic'
			),
			'url'			=> (object) array(
				'label' 		=>	__( 'URL', 'cpac' ),
				'group' 		=> 'basic'
			),

			// Content
			'image'			=> (object) array(
				'label' 		=>	__( 'Image', 'cpac' ),
				'group' 		=> 'content'
			),
			'file'			=> (object) array(
				'label' 		=>	__( 'File', 'cpac' ),
				'group' 		=> 'content'
			),

			// Relational
			'post'			=> (object) array(
				'label' 		=>	__( 'Post', 'cpac' ),
				'group' 		=> 'relational'
			),
			'term'			=> (object) array(
				'label' 		=>	__( 'Term', 'cpac' ),
				'group' 		=> 'relational'
			),
			'user'			=> (object) array(
				'label' 		=>	__( 'User', 'cpac' ),
				'group' 		=> 'relational'
			),

			// Miscellaneous
			'checkbox'		=> (object) array(
				'label' 		=>	__( 'Yes/No (true/false)', 'cpac' ),
				'group' 		=> 'miscellaneous'
			),
			'color'			=> (object) array(
				'label' 		=>	__( 'Color', 'cpac' ),
				'group' 		=> 'miscellaneous'
			),
			'count' 		=> (object) array(
				'label' 		=>	__( 'Number of occurences', 'cpac' ),
				'group' 		=> 'miscellaneous'
			),
			'date'			=> (object) array(
				'label' 		=>	__( 'Date', 'cpac' ),
				'group' 		=> 'miscellaneous'
			)

			/*''				=> __( 'Default', 'cpac' ),
			'checkmark'		=> __( 'Checkmark (true/false)', 'cpac' ),
			'color'			=> __( 'Color', 'cpac' ),
			'count'			=> __( 'Counter', 'cpac' ),
			'date'			=> __( 'Date', 'cpac' ),
			'excerpt'		=> __( 'Excerpt'),
			'image'			=> __( 'Image', 'cpac' ),
			'library_id'	=> __( 'Media Library', 'cpac' ),
			'array'			=> __( 'Multiple Values', 'cpac' ),
			'numeric'		=> __( 'Numeric', 'cpac' ),
			'title_by_id'	=> __( 'Post Title (Post ID\'s)', 'cpac' ),
			'user_by_id'	=> __( 'Username (User ID\'s)', 'cpac' ),
			'term_by_id'	=> __( 'Term Name (Term ID\'s)', 'cpac' ),*/
		);

		/**
		 * Filter the available custom field types for the meta (custom field) field
		 *
		 * @since 2.0
		 *
		 * @param array $custom_field_types Available custom field types ([type] => [label])
		 */
		$custom_field_types = apply_filters( 'cac/column/meta/types', $custom_field_types );

		return $custom_field_types;
	}

	public function get_custom_field_type_groups() {

		$groups = array(
			'basic' => __( 'Basic', 'cpac' ),
			'content' => __( 'Content', 'cpac' ),
			'relational' => __( 'Relational', 'cpac' ),
			'miscellaneous' => __( 'Miscellaneous', 'cpac' )
		);

		/**
		 * Filter the available custom field type groups for the meta (custom field) field
		 * All custom field types from this column are assigned a group
		 *
		 * @since NEWVERSION
		 *
		 * @param array $groups Custom field type groups ([key] => [label])
		 */
		$groups = apply_filters( 'cac/column/meta/type_groups', $groups );

		return $groups;
	}

	/**
	 * Get Field key
	 *
	 * @since 2.0.3
	 *
	 * @param string Custom Field Key
	 */
	public function get_field_key() {

		return substr( $this->options->field, 0, 10 ) == 'cpachidden' ? str_replace( 'cpachidden', '', $this->options->field ) : $this->options->field;
	}

	/** 
	 * Parse a collection of IDs and format them to a single ID or an array of IDs.
	 * This method supports:
	 * - Objects with an "ID"-property
	 * - Single IDs as an integer or as a string
	 * - 
	 *
	 * @since NEWVERSION
	 *
	 * @param mixed $input Input, either an array, object, string or integer.
	 * @param bool $single Whether a single ID (true) should be returned or an array of results (false)
	 * @return int|array Either an array of IDs or a single ID, depending on $single
	 */
	public function parse_ids( $input, $single = false ) {

		$ids = $input;
		$input = maybe_unserialize( $input );

		if ( is_object( $input ) ) {
			// Try to find the ID of an object by trying to find an ID property of the object
			if ( isset( $input->ID ) ) {
				$ids = $input->ID;
			}
		}
		else if ( is_array( $input ) ) {
			// Try to find all IDs of the entries in the input array
			$ids = array();

			foreach ( $input as $index => $value ) {
				$id = $this->parse_ids( $value, true );

				if ( ! empty( $id ) ) {
					$ids[] = $id;
				}
			}
		}
		else if ( is_string( $input ) && strpos( $input, ',' ) !== false ) {
			// Try to treat the input as a comma-separated list of IDs
			$values = explode( ',', preg_replace( '/\s/', '', $input ) );
			$ids = $this->parse_ids( $values );
		}
		else {
			// The input cannot be further parsed: assume the input is an ID itself
			$ids = $input;
		}

		// Sanitize IDs
		if ( ! is_array( $ids ) ) {
			$ids = empty( $ids ) ? array() : array( $ids );
		}

		foreach ( $ids as $index => $id ) {
			$ids[ $index ] = preg_replace( '/[^0-9]/', '', $id );
		}

		if ( $single ) {
			return current( $ids );
		}

		return $ids;
	}

	/**
	 * @since NEWVERSION
	 */
	public function get_meta_value( $id, $single = false ) {

		$field_key = $this->get_field_key();

		if ( $field_key ) {
			return get_metadata( $this->storage_model->meta_type, $id, $field_key, $single );
		}
	}

	/**
	 * @see CPAC_Column::get_raw_value()
	 * @since 2.0.3
	 */
	public function get_raw_value( $id ) {

		$field_key = $this->get_field_key();
		$raw_value = $this->get_meta_value( $id, true );
		
		switch ( $this->get_field_type() ) {
			// Content
			case 'image':
			case 'file':
				$raw_value = $this->parse_ids( $raw_value );
				break;

			// Relational
			case 'post':
			case 'term':
			case 'user':
				$raw_value = $this->parse_ids( $raw_value );
				break;

			// Miscellaneous
			case 'checkbox':
				$raw_value = true;

				if ( empty( $raw_value ) || $meta === '0' || $meta === 'false' || $meta === 'no' ) {
					$raw_value = false;
				}
				break;

			case 'count':
				$values = $this->get_meta_value( $id );

				if ( is_array( $values ) ) {
					$raw_value = count( $values );
				}
				break;

			case 'date':
				$raw_value = $this->get_timestamp( $raw_value );
				break;
		}

		return apply_filters( 'cac/column/meta/raw_value', $raw_value, $id, $field_key, $this );
	}

	/**
	 * @see CPAC_Column::get_value()
	 * @since 1.0
	 */
	public function get_value( $id ) {

		$value = '';
		$raw_value = $this->get_raw_value( $id );

		switch ( $this->get_field_type() ) {
			// Basic
			case 'text':
				$value = $this->format_text_output( $raw_value, $this->get_option( 'text_output' ) );
				break;

			case 'textarea':
				$value = $this->format_text_output( $raw_value, $this->get_option( 'text_output' ) );
				$value = $this->get_shortened_string( $value, $this->get_option( 'excerpt_length' ) );
				break;

			case 'number':
				$value = $raw_value;
				$formatted_value = preg_replace( '/[^0-9,\.]/', '', $raw_value );

				if ( $formatted_value == $raw_value ) {
					$value = number_format_i18n( floatval( str_replace( ',', '.', $formatted_value ) ), $this->get_option( 'decimal_places' ) );
				}
				else {
					$value = '<em>' . __( 'NaN' ) . '</em>';
				}
				break;

			// Content
			case 'image':
				$value = implode( $this->get_thumbnails( $raw_value, array(
					'image_size'	=> $this->get_option( 'image_size' ),
					'image_size_w'	=> $this->get_option( 'image_size_w' ),
					'image_size_h'	=> $this->get_option( 'image_size_h' )
				) ) );
				break;

			// Relational
			case 'post':
				$items = array();

				foreach ( $raw_value as $itemid ) {
					$label = '';
					$link = '';

					// Get page to link to
					switch ( $this->get_option( 'post_link_to' ) ) {
						case 'edit_post':
							$link = get_edit_post_link( $itemid );
							break;
						case 'view_post':
							$link = get_permalink( $itemid );
							break;
						case 'edit_author':
							$link = get_edit_user_link( get_post_field( 'post_author', $itemid ) );
							break;
						case 'view_author':
							$link = get_author_posts_url( get_post_field( 'post_author', $itemid ) );
							break;
					}

					// Get property of post to display
					switch ( $this->get_option( 'post_property_display' ) ) {
						case 'author':
							$label = get_the_author_meta( 'display_name', get_post_field( 'post_author', $itemid ) );
							break;
						default:
							$label = get_the_title( $itemid );
							break;
					}

					if ( $label ) {
						$items[] = $link ? "<a href='{$link}'>{$label}</a>" : $label;
					}
				}

				$value = implode( ', ', $items );
				break;

			case 'user':
				$items = array();

				foreach ( $raw_value as $itemid ) {
					$user = get_userdata( $itemid );

					if ( is_object( $user ) && ! empty( $user->display_name ) ) {
						$link = get_edit_user_link( $itemid );
						$label = $user->display_name;
						$items[] = $link ? "<a href='{$link}'>{$label}</a>" : $label;
					}
				}

				$value = implode( ', ', $items );
				break;

			// Miscellaneous
			case 'checkbox':
				$value = $this->get_asset_image( $raw_value ? 'checkmark.png' : 'no.png' );
				break;

			case 'color':
				if ( ! empty( $raw_value ) ) {
					$value = $this->get_color_for_display( $raw_value );
				}
				break;

			case 'date':
				$this->get_date( $raw_value, $this->get_option( 'date_format' ) );
				break;

			// Default
			default:
				$value = $raw_value;
				break;
		}

		/**
		 * Filter the display value for Custom Field columns
		 *
		 * @since 2.0.2
		 *
		 * @param mixed $value Custom field value
		 * @param int $id Object ID
		 * @param object $this Column instance
		 */
		$value = apply_filters( 'cac/column/meta/value', $value, $id, $this );

		$before = $this->get_before();
		$after 	= $this->get_after();

		// Add "before" and "after" strings to string
		if ( $value ) {
			$value = $before . $value . $after;
		}

		return $value;
	}

	/**
	 * Format text output
	 *
	 * @since NEWVERSION
	 *
	 * @param string $value Value to format
	 * @param string $format Format type; raw|formatted_html|strip_tags
	 * @return string Formatted value
	 */
	public function format_text_output( $value, $format = 'raw' ) {

		switch ( $format ) {
			case 'raw':
				$value = esc_html( $value );
				break;
			case 'strip_tags':
				$value = preg_replace( '/<.*?>/', '', $value );
				break;
		}

		return $value;
	}

	/**
	 * @see CPAC_Column::display_settings()
	 * @since 1.0
	 */
	public function display_settings() {

		$this->display_field_field_key();
		$this->display_field_field_type();

		switch ( $this->options->field_type ) {
			// Basic
			case 'text':
				$this->display_field_text_output();
				break;

			case 'textarea':
			 	$this->display_field_excerpt_length();
			 	$this->display_field_text_output();
				break;
				
			case 'number':
				$this->display_field_decimal_places();
				break;
				
			case 'email':
				break;
				
			case 'password':
				break;
				
			case 'url':
				break;
				
			// Content
			case 'image':
			 	$this->display_field_preview_size();
				break;
				
			case 'file':
				break;
				
			// Relational
			case 'post':
				$this->display_field_post_property_display();
				$this->display_field_post_link_to();
				break;
				
			case 'term':
				$this->display_field_taxonomy();
				break;
				
			case 'user':
				break;
				
			// Miscellaneous
			case 'checkbox':
				break;
				
			case 'color':
				break;
				
			case 'count':
				break;
				
			case 'date':
				$this->display_field_date_format();
				break;
		}

		$this->display_field_before_after();
	}

	/**
	 * Display settings field for post property to display
	 *
	 * @since NEWVERSION
	 */
	public function display_field_post_property_display() {

		$this->display_field_select(
			'post_property_display',
			__( 'Property To Display', 'cpac' ),
			array(
				'title' => __( 'Title' ),
				'author' => __( 'Author' )
			),
			__( 'Post property to display for related post(s).', 'cpac' )
		);
	}

	/**
	 * Display settings field for the page the posts should link to
	 *
	 * @since NEWVERSION
	 */
	public function display_field_post_link_to() {

		$this->display_field_select(
			'post_link_to',
			__( 'Link To', 'cpac' ),
			array(
				'' => __( 'None' ),
				'edit_post' => __( 'Edit Post' ),
				'view_post' => __( 'View Post' ),
				'edit_author' => __( 'Edit Post Author', 'cpac' ),
				'view_author' => __( 'View Public Post Author Page', 'cpac' )
			),
			__( 'Page the posts should link to.', 'cpac' )
		);
	}

	/**
	 * Display settings field for the type of output
	 *
	 * @since NEWVERSION
	 */
	public function display_field_text_output() {

		$this->display_field_radio(
			'text_output',
			__( 'Output', 'cpac' ),
			array(
				'raw' => __( 'Raw', 'cpac' ),
				'formatted_html' => __( 'Parse HTML' ),
				'strip_tags' => __( 'Strip HTML tags', 'cpac' )
			),
			__( 'The formatting to apply to the column value.', 'cpac' )
		);
	}

	/**
	 * Display settings field for selecting a taxonomy
	 *
	 * @since NEWVERSION
	 */
	public function display_field_taxonomy() {

		$taxonomies_raw = get_object_taxonomies( $this->get_post_type(), 'objects' );
		$taxonomies = array();

		foreach ( $taxonomies_raw as $taxonomy ) {
			$taxonomies[ $taxonomy->name ] = $taxonomy->labels->name;
		}

		$this->display_field_select( 'taxonomy', __( 'Taxonomy', 'cpac' ), $taxonomies );
	}

	/**
	 * Display the settings field for the number of decimal places to display
	 *
	 * @since NEWVERSION
	 */
	public function display_field_decimal_places() {

		$this->display_field_text( 'decimal_places', __( 'Decimal Places', 'cpac' ), __( 'The number of decimal places to display for the number.', 'cpac' ) );
	}

	/**
	 * Display the settings field the maximum number of entries for this field to display
	 *
	 * @since NEWVERSION
	 */
	public function display_field_entry_limit() {

		?>
		<tr class="column_entry_limit">
			<?php $this->label_view(
				__( 'Entry Limit', 'cpac' ),
				__( 'The number of entries for this field to display. Defaults to 1.', 'cpac' ),
				'entry_limit'
			); ?>
			<td class="input">
				<input type="number" step="1" name="<?php $this->attr_name( 'entry_limit' ); ?>" id="<?php $this->attr_id( 'entry_limit' ); ?>" value="<?php echo esc_attr( $this->get_option( 'entry_limit' ) ); ?>" placeholder="<?php esc_attr_e( 'No limit', 'cpac' ); ?>">
			</td>
		</tr>
		<?php
	}

	/**
	 * Display the settings field for the column field key
	 *
	 * @since NEWVERSION
	 */
	public function display_field_field_key() {

		?>
		<tr class="column_field">
			<?php $this->label_view( __( 'Custom Field', 'cpac' ), __( 'Select your custom field.', 'cpac' ), 'field' ); ?>
			<td class="input">
				<?php if ( $meta_keys = $this->storage_model->get_meta_keys( true ) ) : ?>
					<select name="<?php $this->attr_name( 'field' ); ?>" id="<?php $this->attr_id( 'field' ); ?>">
						<?php foreach ( $meta_keys as $field ) : ?>
							<option value="<?php echo $field ?>"<?php selected( $field, $this->options->field ) ?>>
								<?php echo substr( $field, 0, 10 ) == 'cpachidden' ? str_replace( 'cpachidden', '', $field ) : $field; ?>
							</option>
						<?php endforeach; ?>
					</select>
				<?php else : ?>
					<?php _e( 'No custom fields available.', 'cpac' ); ?> <?php printf( __( 'Please create a %s first.', 'cpac' ), '<em>' . $this->storage_model->singular_label . '</em>' ); ?>
				<?php endif; ?>

			</td>
		</tr>
		<?php
	}

	/**
	 * Display the settings field for the column field type
	 *
	 * @since NEWVERSION
	 */
	public function display_field_field_type() {

		$groups = $this->get_custom_field_type_groups();
		$types = $this->get_custom_field_types();
		$groups_types = array();

		foreach ( $types as $typename => $type ) {
			if ( ! isset( $groups_types[ $type->group ] ) ) {
				$groups_types[ $type->group ] = array();
			}

			$groups_types[ $type->group ][ $typename ] = $type;
		}
		?>
		<tr class="column_field_type">
			<?php $this->label_view(
				__( 'Field Type', 'cpac' ),
				__( 'This will determine how the value will be displayed.', 'cpac' ),
				'field_type'
			); ?>
			<td class="input">
				<select name="<?php $this->attr_name( 'field_type' ); ?>" id="<?php $this->attr_id( 'field_type' ); ?>">
				<?php foreach ( $groups_types as $group => $grouptypes ) : ?>
					<optgroup label="<?php echo esc_attr( $groups[ $group ] ); ?>">
						<?php foreach ( $grouptypes as $typename => $type ) : ?>
							<option value="<?php echo esc_attr( $typename ); ?>" <?php selected( $typename, $this->get_field_type() ); ?>>
								<?php echo $type->label; ?>
							</option>
						<?php endforeach; ?>
					</optgroup>
				<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<?php
	}

}