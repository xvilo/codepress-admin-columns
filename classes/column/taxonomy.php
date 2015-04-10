<?php
/**
 * Taxonomy column, displaying terms from a taxonomy for any object type (i.e. posts)
 * supporting WordPress' native way of handling terms.
 *
 * @since 2.0
 */
class CPAC_Column_Taxonomy extends CPAC_Column {

	/**
	 * @see CPAC_Column::init()
	 * @since 2.2.1
	 */
	public function init() {

		parent::init();

		// Properties
		$this->properties['type']				= 'column-taxonomy';
		$this->properties['label']				= __( 'Taxonomy', 'cpac' );
		$this->properties['is_cloneable']		= true;

		// Options
		$this->options['taxonomy']				= ''; // Taxonomy slug
		$this->options['show_term_hierarchy']	= 'no';
	}

	/**
	 * @see CPAC_Column::get_value()
	 * @since 2.0
	 */
	public function get_value( $post_id ) {

		$term_ids = $this->get_raw_value( $post_id );

		if ( $this->get_option( 'show_term_hierarchy' ) != 'on' ) {
			return $this->get_terms_for_display( $term_ids, $this->get_taxonomy() );
		}

		foreach ( $term_ids as $term_id ) {
			$term_ancestry = get_ancestors( $term_id, $this->get_taxonomy() );
			$term_ancestry = array_reverse( $term_ancestry );
			$term_ancestry[] = $term_id;

			$ancestries[] = $this->get_terms_for_display( $term_ancestry, $this->get_taxonomy(), ' / ' );
		}

		return implode( "<br/>\n", $ancestries );
	}

	/**
	 * @see CPAC_Column::get_raw_value()
	 * @since 2.0.3
	 */
	public function get_raw_value( $post_id ) {

		return wp_get_post_terms( $post_id, $this->get_taxonomy(), array( 'fields' => 'ids' ) );
	}

	/**
	 * @see CPAC_Column::get_value()
	 * @since 2.3.4
	 */
	public function get_taxonomy() {

		return $this->get_option( 'taxonomy' );
	}

	/**
	 * @see CPAC_Column::apply_conditional()
	 * @since 2.0
	 */
	public function apply_conditional() {

		$post_type = $this->get_post_type();

		if ( $post_type && get_object_taxonomies( $post_type ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Display Settings
	 *
	 * @see CPAC_Column::display_settings()
	 * @since 2.0
	 */
	public function display_settings() {

		$this->display_field_taxonomy();
		$this->display_field_show_term_hierarchy();
	}

	/**
	 * Display taxonomy settings field
	 *
	 * @since NEWVERSION
	 */
	public function display_field_taxonomy() {

		$taxonomies = get_object_taxonomies( $this->get_post_type(), 'objects' );

		foreach ( $taxonomies as $index => $taxonomy ) {
			if ( $taxonomy->name == 'post_format' ) {
				unset( $taxonomies[ $index ] );
			}
		}
		?>

		<tr class="column_taxonomy">
			<?php $this->label_view( __( "Taxonomy", 'cpac' ), '', 'taxonomy' ); ?>
			<td class="input">
				<select name="<?php $this->attr_name( 'taxonomy' ); ?>" id="<?php $this->attr_id( 'taxonomy' ); ?>">
				<?php foreach ( $taxonomies as $taxonomy ) : ?>
					<option value="<?php echo $taxonomy->name; ?>"<?php selected( $taxonomy->name, $this->options->taxonomy ) ?>><?php echo $taxonomy->label; ?></option>
				<?php endforeach; ?>
				</select>
			</td>
		</tr>

		<?php
	}

	/**
	 * Display settings field for enabling showing the full term hierarchy
	 *
	 * @since NEWVERSION
	 */
	public function display_field_show_term_hierarchy() {

		$this->display_field_radio(
			'show_term_hierarchy',
			__( 'Show term hierarchy', 'cpac' ),
			array(
				'on' => __( 'Yes' ),
				'off' => __( 'No' )
			),
			__( 'Whether the full term hierarchy, including parent terms, should be shown.', 'cpac' )
		);
	}

}