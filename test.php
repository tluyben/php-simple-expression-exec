<?php

 require_once("ExpressionExec.php");

 echo execExpr("1+1")."\n";
 echo execExpr("2*5")."\n"; 
 echo execExpr("2*5+1")."\n"; 
 echo execExpr("2*(5+1)")."\n"; 
 echo execExpr("1+5*2")."\n"; 
 echo execExpr("\"hello\"+\" world\"")."\n";
 echo execExpr("20+\" world\"")."\n";
 echo execExpr("\"hello\"+42")."\n";
 echo execExpr("1+a*b", array('a'=>10, 'b'=>14))."\n"; 
 echo execExpr("-1+3")."\n";
 echo execExpr("\"What is left: \"+(a-b)", array('a'=>5, 'b'=>3))."\n";
 echo execExpr("-50+5*10")."\n";
 echo execExpr("5-(-10)")."\n";
 echo execExpr("5-(-1*a)", array('a'=>50))."\n";

 echo execExpr("\"hello world\":5")."\n"; 
 echo execExpr("\"hello world\":(-5)")."\n"; 
 echo execExpr("\"hello world\":(-5):3")."\n"; 
 echo execExpr("a:(-5):3", array('a'=>"hello world"))."\n"; 
?>
