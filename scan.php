<?php
// NEKOMiST Web CDN System V1.00

$dir = "files";

// 최상단 폴더를 지정합니다 (기본값: files)

$response = scan($dir);


// 폴더 및 파일을 검색하고 정리

function scan($dir){

	$files = array();

	// 같은 폴더나 파일이 있는지 확인

	if(file_exists($dir)){
	
		foreach(scandir($dir) as $f) {
		
			if(!$f || $f[0] == '.') {
				continue; // 숨긴 파일을 무시합니다
			}

			if(is_dir($dir . '/' . $f)) {

				// 폴더 경로

				$files[] = array(
					"name" => $f,
					"type" => "folder",
					"path" => $dir . '/' . $f,
					"items" => scan($dir . '/' . $f) // 폴더 내 목록을 불러옵니다
				);
			}
			
			else {

				// 이쪽은 파일

				$files[] = array(
					"name" => $f,
					"type" => "file",
					"path" => $dir . '/' . $f,
					"size" => filesize($dir . '/' . $f) // 파일의 용량을 가져옵니다
				);
			}
		}
	
	}

	return $files;
}



// JSON으로 목록을 불러옵니다

header('Content-type: application/json');

echo json_encode(array(
	"name" => "files",
	"type" => "folder",
	"path" => $dir,
	"items" => $response
));
