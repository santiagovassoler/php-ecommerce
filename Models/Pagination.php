<?php

class Pagination {

  var $data;

  function paginate($values, $per_page)
  {
    $total = count($values);

    if(isset($_GET['page'])){
      $current_page = $_GET['page'];
    }else{
      $current_page=1;
    }

    $count = ceil($total / $per_page);
    $param1 = ($current_page - 1) * $per_page;
    $this->data = array_slice($values, $param1, $per_page);

    for ($i=1; $i<=$count; $i++){
      $numbers[] = $i;
    }
    return $numbers;
  }

  function fetchResult()
  {
    $result_values = $this->data;
    return $result_values;
  }
}
?>
