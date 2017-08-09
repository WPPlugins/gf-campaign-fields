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
class GF_Field_Device_Values extends GF_Field_HiddenGroup {

	/**
	* Sets the field type.
	*
	* @since  Unknown
	* @access public
	*
	* @var string The type of field.
	*/
	public $type = 'aqDeviceInfo';

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
		return esc_attr__( 'Device Info', GF_CAMPAIGN_FIELD_SLUG );
	}

	public function get_entry_inputs() {
		$this->inputs = array(
				array(
					'id'           => $this->id . '.1',
					'label'        => esc_html__( 'Type', GF_CAMPAIGN_FIELD_SLUG ),
					'name'	=> 'aq_devicetype',
				),
				array(
					'id'           => $this->id . '.2',
					'label'        => esc_html__( 'Browser', GF_CAMPAIGN_FIELD_SLUG ),
					'name'	=> 'aq_browsername',
				),
				array(
					'id'           => $this->id . '.3',
					'label'        => esc_html__( 'OS', GF_CAMPAIGN_FIELD_SLUG ),
					'name'	=> 'aq_deviceos',
				),
			);

		return $this->inputs;
	}
}

// Registers the Name field with the field framework.
GF_Fields::register( new GF_Field_Device_Values() );
