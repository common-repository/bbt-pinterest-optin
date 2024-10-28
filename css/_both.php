<?php 
///////////// EXIT IF ACCESSED DIRECTLY /////////////
if ( ! defined( 'ABSPATH' ) ) exit;
///////////// END EXIT IF ACCESSED DIRECTLY /////////////
?>
<style type="text/css">
.bbt-follow-slide {
display:none;
position:fixed;
bottom:12%;
right:0;
width:300px;
height:auto;
font-size:30px;
color:white;
background-color:transparent;
padding:0;
opacity:100;
z-index:10000;
}.bbt-closePin{
  position:absolute;
  top:10px;
  right:2%;
  float:right;
  background-color:#000000;
  border-radius:4px;
  padding:2px 8px 5px 8px;
  color:#fff;
  font-size:15px;
  font-family:Arial, "Helvetica Neue", Helvetica, sans-serif;
  z-index:10001;
}.bbt-pinterest-powered-by {
		display:none !important;
		right:-100%;
		opacity:0;
}@media only screen and (max-width: 767px) {
.bbt-follow-slide {
	display:none !important;
	right:-100%;
	opacity:0;
	z-index:-1;
	}.bbt-closePin {
	display:none !important;
	right:-100%;
	z-index:-1;
	}.bbt-pinterest-powered-by {
		display:none !important;
		right:-100%;
		opacity:0;
	}
}
</style>