<?php

// If Gravity Forms isn't loaded, bail.
if ( ! class_exists( 'GF_Field_HiddenGroup' ) ) {
	die();
}


/**
 * Class GF_Field_Name
 *
 * Handles the behavior of the Name field.
 *
 * @since Unknown
 */
class GF_Field_SEM_Values extends GF_Field_HiddenGroup {

	/**
	 * Sets the field type.
	 *
	 * @since  Unknown
	 * @access public
	 *
	 * @var string The type of field.
	 */
	public $type = 'aqSEM';

	public function __construct( $data = array() ) {
		parent::__construct($data);
	}


	/**
	 * Sets the field title of the Name field.
	 *
	 * @since  Unknown
	 * @access public
	 *
	 * @used-by GFCommon::get_field_type_title()
	 * @used-by GF_Field::get_form_editor_button()
	 *
	 * @return string
	 */
	public function get_form_editor_field_title() {
		return esc_attr__( 'SEM Values', GF_CAMPAIGN_FIELD_SLUG );
	}

	public function get_entry_inputs() {
		$this->inputs = array(
				array(
					'id'           => $this->id . '.1',
					'title'        => esc_html__( 'Match Type', GF_CAMPAIGN_FIELD_SLUG ),
					'label'			=> esc_html__( 'Match Type', GF_CAMPAIGN_FIELD_SLUG ),
					'default_value' => array('aliases' => GF_CAMPAIGN_MERGETAG_MATCHTYPE),

				),
				array(
					'id'           => $this->id . '.2',
					'title'        => esc_html__( 'GLCID', GF_CAMPAIGN_FIELD_SLUG ),
					'label'			=> esc_html__( 'GLCID', GF_CAMPAIGN_FIELD_SLUG ),
					'default_value' => array('aliases' => GF_CAMPAIGN_MERGETAG_GLCID),
				),

			);

		return $this->inputs;
	}
}

// Registers the Name field with the field framework.
GF_Fields::register( new GF_Field_SEM_Values() );
