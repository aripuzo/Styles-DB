<?php

namespace App\Utils;

class Recommendation{

    public static function sim_distance($prefs, $person1, $person2) {
	    if(!array_key_exists($person1, $prefs) || !array_key_exists($person2, $prefs))
	        return 0;
	    if(count(array_intersect_key($prefs[$person1], $prefs[$person2])) === 0) 
	        return 0;
	    $sumOfSquares = 0;
	    foreach($prefs[$person1] as $item => $value) {
	        if(array_key_exists($item, $prefs[$person2])) {
	            $sumOfSquares += pow($value - $prefs[$person2][$item], 2);
	        }
	    }
	    return 1/(1+$sumOfSquares);
	}

	public static function setDefault(array &$array, $key, $default = 'None'){
	    if(!array_key_exists($key, $array)){
	       $array[$key] = $default;
	    }

	    return $array[$key];
	}
	 
	public static function sim_pearson($prefs, $p1, $p2){
		$sample = array();
 		foreach($prefs[$p1] as $key => $value)
 			if(array_key_exists($key, $prefs[$p2]))
 				$sample[$key] = 1;
 		$n = count($sample);
 		if ($n == 0) return 0;
 		$p1 = $prefs[$p1];
 		$p2 = $prefs[$p2];
   		$sum1 = 0;$sum2 = 0;$sumSq1 = 0;$sumSq2 = 0;$pSum = 0;
	 	foreach($sample as $x => $value){
	 		$sum1 += $p1[$x];
	        $sum2 += $p2[$x];

	        $sumSq1 += pow($p1[$x],2);
	        $sumSq2 += pow($p2[$x],2);

	        $pSum += $p1[$x] * $p2[$x];
	   	}
	 	$num = $pSum - (($sum1 * $sum2) / $n);
    	$den = sqrt(($sumSq1 - pow($sum1,2)/$n) * ($sumSq2 - pow($sum2,2)/$n));
    	if ($den == 0) return 0;
    	return $num/$den;
	}

	public static function getRecommendations($prefs,$person, $sm = 0){
 		$totals = array();
 		$simSums = array();
 		$rankings = array();
 		foreach ($prefs as $other => $value) {
 			# don't compare me to myself
 			if($other == $person) continue;
 			if($sm == 0)
				$sim = self::sim_pearson($prefs,$person,$other);
			else
				$sim = self::sim_distance($prefs,$person,$other);
 			# ignore scores of zero or lower
 			if($sim<=0) continue;
 			foreach ($prefs[$other] as $item => $value) {
 				# only score styles I haven't scored yet
 			 	if(!array_key_exists($item, $prefs[$person]) || $prefs[$person][$item] == 0){
 					# Similarity * Score
 					self::setdefault($totals, $item, 0);
					$totals[$item] += $prefs[$other][$item] * $sim;
 					# Sum of similarities
 					self::setdefault($simSums, $item, 0);
 					$simSums[$item] += $sim;
 			 	}
 			}
 		}
 		# Create the normalized list
 		foreach ($totals as $item => $value) {
 			$rankings[$item] = ($value/$simSums[$item]);
 		}
 		arsort($rankings);
 		return $rankings;
 	}

 	public static function transformPrefs($prefs){
 		$result = array();
 		foreach ($prefs as $person => $value) {
 		 	foreach ($prefs[$person] as $item => $value) {
 		 		self::setdefault($result, $item, array());
 		 		# Flip item and person
 				$result[$item][$person] = $prefs[$person][$item];
 		 	}
 		}
 		return $result;
 	}

 	public static function topMatches($prefs, $person, $n=5, $sim = 0){
		$scores = array();
		foreach ($prefs as $other => $value) {
			if($other != $person){
				if($sim == 0)
					$scores[$other] = self::sim_pearson($prefs, $person, $other);
				else
					$scores[$other] = self::sim_distance($prefs, $person, $other);
			}
		}
		 # Sort the list so the highest scores appear at the top
		arsort($scores);
		return array_slice($scores, 0, $n);
	}

	public static function calculateSimilarItems($prefs, $n=10){
 		# Create an array of items showing which other items they are most similar to.
 		$result = array();
 		# Invert the preference matrix to be item-centric
 		$itemPrefs = self::transformPrefs($prefs);
 		$c = 0;
 		foreach ($itemPrefs as $item => $value) {
 			$scores = self::topMatches($itemPrefs,$item, $n, 1);
 			$result[$item]=$scores;
 		}
 		return $result;
	}

	public static function getRecommendedItems($prefs, $itemMatch, $user){
		$rankings = array();
		if(isset($prefs[$user])){
		 	$userRatings = $prefs[$user];
		 	$scores = array();
		 	$totalSim = array();
		 	# Loop over items rated by this user
		 	foreach ($userRatings as $item => $rating) {
		 		# Loop over items similar to this one
		 		foreach ($itemMatch[$item] as $item2 => $similarity) {
		 			# Ignore if this user has already rated this item
		 			if(array_key_exists($item2, $userRatings)) continue;
		 			# Weighted sum of rating times similarity
		 			self::setdefault($scores, $item2, 0);
		 			$scores[$item2] += $similarity * $rating;
		 			# Sum of all the similarities
		 			self::setdefault($totalSim, $item2, 0);
		 			$totalSim[$item2] += $similarity;
		 		}
		 	}
		 	# Divide each total score by total weighting to get an average
		 	foreach ($scores as $item => $score) {
		 		if($totalSim[$item] > 0)
		 			$rankings[$item] = ($score/$totalSim[$item]);
		 	}
			arsort($rankings);
		}
	 	return $rankings;
	}
}
