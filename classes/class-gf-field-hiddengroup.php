<?php

// If Gravity Forms isn't loaded, bail.
if ( ! class_exists( 'GFForms' ) ) {
	die();
}

/**
 * Class GF_Field_Name
 *
 * Handles the behavior of the Name field.
 *
 * @since Unknown
 */
class GF_Field_HiddenGroup extends GF_Field {

	/**
	 * Sets the field type.
	 *
	 * @since  Unknown
	 * @access public
	 *
	 * @var string The type of field.
	 */
	public $type = 'aqHiddenGroup';

	public function __construct( $data = array() ) {
		$data['visibility'] = 'visible';
		parent::__construct($data);
	}

	public function get_form_editor_button()
	{
			return array(
					'group' => 'advanced_fields',
					'text'  => $this->get_form_editor_field_title()
			);
	}

	/**
	 * Defines if conditional logic is supported by the Name field.
	 *
	 * @since Unknown
	 * @access public
	 *
	 * @used-by GFFormDetail::inline_scripts()
	 * @used-by GFFormSettings::output_field_scripts()
	 *
	 * @return bool true
	 */
	public function is_conditional_logic_supported() {
		return false;
	}


	public function get_form_editor_inline_script_on_page_render() {
			return "
			gform.addFilter('gform_form_editor_can_field_be_added', function (canFieldBeAdded, type) {
						if (type == '" . $this->type . "') {
							if (GetFieldsByType(['" . $this->type . "']).length > 0) {
									alert(" . json_encode( esc_html__( 'SORRY! Only one ', GF_CAMPAIGN_FIELD_SLUG ) . $this->get_form_editor_field_title() . esc_html__(' Field Allowed', GF_CAMPAIGN_FIELD_SLUG ) ) . ");
									return false;
							}
						}
					return canFieldBeAdded;
			});" . PHP_EOL . sprintf( "function SetDefaultValues_%s(field) {field.label = '%s';}", $this->type, $this->get_form_editor_field_title() ) . PHP_EOL;
	}

	/**
	 * Defines the field settings available for the Name field in the form editor.
	 *
	 * @since  Unknown
	 * @access public
	 *
	 * @used-by GFFormDetail::inline_scripts()
	 *
	 * @return array The field settings available.
	 */
	function get_form_editor_field_settings() {
		return array(
			'label_setting',
		);
	}

	public function get_entry_inputs() {
		$this->inputs = array(
				array(
					'id'           => $this->id . '.1',
					'label'        => esc_html__( 'Hidden Value', GF_CAMPAIGN_FIELD_SLUG ),
					'name'	=> 'aqHidden1',

				),
				array(
					'id'           => $this->id . '.2',
					'label'        => esc_html__( 'Hidden Value', GF_CAMPAIGN_FIELD_SLUG ),
					'name'	=> 'aqHidden2',
				),

			);
		return $this->inputs;
	}

	/**
	 * Gets the HTML markup for the field input.
	 *
	 * @since  Unknown
	 * @access public
	 *
	 * @used-by GFCommon::get_field_input()
	 * @uses    GF_Field::is_entry_detail()
	 * @uses    GF_Field::is_form_editor()
	 * @uses    GF_Field_Name::$size
	 * @uses    GF_Field_Name::$id
	 * @uses    GF_Field_Name::$subLabelPlacement
	 * @uses    GF_Field_Name::$isRequired
	 * @uses    GF_Field_Name::$failed_validation
	 * @uses    GFForms::get()
	 * @uses    GFFormsModel::get_input()
	 * @uses    GFCommon::get_input_placeholder_attribute()
	 * @uses    GFCommon::get_tabindex()
	 * @uses    GFCommon::get_field_placeholder_attribute()
	 *
	 * @param array      $form  The Form Object.
	 * @param string     $value The value of the field. Defaults to empty string.
	 * @param array|null $entry The Entry Object. Defaults to null.
	 *
	 * @return string The HTML markup for the field input.
	 */
	public function get_field_input( $form, $value = '', $entry = null ) {

		$is_entry_detail = $this->is_entry_detail();
		$is_form_editor  = $this->is_form_editor();
		$is_admin = $is_entry_detail || $is_form_editor;

		$form_id  = $form['id'];
		$id       = intval( $this->id );
		$field_id = $is_admin || $form_id == 0 ? "input_$id" : 'input_' . $form_id . "_$id";
		$form_id  = ( $is_admin ) && empty( $form_id ) ? rgget( 'id' ) : $form_id;

		$value        = esc_attr( $value );
		$field_type         = $is_entry_detail || $is_form_editor ? 'text' : 'hidden';
		$class_attribute    = $is_entry_detail || $is_form_editor ? '' : "class='gform_hidden'";
		$class_suffix  = $is_entry_detail ? '_admin' : '';

		$disabled_text         = $is_form_editor ? 'disabled="disabled"' : '';

		$field_markup = '';
		$inputs = $this->get_entry_inputs();
		foreach ($inputs as $field) {
			$input = GFFormsModel::get_input( $this, $field['id'] );
			$fieldID = str_replace('.','_',$field['id']);
			$style = ( $is_admin && rgar( $input, 'isHidden' ) ) ? "style='display:none;'" : '';

			if ( $is_admin || ! rgar( $input, 'isHidden' ) ) {
				$field_markup .= "<input type='{$field_type}' name='input_" . $field['id'] . "' id='input_{$form_id}_{$fieldID}' value='" . esc_attr( GFForms::get( $field['id'] , $value ) ) . "' placeholder='" . $field['label'] . "' {$class_attribute} {$disabled_text} />";
			}
		}

		return "<div class='ginput_complex{$class_suffix} ginput_container gfield_{$this->type}' id='{$field_id}'>{$field_markup}</div>";
	}

	/**
	 * Defines the CSS class to be applied to the field label.
	 *
	 * @since  Unknown
	 * @access public
	 *
	 * @used-by GF_Field::get_field_content()
	 *
	 * @return string The CSS class.
	 */
	public function get_field_label_class() {
		return 'gfield_label gfield_label_before_campaign';
	}

	/**
	 * Returns the field markup; including field label, description, validation, and the form editor admin buttons.
	 *
	 * The {FIELD} placeholder will be replaced in GFFormDisplay::get_field_content with the markup returned by GF_Field::get_field_input().
	 *
	 * @param string|array $value                The field value. From default/dynamic population, $_POST, or a resumed incomplete submission.
	 * @param bool         $force_frontend_label Should the frontend label be displayed in the admin even if an admin label is configured.
	 * @param array        $form                 The Form Object currently being processed.
	 *
	 * @return string
	 */
	/* public function get_field_content( $value, $force_frontend_label, $form ) {

		$field_label = $this->get_field_label( $force_frontend_label, $value );

		$validation_message = ( $this->failed_validation && ! empty( $this->validation_message ) ) ? sprintf( "<div class='gfield_description validation_message'>%s</div>", $this->validation_message ) : '';

		$is_form_editor  = $this->is_form_editor();
		$is_entry_detail = $this->is_entry_detail();
		$is_admin        = $is_form_editor || $is_entry_detail;

		$required_div = $is_admin || $this->isRequired ? sprintf( "<span class='gfield_required'>%s</span>", $this->isRequired ? '*' : '' ) : '';

		$admin_buttons = $this->get_admin_buttons();

		$target_input_id = $this->get_first_input_id( $form );

		$for_attribute = empty( $target_input_id ) ? '' : "for='{$target_input_id}'";

		$description = $this->get_description( $this->description, 'gfield_description' );
		if ( $this->is_description_above( $form ) ) {
			$clear         = $is_admin ? "<div class='gf_clear'></div>" : '';
			if ($is_admin) {
				$field_content = sprintf( "%s<label class='%s' $for_attribute >%s%s</label>%s{FIELD}%s$clear", $admin_buttons, esc_attr( $this->get_field_label_class() ), esc_html( $field_label ), $required_div, $description, $validation_message );
			} else {
				$field_content = sprintf( "{FIELD}%s", $validation_message );
			}
		} else {
			if ($is_admin) {
				$field_content = sprintf( "%s<label class='%s' $for_attribute >%s%s</label>{FIELD}%s%s", $admin_buttons, esc_attr( $this->get_field_label_class() ), esc_html( $field_label ), $required_div, $description, $validation_message );
			} else {
				$field_content = sprintf( "{FIELD}%s", $validation_message );
			}
		}

		return $field_content;
	}
*/
public function get_field_content( $value, $force_frontend_label, $form ) {
	$form_id         = $form['id'];
	$admin_buttons   = $this->get_admin_buttons();
	$is_entry_detail = $this->is_entry_detail();
	$is_form_editor  = $this->is_form_editor();
	$is_admin        = $is_entry_detail || $is_form_editor;
	$field_label     = $this->get_field_label( $force_frontend_label, $value );
	$field_id        = $is_admin || $form_id == 0 ? "input_{$this->id}" : 'input_' . $form_id . "_{$this->id}";
	$field_content   = ! $is_admin ? '{FIELD}' : $field_content = sprintf( "%s<label class='gfield_label' for='%s'>%s</label>{FIELD}", $admin_buttons, $field_id, esc_html( $field_label ) );

	return $field_content;
}
	/**
	 * Gets the field value to be displayed on the entry detail page.
	 *
	 * @since  Unknown
	 * @access public
	 *
	 * @used-by GFCommon::get_lead_field_display()
	 * @uses    GF_Field_Name::$id
	 *
	 * @param array|string $value    The value of the field input.
	 * @param string       $currency Not used.
	 * @param bool         $use_text Not used.
	 * @param string       $format   The format to output the value. Defaults to 'html'.
	 * @param string       $media    Not used.
	 *
	 * @return array|string The value to be displayed on the entry detail page.
	 */
	public function get_value_entry_detail( $value, $currency = '', $use_text = false, $format = 'html', $media = 'screen' ) {

		if ( is_array( $value ) ) {

			foreach ($this->inputs as $fieldval) {
				$tempValue =  trim( rgget( $fieldval['id'], $value ) );
				$vals[$fieldval['id']] = ( $format === 'html' ) ? esc_html($tempValue) : $tempValue ;
			}

			if ( $format === 'html' ) {
				$line_break = '<br />';
				$pre_label = '<b>';
				$post_label = '</b>';
			} else {
				$line_break = "\n";
				$pre_label = $post_label = '';
			}

			$return = "";
			foreach ($this->inputs as $fieldval) {
				$theValue = $vals[$fieldval['id']];
				$return .= ! empty( $return ) && ! empty( $theValue ) ? $line_break : '';
				$return .= ! empty( $theValue) ? $pre_label . "- " . $fieldval['label'] . ": " . $post_label . $theValue : '';
			}
		} else {
			$return = "NO ARRAY" . $value;
		}

		return $return;
	}

	/**
	 * Gets a property value from an input.
	 *
	 * @since  Unknown
	 * @access public
	 *
	 * @used-by GF_Field_Name::validate()
	 * @uses    GFFormsModel::get_input()
	 *
	 * @param int    $input_id      The input ID to obtain the property from.
	 * @param string $property_name The property name to search for.
	 *
	 * @return null|string The property value if found. Otherwise, null.
	 */
	public function get_input_property( $input_id, $property_name ) {
		$input = GFFormsModel::get_input( $this, $this->id . '.' . (string) $input_id );

		return rgar( $input, $property_name );
	}

	/**
	 * Sanitizes the field settings choices.
	 *
	 * @since  Unknown
	 * @access public
	 *
	 * @used-by GFFormDetail::add_field()
	 * @used-by GFFormsModel::sanitize_settings()
	 * @uses    GF_Field::sanitize_settings()
	 * @uses    GF_Field::sanitize_settings_choices()
	 *
	 * @return void
	 */
	public function sanitize_settings() {
		parent::sanitize_settings();
		if ( is_array( $this->inputs ) ) {
			foreach ( $this->inputs as &$input ) {
				if ( isset ( $input['choices'] ) && is_array( $input['choices'] ) ) {
					$input['choices'] = $this->sanitize_settings_choices( $input['choices'] );
				}
			}
		}
	}

	/**
	 * Gets the field value to be used when exporting.
	 *
	 * @since  Unknown
	 * @access public
	 *
	 * @used-by GFExport::start_export()
	 * @used-by GFAddOn::get_field_value()
	 * @used-by GFAddOn::get_full_name()
	 *
	 * @param array  $entry    The Entry Object.
	 * @param string $input_id The input ID to format. Defaults to empty string. If not set, uses t
	 * @param bool   $use_text Not used.
	 * @param bool   $is_csv   Not used.
	 *
	 * @return string The field value.
	 */
	public function get_value_export( $entry, $input_id = '', $use_text = false, $is_csv = false ) {
		if ( empty( $input_id ) ) {
			$input_id = $this->id;
		}

		if ( absint( $input_id ) == $input_id ) {
			// If field is simple (one input), simply return full content.
			$name = rgar( $entry, $input_id );
			if ( ! empty( $name ) ) {
				return $name;
			}

			$calcresult = '';
			foreach ($this->inputs as $fieldval) {
				$val = trim( rgar( $entry, $fieldval['id'] ) );
				$calcresult .= ! empty( $calcresult ) && ! empty( $val ) ? ' ' . $val : $val;
			}

			return $calcresult;
		} else {

			return rgar( $entry, $input_id );
		}
	}


	/**
	 * Returns the field admin buttons for display in the form editor.
	 *
	 * @return string
	 */
	public function get_admin_buttons() {

		$duplicate_field_link = '';
		$delete_field_link = "<a class='field_delete_icon' id='gfield_delete_{$this->id}' title='" . esc_attr__( 'click to delete this field', 'gravityforms' ) . "' href='#' onclick='DeleteField(this); return false;' onkeypress='DeleteField(this); return false;'><i class='fa fa-times fa-lg'></i></a>";

		$delete_field_link = apply_filters( 'gform_delete_field_link', $delete_field_link );
		$field_type_title  = esc_html( GFCommon::get_field_type_title( $this->type ) );

		$is_form_editor  = $this->is_form_editor();
		$is_entry_detail = $this->is_entry_detail();
		$is_admin        = $is_form_editor || $is_entry_detail;

		$admin_buttons = $is_admin ? "<div class='gfield_admin_icons'><div class='gfield_admin_header_title'>{$field_type_title} : " . esc_html__( 'Field ID', 'gravityforms' ) . " {$this->id}</div>" . $delete_field_link . $duplicate_field_link . "<a class='field_edit_icon edit_icon_collapsed' title='" . esc_attr__( 'click to expand and edit the options for this field', 'gravityforms' ) . "'><i class='fa fa-caret-down fa-lg'></i></a></div>" : '';

		return $admin_buttons;
	}


}

// Registers the Name field with the field framework.
// GF_Fields::register( new GF_Field_GoogleAnalytics_Values() );
