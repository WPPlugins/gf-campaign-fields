<?php

// If Gravity Forms isn't loaded, bail.
if ( ! class_exists( 'GF_Field_HiddenGroup' ) ) {
	die();
}

class AqGF_Marin extends GF_Field_HiddenGroup {

    public $type = 'aqMarin';

		public function __construct( $data = array() ) {
			parent::__construct($data);
		}

		public function get_form_editor_field_title() {
			return esc_attr__( 'Marin Tracking', GF_CAMPAIGN_FIELD_SLUG );
		}

		public function get_entry_inputs() {
			$this->inputs = array(
					array(
						'id'           => $this->id . '.1',
						'title'        => esc_html__( 'Marin KW', GF_CAMPAIGN_FIELD_SLUG ),
						'label'			=> esc_html__( 'MKWID', GF_CAMPAIGN_FIELD_SLUG ),
						'default_value' => array('aliases' => GF_CAMPAIGN_MERGETAG_MATCHTYPE),

					),
					array(
						'id'           => $this->id . '.2',
						'title'        => esc_html__( 'Creative ID', GF_CAMPAIGN_FIELD_SLUG ),
						'label'			=> esc_html__( 'PCRID', GF_CAMPAIGN_FIELD_SLUG ),
						'default_value' => array('aliases' => GF_CAMPAIGN_MERGETAG_GLCID),
					),

				);

			return $this->inputs;
		}

}

// Registers the Name field with the field framework.
GF_Fields::register( new AqGF_Marin() );
