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
  const FILE_COMMENT         = 'comment.json';
  const FILE_STATUS          = 'status.json';
  const IMG_SERVER_URL       = 'https://img.vhiep.com';

  public function __construct() {
		// Do something here
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

  public static function comment() {
    $data_comments = self::readfile(self::FILE_COMMENT);
    $comment       = self::array_rand($data_comments);
    return $comment['content'];
  }

  public static function statusText() {
    $data_status = self::readfile(self::FILE_STATUS);
    $status       = self::array_rand($data_status);
    return $status['content'];
  }

  public static function firstname($work = 1) {
    if ($work == 1) {
      $data_firstnames = self::readfile(self::FILE_FIRSTNAME_1);
    } else {
      $data_firstnames = self::readfile(self::FILE_FIRSTNAME_2);
    }
    $firstname       = self::array_rand($data_firstnames);
    return $firstname['name'];
  }

  public static function lastname() {
    $data_lastnames = self::readfile(self::FILE_LASTNAME);
    $lastname       = self::array_rand($data_lastnames);
    return $lastname['name'];
  }

  public static function middlename() {
    $data_middlenames = self::readfile(self::FILE_MIDNAME);
    $middlename       = self::array_rand($data_middlenames);
    return $middlename['name'];
  }

  public static function fullname() {
    $fullname = self::lastname() . ' ' . self::firstname(rand(1, 2));
    return $fullname;
  }

  public static function username($fullname = null) {
    if (!$fullname) {
      $fullname = self::fullname();
    }
		return strtolower(self::str_clean(self::vnToString($fullname), true));
	}

  public static function email(array $domain = [], string $name = null) {
    $email  = '@';
		if(!$domain) {
			$domain = ['gmail.com', 'outlook.com'];
		}
    if (!$name) {
      $name = self::username();
    }
		$email .= self::array_rand($domain);
		return strtolower($name . $email);
  }

  public static function vnToString($str){
		$unicode = [
			'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
			'd'=>'đ',
			'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
			'i'=>'í|ì|ỉ|ĩ|ị',
			'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
			'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
			'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
			'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
			'D'=>'Đ',
			'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
			'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
			'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
			'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
			'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
		];
		 
		foreach($unicode as $nonUnicode=>$uni){
			$str = preg_replace("/($uni)/i", $nonUnicode, $str);
		}
		 
		return $str;
	}

  public static function str_clean($string, $remove_space = false) {
	   if($remove_space) {
	   		$string = str_replace(' ', '', $string); // Replaces all spaces.
	   }

	   return preg_replace('/[^A-Za-z0-9\- ]/', '', $string); // Removes special chars.
	}

  public static function year($min = 1970) {
		$max = date("Y");
		if($min <= $max) 
			return  mt_rand($min, $max);
		return $max;
	}

	public static function month() {
		$month = mt_rand(1, 12);
		if($month < 10)
			$month = '0'.$month;
		return $month;
	}

	public static function day() {
		$day = mt_rand(1, 28);
		if($day < 10)
			$day = '0'.$day;
		return $day;
	}

  public static function gender($gender = ['male', 'female', 'other']) {
    return self::array_rand($gender);
  }

  public static function avatar(int $w = 300, int $h = 300)
  {
    $avatarIndex = rand(1, 2550);
    return self::IMG_SERVER_URL . '?image=avatars/image%20(' . $avatarIndex . ').jpg&w='. $w . '&h=' . $h;
  }

  public static function image(int $w = 800, int $h = 400)
  {
    $color = [
      'red' => rand(0, 255),
      'green' => rand(0, 255),
      'blue' => rand(0, 255),
    ];
    $text = self::statusText();
    if (strlen($text) > 30) {
      $text = substr($text, 0, 27);
      $text .= "...";
    }
    $path = self::IMG_SERVER_URL . "?w=$w&h=$h&text=$text&red=" . $color['red'] . "&green=" . $color['green'] . "&blue=" . $color['blue'];
    return str_replace(' ', '%20', $path);
  }

}