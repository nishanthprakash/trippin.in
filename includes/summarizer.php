<?php


if (!class_exists('PorterStemmer')){
	require_once 'porter_stemmer.php';
}

class Summarizer {
	var $word_stats;
	var $stopwords;
	
	
	function Summarizer(){
		global $default_stopwords;
		$this->word_stats = array();
		$this->stopwords = $default_stopwords; 
	}
	
	
	function summary($text, $percent=0.2, $min_sentences=1, $max_sentences=0){
		$sentences = $this->sentence_tokenize($text);
		$sentence_bag = array();
		
		for($i=0; $i<count($sentences); $i++){
			$words = $this->word_tokenize($sentences[$i]);
			$word_stats = array();
			foreach ($words as $word){

				if (in_array($word, $this->stopwords)) continue;
				//stem
				$word = PorterStemmer::Stem($word);

				if (in_array($word, $this->stopwords)) continue;
				

				if (!isset($word_stats[$word])) {
					$word_stats[$word]=1;
				} else {
					$word_stats[$word]++;
				} 
				

				if (!isset($this->word_stats[$word])) {
					$this->word_stats[$word]=1;
				} else {
					$this->word_stats[$word]++;
				} 
			}
			
			$sentence_bag[] = array(
				'sentence' => $sentences[$i],
				'word_stats' => $word_stats,
				'ord' => $i
			);
		}
		

		arsort($this->word_stats);

		$this->word_stats = array_slice($this->word_stats,0,20);
		
		for($i=0; $i<count($sentence_bag); $i++){
			$rating = $this->calculate_rating($sentence_bag[$i]['word_stats']);
			$sentence_bag[$i]['rating'] = $rating;
		}
		

		usort($sentence_bag, array(&$this, 'cmp_arrays_rating'));
		

		if ($max_sentences==0) $max_sentences = count($sentence_bag);
		$summary_count = min(
			$max_sentences, 
			max( 
				min($min_sentences, count($sentence_bag)) , 
				round($percent*count($sentence_bag))
			)
		);
		if ($summary_count<1) $summary_count = 1;
		

		

		$summary_bag = array_slice($sentence_bag, -$summary_count);
				

		usort($summary_bag, array(&$this, 'cmp_arrays_ord'));
		
		$summary_sentences = array();
		foreach($summary_bag as $sentence){
			$summary_sentences[] = $sentence['sentence'];
		}
		
		return $summary_sentences;
	}
	
	function cmp_arrays_rating($a, $b){
		return $this->cmp_arrays($a, $b, 'rating');
	}
	
	function cmp_arrays_ord($a, $b){
		return $this->cmp_arrays($a, $b, 'ord');
	}
	
	function cmp_arrays($a, $b, $key){
		if (is_int($a[$key]) || is_float($a[$key])){
			return floatval($a[$key])-floatval($b[$key]);
		} else {
			return strcmp(strval($a[$key]), strval($b[$key]));
		}
	}
	
	function sentence_tokenize($text){

		if (preg_match_all('/["\']*.+?([.?!\n\r]+["\']*\s+|$)/si', $text, $matches, PREG_SET_ORDER)){
			$rez = array();
			foreach ($matches as $match){
				array_push($rez, trim($match[0]));
			}
			return $rez;
		} else { 
			return array($text);
		}
	}
	
	function word_tokenize($sentence){

		$words = preg_split('/[\'\s\r\n\t$]+/', $sentence);
		$rez = array();
		foreach($words as $word){
			$word = preg_replace('/(^[^a-z0-9]+|[^a-z0-9]$)/i','', $word);
			$word = strtolower($word);
			if (strlen($word)>0)
				array_push($rez, $word);
		}
		return $rez;
	}
	
	function calculate_rating($sentence_words){

		$rating = 0;
		foreach ($sentence_words as $word => $count){
			if (!isset($this->word_stats[$word])) continue;
			$word_rating = $count * $this->word_stats[$word];
			$rating += $word_rating;
		}
		return $rating;
	}

}


$default_stopwords = array(
'--', '-', 'a', 'about', 'again', 'all', 'along', 'almost', 'also', 'always', 'am', 'among', 'an', 'and',
 'another', 'any', 'anybody', 'anything', 'anywhere', 'apart', 'are', 'around', 'as', 'at', 'be', 'because',
 'been', 'before', 'being', 'between', 'both', 'but', 'by', 'can', 'cannot', 'comes', 'could', 'couldn', 'did',
 'didn','different', 'do', 'does', 'doesn', 'done', 'don', 'down', 'during', 'each', 'either', 'enough', 'etc',
 'even', 'every', 'everybody', 'everything', 'everywhere', 'except', 'few', 'final', 'first', 'for', 'from',
 'get', 'go', 'goes', 'gone', 'good', 'got', 'had', 'has', 'have', 'having', 'he', 'hence', 'her', 'him', 'his',
 'how', 'however', 'i', 'i.e', 'if', 'in', 'initial', 'into', 'is', 'isn', 'it', 'its', 'it', 'itself', 'just',
 'last','least', 'less', 'let', 'lets', 'let\'s', 'like', 'lot', 'made', 'make', 'many', 'may', 'maybe', 'me',
 'might', 'mine', 'more', 'most', 'Mr', 'much', 'must', 'my', 'near', 'need', 'next', 'niether', 'no', 'nobody',
 'nor', 'not', 'nothing', 'now', 'nowhere', 'of', 'off', 'often', 'oh', 'ok', 'okay', 'on', 'once', 'one',
 'only', 'onto', 'or', 'other', 'our', 'ours', 'out', 'over', 'own', 'perhaps', 'previous', 'quite', 'rather',
 're', 'really', 's', 'said', 'same', 'say', 'see', 'seems', 'several', 'shall', 'she', 'should',
 'shouldn\'t', 'since', 'so', 'some', 'somebody', 'something', 'somewhere', 'still', 'stuff', 'such', 'than',
 't', 'that', 'the', 'their', 'theirs', 'them', 'then', 'there', 'these', 'they', 'thing', 'things', 'this',
 'those', 'through', 'thus', 'to', 'too', 'top', 'two', 'under', 'unless', 'until', 'up', 'upon', 'us',
 'use', 'v', 've', 'very', 'want', 'was', 'we', 'well', 'went', 'were', 'what', 'when', 'where', 'which',
 'while', 'who', 'whom', 'why', 'will', 'with', 'without', 'won', 'would', 'x', 'yes', 'yet', 'you', 'you',
 'your', 'yours', 'll', 'm', 'shouldn', 'won\'t', 'hadn'  
 );
 

?>