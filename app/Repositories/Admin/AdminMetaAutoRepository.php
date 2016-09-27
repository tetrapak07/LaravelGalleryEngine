<?php namespace App\Repositories\Admin;

use App\Core\EloquentRepository;
use App\Repositories\AlbomRepository;
use Input;
use App\Repositories\ImageRepository;
use App\Repositories\Admin\AdminImageRepository;

/**
 * Admin Meta Auto Repository
 *
 *
 * @package   Repositories
 * @author    Den
 */
class AdminMetaAutoRepository extends EloquentRepository {

public function __construct( AlbomRepository $albom,
  ImageRepository $image,
  AdminImageRepository $imageAdmin) {
    $this->albom = $albom;
    $this->image = $image;
    $this->imageAdmin = $imageAdmin;
}

 public function metaStart() {
  $alboms = $this->albom->getAllVisibleAlboms();
  $data['alboms'] = $alboms;
  return $data;
 }

 private function trimArr($arr) {
   foreach ($arr as &$val) {
          $val = trim($val);
   }
   return $arr;
 }

 public function storeNewMeta() {
   set_time_limit(0);
   ini_set('max_execution_time', 0);
   $input = array_except(Input::all(), ['_token']);
   $countTitleParts = (int) $input['title_word_count'];
   $albomId = (int) $input['albom'];
   $ids = [];
   $allCounts = 0;
   $testGenFlag = false;
   $allAlbomsFlag = false;

   if (isset($input['allAlbomsGen'])) {
     $allAlbomsFlag = (bool) $input['allAlbomsGen'];
   }

   if (isset($input['test'])) {
     $testGenFlag = (bool) $input['test'];
   }

   if($testGenFlag) {
      echo '$albomId: '.$albomId.'; $testGenFlag: '.$testGenFlag;

    }

   $descriptionBegin = explode(',',$input['word_descr_begin']);
   $descriptionBegin = $this->trimArr($descriptionBegin);
   $descriptionEnd = explode(',',$input['word_descr_end']);
   $descriptionEnd = $this->trimArr($descriptionEnd);
   $contentEnd = explode(',',$input['word_content_end']);
   $contentEnd = $this->trimArr($contentEnd);
   $part = [];

   	for($index = 1; $index <= $countTitleParts; $index++) {

        $partExplode = explode(',',$input['word_title'.$index]);
        $partExplode = $this->trimArr($partExplode);
        array_push($part, $partExplode);

        if($testGenFlag) {
        echo '<br>title'.$index.': '.$input['word_title'.$index];
        }

      }

    if($testGenFlag) {
      echo '<br>description Begin: '.$input['word_descr_begin'];
      echo '<br>description End: '.$input['word_descr_end'];
      echo '<br>content End: '.$input['word_content_end'];
    }

    $combinations = $this->combinations($part);
    shuffle($combinations);
    $imagesWithoutMeta = $this->image->getWhereEmptyMeta($albomId, count($combinations), $allAlbomsFlag);

    foreach ($imagesWithoutMeta as $imagesWithoutMetaArr) {
      $imageId = $imagesWithoutMetaArr['id'];
      array_push($ids, $imageId);
    }
    if ($testGenFlag) {
          echo '<br>Ids:';
          print_r($ids);
        }

    if ((count($imagesWithoutMeta)>=1)AND(count($combinations)>=count($imagesWithoutMeta))) {
    foreach ($combinations as $key => $val) {
      if ($testGenFlag) {
          echo '<br>';
        }
      $title = implode(' ', $val);
       if ($testGenFlag) {
          echo '<br>$title: '.$title ;
        }
      if (($descriptionBegin != '')&&($descriptionEnd != '')) {
        $descr = $descriptionBegin[array_rand($descriptionBegin)].' '.$title.' '.$descriptionEnd[array_rand($descriptionEnd)];
        if ($testGenFlag) {
          echo '<br>$descr: '.$descr ;
        }
      } else if (($descriptionBegin != '')&&($descriptionEnd == '')) {
        $descr = $descriptionBegin[array_rand($descriptionBegin)].' '.$title;
        if ($testGenFlag) {
          echo '<br>$descr: '.$descr ;
        }
      } else if (($descriptionBegin == '')&&($descriptionEnd != '')) {
        $descr = $title.' '.$descriptionEnd[array_rand($descriptionEnd)];
        if ($testGenFlag) {
          echo '<br>$descr: '.$descr ;
        }
      } else {
        $descr = $title;
        if ($testGenFlag) {
          echo '<br>$descr: '.$descr ;
        }
      }

      if ($contentEnd != '') {
        $content = $descr.' '.$contentEnd[array_rand($contentEnd)];
       if ($testGenFlag) {
          echo '<br>$content: '.$content ;
        }
      } else {
        $content = $descr;
        if ($testGenFlag) {
          echo '<br>$content: '.$content ;
        }
      }
      if ($testGenFlag) {
      echo '<br>';
      }

      $existFlag = $this->image->isExistThisMeta($albomId, $title, $descr, $allAlbomsFlag);
      if ((isset($ids[$key]))AND($testGenFlag)) {
       echo '$imageId: '.$ids[$key].'; ';
       echo '<br>$existFlag: '.$existFlag;
      }

      if (!$existFlag) {

        $inp = ['title' =>$title,
                'description' =>$descr,
                'content' => $content,
                'visible' => 1,
                'keywords' => '',
                'notes' => '',
                'alt_text' => '',
                'caption' => '',
               ];
        $r = false;

        if ((isset($ids[$key]))AND(!$testGenFlag)) {
        $r = $this->imageAdmin->updateImageMeta($ids[$key], $inp);
        }

        if ($r) {
        $allCounts++;

        }

      }

    }
    } else {
      $data = ['status' => 'error', 'error_message' => 'Image meta change error - No Images!'];
    }

    if ($testGenFlag) {
      $allCounts = count($imagesWithoutMeta);
      echo '<br>$allCounts: '.$allCounts;
      print_r($ids);
    }

     if ($allCounts>0) {
      $data = ['status'=>'ok','message'=>'Image meta change success! Count: '.$allCounts];
    } else {
      $data = ['status' => 'error', 'error_message' => 'Image meta change error or No Images!'];
    }
    if (!$testGenFlag) {
    $alboms = $this->albom->getAllVisibleAlboms();
    $data['alboms'] = $alboms;
    $data['oldAlbomId'] = $albomId;
    return $data;
    } else {
      $data['oldAlbomId'] = $albomId;
      print_r($data);
      echo '<br><a href="/admin/meta_auto">Back</a>';
      exit;
    }

 }

 private function combinations($arrays, $N = -1, $count = false, $weight = false) {

    if ($N == -1) {

      $arrays = array_values($arrays);
      $count = count($arrays);
      $weight = array_fill(-1, $count + 1, 1);
      $Q = 1;

      foreach ($arrays as $i => $array) {
        $size = count($array);
        $Q = $Q * $size;
        $weight[$i] = $weight[$i - 1] * $size;
      }

      $result = array();
      for ($n = 0; $n < $Q; $n++)
        $result[] = $this->combinations($arrays, $n, $count, $weight);

      return $result;
    } else {
 
      $sostArr = array_fill(0, $count, 0);

      $oldN = $N;

      for ($i = $count - 1; $i >= 0; $i--) {
        $sostArr[$i] = floor($N / $weight[$i - 1]);
        $N = $N - $sostArr[$i] * $weight[$i - 1];
      }

      $result = array();
      for ($i = 0; $i < $count; $i++)
        $result[$i] = $arrays[$i][$sostArr[$i]];

      return $result;
    }
  }

}

