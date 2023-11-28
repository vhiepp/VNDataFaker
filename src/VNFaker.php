<?php

namespace Vhiepp\VNDataFaker;

class VNFaker {

  const FILE_PATH_FOLDER     = '/data';
  const FILE_PROVINCES       = 'provinces.json';
  const FILE_FIRSTNAME_1     = 'firstname_1.json';
  const FILE_FIRSTNAME_2     = 'firstname_2.json';
  const FILE_LASTNAME        = 'lastname.json';
  const FILE_MIDNAME         = 'midname.json';
  const FILE_COMPANY         = 'company.json';
  const FILE_COLORNAME       = 'color_name.json';

  public function __construct() {
		// Do something here
	}

  public static function test() {
    return "Test...";
  }

  public static function readfile($file_path) {
		$file_content = file_get_contents(__DIR__ . self::FILE_PATH_FOLDER . '/' . $file_path);
    $json_content = json_decode($file_content, true);
		return  $json_content;
	}

  public static function array_rand(array $items, $num = 1, $array = true, $glue = ',') {
		$return_value = [];
		if($num > 1) {
			for($i = 0; $i < $num; $i++) {
			  array_push($return_value, $items[array_rand($items)]);
			}
			if($array) {
				return $return_value;
			}
			return implode($glue, $return_value);
		}
		return mb_convert_encoding($items[array_rand($items)], "UTF-8");
	}

  public static function address($depth = 1) {
    $data_address = self::readfile(self::FILE_PROVINCES);
    $province     = self::array_rand($data_address);
    $str_response = $province['name'];
    if ($depth > 1) {
      $district     = self::array_rand($province['districts']);
      $str_response = $district['name'] . ', ' . $str_response;
    }
    if ($depth > 2) {
      $ward         = self::array_rand($district['wards']);
      $str_response = $ward['name'] . ', ' . $str_response;
    }
    return $str_response;
	}

  

}