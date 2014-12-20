<body>
<?php
/**
 * Google Showtime grabber
 * 
 * This file will grab the last showtimes of theatres nearby your zipcode.
 * Please make the URL your own! You can also add parameters to this URL: 
 * &date=0|1|2|3 => today|1 day|2 days|etc.. 
 * 
 * Please download the latest version of simple_html_dom.php on sourceForge:
 * http://sourceforge.net/projects/simplehtmldom/files/
 * 
 * @author Bas van Dorst <info@basvandorst.nl>
 * @version 0.1 
 * @package GoogleShowtime
 */

require_once('showtimes/simple_html_dom/simple_html_dom.php');

$requested4=$_GET['place'];
$sURL = "http://www.google.com/movies?near=".$requested4."&hl=en";
$html = new simple_html_dom();

$html->load_file($sURL);
ob_start(); 

$muv='<pre>';
foreach($html->find('#movie_results .theater') as $div) {
    // print theater and address info
$muv=$muv."Theatre:  ".$div->find('h2 a',0)->innertext."\n";
$muv=$muv."Address: ". $div->find('.info',0)->innertext."\n";

    // print all the movies with showtimes
    foreach($div->find('.movie') as $movie) {
       $muv=$muv."\tMovie:    ".$movie->find('.name a',0)->innertext.'<br />';
      $muv=$muv."\tTime:    ".$movie->find('.times',0)->innertext.'<br />';
    }
    $muv=$muv. "\n\n";
}
$muv=$muv."</pre>";
//ob_get_contents(); 
ob_end_clean(); 
echo $muv;
//file_put_contents('textfiles/file.txt', $muv);  
$html->clear();

?> 
</body>
