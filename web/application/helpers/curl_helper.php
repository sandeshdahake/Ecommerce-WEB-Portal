<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	function executeParallelCallOuts($nodes){
		$node_count = count($nodes);

		if($node_count > 0){
			// node - list of urls
			$curl_arr = array();
			$master = curl_multi_init();

			for($i = 0; $i < $node_count; $i++)
			{
				//var_dump($nodes[$i]["headersArray"]);
				$url = $nodes[$i]["url"];
				$curl_arr[$i] = curl_init($url);
				curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
				if($nodes[$i]["headersArray"] != NULL){
					curl_setopt($curl_arr[$i], CURLOPT_HTTPHEADER, $nodes[$i]["headersArray"]);
				}
				curl_setopt($curl_arr[$i], CURLOPT_SSL_VERIFYPEER, false);
				curl_multi_add_handle($master, $curl_arr[$i]);
			}

			do {
				curl_multi_exec($master, $running);
			} while($running > 0);

			$results = array();
			for($i = 0; $i < $node_count; $i++){
				 $curlError = curl_error($curl_arr[$i]);
				if($curlError){
					$results[$nodes[$i]["Name"]] = null;
				}
				else $results[$nodes[$i]["Name"]] = curl_multi_getcontent( $curl_arr[$i]  );
			}
			return $results;
		}
		return null;
	}
?>