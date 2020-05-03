<?php
/***
 * Simple (no precedence rules besides ()) expression parser & executor which can safely be embedded into software. 
 */ 

 function _execOp($op, $a, $b) {
  if ($b[0]<0) { // error
   return $b; 
  }

  switch($op) {
   case '+':
    if (is_numeric($a[1]) && is_numeric($b[1]))
     $b[1] = $a[1] + $b[1]; 
    else 
     $b[1] = strval($a[1]) . strval($b[1]); 
    break; 
   case '-':
    $b[1] = $a[1] - $b[1]; 
    break; 
   case '*':
    $b[1] = $a[1] * $b[1]; 
    break; 
   case '/':
    if ($b[1] == 0) {
     return array(-1, "Division by zero");
    }
    $b[1] = $a[1] / $b[1]; 
    break; 
   case ':':
    if (is_numeric($a[1]) || !is_numeric($b[1]))
     return array(-1, "Substring ':' requires a string and a number."); 
    if ($b[1]<0) 
     $b[1] = substr($a[1], strlen($a[1])+$b[1]);
    else 
     $b[1] = substr($a[1], 0, $b[1]);
    break; 
  }

  return $b; 
 } 
 function _resLit($lit, $op, $result, $args) {
  if ($lit) {
   if (array_key_exists($lit, $args)) $lit = $args[$lit]; // input lookup
   if ($op) {
    $result = _execOp($op, $result, array($result[0], $lit));
   } else {
    $result[1] = $lit; 
   }
  }
  return $result;
 }

 function _execExpr($e, $args, $i, $r) {
  $result = array($i, null); 
  $op = null; 
  $lit = ""; 
  $is = false; 

  while($result[0]<strlen($e)) {
   $c = $e[$result[0]]; 

   if ($c=='"') $is = !$is; 
  
   if (in_array($c, array('(',')',' ','+','-','*','/', ':', '"'))) {
     if (!$is) {
      $result = _resLit($lit, $op, $result, $args); 
      if ($lit) {
       $lit = ""; 
       $op = null; 
      }
     }
   }

   if ($is) {
    if ($c != '"') $lit .= $c; 
   } else switch($c) {
    case '(':
     $result = _execOp($op, $result, _execExpr($e, $args, $result[0]+1, true)); 
     break;
    case ')': 
     return $result; 
    case '+':
    case '-':
    case '*':
    case '/':
    case ':':
     if ($result[1] === null) {
      if ($c=='-') {
       $lit.=$c;
      } else 
       $result = array(-1, "Syntax error: cannot have a '$c' operation without a left-had side");
     } else {
      $op = $c; 
     }
     break; 
    default: 
     if ($c != '"') $lit .= $c;
   }

   if ($result[0]<0) {
    break;
   }

   $result[0]++; 
  }

  return $result;     
 }

 function execExpr($e, $args = array()) {
  return _execExpr($e." ", $args, 0, false)[1];
 }
?>
