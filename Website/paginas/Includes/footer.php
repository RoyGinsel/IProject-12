<footer class="uk-width-1-1">
<h4><a href="#top" class="back-to-top">Back to top</a></h4>
Eenmaal Andermaal is niet aansprakelijk voor (gevolg)schade die voortkomt uit het gebruik van deze site, dan wel uit fouten of ontbrekende functionaliteiten op deze site. Copyright © 2018 IConcepts B.V. Alle rechten voorbehouden.
<br>
</footer>
<?php
//Cookie zetten voor callout
$cookie_name = "Callout";
$cookie_value = date("d-m-Y");
if(!isset($_COOKIE[$cookie_name])){
    setcookie($cookie_name ,$cookie_value,time() + (86400 * 30),"/",null,null,null);
}
?>