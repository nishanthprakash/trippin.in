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

require_once('simple_html_dom/simple_html_dom.php');

$html = new simple_html_dom();
$html->load_file('http://www.google.com/movies?near=mumbai&hl=en');

print '<pre>';
foreach($html->find('#movie_results .theater') as $div) {
    // print theater and address info
    print "Theate:  ".$div->find('h2 a',0)->innertext."\n";
    print "Address: ". $div->find('.info',0)->innertext."\n";

    // print all the movies with showtimes
    foreach($div->find('.movie') as $movie) {
        print "\tMovie:    ".$movie->find('.name a',0)->innertext.'<br />';
        print "\tTime:    ".$movie->find('.times',0)->innertext.'<br />';
    }
    print "\n\n";
}

// clean up memory
$html->clear();

?> 
