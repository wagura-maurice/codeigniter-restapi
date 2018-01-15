<?php
    /**
    * CodeIgniter Rest Controller
    * A fully RESTful server implementation for CodeIgniter using one library, one config file and one controller.
    *
    * @package         CodeIgniter
    * @subpackage      Helpers
    * @category        Helpers
    * @author          Wagura Maurice
    * @license         MIT
    * @link            https://github.com/wagura-maurice/codeigniter-restapi
    * @version         1.0.0
    */
function remove_unknown_fields($raw_data, $expected_fields) {
	$new_data = array();
	foreach ($raw_data as $field_name => $field_value) {
		if ($field_value != "" && in_array($field_name, array_values($expected_fields))) {
			$new_data[$field_name] = $field_value;
		}
	}

	return $new_data;
}

?>