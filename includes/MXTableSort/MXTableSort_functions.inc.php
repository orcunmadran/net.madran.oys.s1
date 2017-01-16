<?
// Get Current Sort
function getCurrentSort($rsName) {
  $value = "";
  if (isset($_GET['order_'.$rsName])) {
    $value = $_GET['order_'.$rsName];
  } else {
    $orderParam = "orderParam_" . $rsName;
    global $$orderParam;
    $value = $$orderParam;
  }
  return $value;
}

//Get Sort Icon Function
function getSortIcon($rsName,$column){
  $value = getCurrentSort($rsName);
  if ($value == $column) {
    return '(A-Z)';
  } elseif ($value == $column.' DESC') {
    return '(Z-A)';
  }
}

//Get Sort Link Function
function getSortLink($rsName,$column){
  global $HTTP_SERVER_VARS;
  $value = getCurrentSort($rsName);
  $paramVal = $column;  
  if($value == $column){
  	$paramVal .= " DESC";
  }
  if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '') {
	  $ret = MXTableSort_replaceParam($_SERVER['QUERY_STRING'],"order_".$rsName, $paramVal);
  } else {
	  $ret = "order_".$rsName.'='.urlencode($paramVal);
  }
  return $HTTP_SERVER_VARS["PHP_SELF"].'?'.$ret;
  }
  
function MXTableSort_replaceParam($qstring, $paramName, $paramValue = null) {
	$arr = explode('&',$qstring);
	foreach($arr as $key=>$value) {
		$tmpArr = explode('=',$value);
		if ($tmpArr[0] == $paramName) {
			unset($arr[$key]);
			break;
		}
	}
	if ($paramValue !== null) {
		$arr[] = $paramName.'='.urlencode($paramValue);
	}
	$ret = implode('&',$arr);
  return $ret;
}


?>