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
class GF_Field_GoogleAnalytics_Values extends GF_Field_HiddenGroup {

	/**
	 * Sets the field type.
	 *
	 * @since  Unknown
	 * @access public
	 *
	 * @var string The type of field.
	 */
	public $type = 'aqGoogleAnalytics';

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
		return esc_attr__( 'GA Campaign', GF_CAMPAIGN_FIELD_SLUG );
	}

	public function get_entry_inputs() {
		$this->inputs = array(
				array(
					'id'           => $this->id . '.1',
					'label'        => esc_html__( 'Source', GF_CAMPAIGN_FIELD_SLUG ),
					'name'	=> 'aq_campaign_source',

				),
				array(
					'id'           => $this->id . '.2',
					'label'        => esc_html__( 'Medium', GF_CAMPAIGN_FIELD_SLUG ),
					'name'	=> 'aq_campaign_medium',
				),
				array(
					'id'           => $this->id . '.3',
					'label'        => esc_html__( 'Campaign', GF_CAMPAIGN_FIELD_SLUG ),
					'name'	=> 'aq_campaign_name',
				),
				array(
					'id'           => $this->id . '.4',
					'label'        => esc_html__( 'Term', GF_CAMPAIGN_FIELD_SLUG ),
					'name'	=> 'aq_campaign_term',
				),
				array(
					'id'           => $this->id . '.5',
					'label'        => esc_html__( 'Content', GF_CAMPAIGN_FIELD_SLUG ),
					'name'	=> 'aq_campaign_content',
				),
			);
		return $this->inputs;
	}

}

// Registers the Name field with the field framework.
GF_Fields::register( new GF_Field_GoogleAnalytics_Values() );
