<?php
  require "../src/VNFaker.php";
  use Vhiepp\VNDataFaker\VNFaker;

  function convertFileLineToJson($file_url, $key = 'name') {
		$file = fopen($file_url, "r");
    $response_json = [];
		while ($line = fgets($file)) {
      array_push($response_json, [
        $key => trim($line)
      ]);
		}

		return $response_json;
  }
  // echo '<pre>';
  // var_dump(convertFileLineToJson('../test/firstname_1.txt'));
  // echo '</pre>';
/*
  $fp = fopen("../src/data/comment.json", "w");
  fwrite($fp, mb_convert_encoding(json_encode(convertFileLineToJson('../test/comment.txt', 'content')), "UTF-8"));
  fclose($fp); */

  // $test = VNFaker::readfile(VNFaker::FILE_PROVINCES);

  // $tinh = VNFaker::array_rand($test, 2);
  // $quan = VNFaker::array_rand($tinh['districts']);
  // $xa = VNFaker::array_rand($quan['wards']);

  // echo VNFaker::address(1); default
  // echo VNFaker::address(2);
  // echo VNFaker::address(3);

  // $test = VNFaker::readfile(VNFaker::FILE_COLORNAME);

  // echo '<pre>';
  // var_dump($test);
  // echo '</pre>';

echo VNFaker::comment();