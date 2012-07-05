<?php


function createTable($sqlArray,$class=NULL,$del=NULL){ //radi tablicu od 2D niza
	if (isset($sqlArray[0])){
		$x=count($sqlArray[0]);
	
		$keys=array_keys($sqlArray[0]);
		echo "<table class=\"{$class}\"><tr>";
		for ($i=0;$i<count($keys);$i++){
			echo "<th>".$keys[$i]."</th>";	
		}//for
		if (isset($del)){echo "<th> </th>";}
		echo "</tr>";
	
		for ($i=0;$i<count($sqlArray);$i++){
			echo "<tr>";
			for ($x=0;$x<count($sqlArray[0]);$x++){
			echo "<td>".$sqlArray[$i][$keys[$x]]."</td>";
			}//for
			if (isset($del)){echo "<td><button class=\"btn delete_btn\">Obriši</button></td>";}	
			echo "</tr>";
		}//for
	
		echo "</table>";
		}//if
	else return false;

}//function


function createTable2($array,$options){
		if (isset($array)){ 
			$table='';
			$showColumns=array();
			if (isset($options['headers'])){
				$headers=explode(',',$options['headers']);
				}//if *******postavlja naslove stupaca
				
			if (isset($options['showColumns'])){
				$showColumns=explode(',',$options['showColumns']);
				}//if ******gleda koji su stupci moraju biti skriveni
		
				
			$table.= "<table id=\"{$options['id']}\" class=\"{$options['class']}\" cellpadding='0' cellspacing='0' border='0' >\n";
			
			//******table head*********
			$table.= "\t<thead>\n";
				$table.= "\t\t<tr>\n";
				if (isset($options['numField'])){$table.= "\t\t\t<th>#</th>\n";}//dodaje polje za numeraciju
				if(isset($headers)){
					foreach($headers as $header){
						$table.= "\t\t\t<th>{$header}</th>\n";
						}//foreach
					
					}//if
				else{
					foreach($showColumns as $key){
						$table.= "\t\t\t<th>{$key}</th>\n";
						}//foreach
					}//else
				$table.= "\t\t</tr>\n";
				$table.= "\t</thead>\n";
				
				//******** table body*******
				$table.= "\t<tbody>\n";
				foreach($array as $tableRow){
					$table.= "\t\t<tr>\n";
					if (isset($options['numField'])){$table.="\t\t\t<td></td>\n";}//dodaje polje za numeraciju
					foreach($showColumns as $key => $tableColumn){
						$table.="\t\t\t<td class=\"{$tableColumn}\">{$tableRow->$tableColumn}</td>\n";
						}//foreach
						
						//******* options ********
						if (isset($options['editBtn']) || isset($options['deleteBtn'])){
							$table.="\t\t\t<td>";
						$table.="<div class=\"btn-group\">";	
						if (isset($options['editBtn'])){
							$table.="<button data-edit=\"{$tableRow->$options['editBtn']}\" type=\"button\" class=\"btn edit_btn\">Uredi</button>";
							}//if
						
						if (isset($options['deleteBtn'])){
							$table.="<button data-delete=\"{$tableRow->$options['deleteBtn']}\" type=\"button\" class=\"btn delete_btn\">Obriši</button>";
						}//if
						if (isset($options['checkBox'])){	
							$table.="<input name=\"alo\" type=\"checkbox\" value=\"{$tableRow->$options['checkBox']}\" class=\" checkbox \" />";
							}//if						
						}//f
						$table.="</div>";
						$table.="</td>\n";
					$table.= "\t\t</tr>\n";
					}//foreach
			$table.= "\t</tbody>\n";
			$table.= "</table>\n";
			
			return $table;
		}//if
	}//function

function napraviUpdateSql($tablica,$stupci){
	if (!is_array($stupci)){
		
		$stupci=explode(',',$stupci);
		
		}//if	
	
		 $sql='UPDATE '.$tablica.' SET ';
		 	foreach($stupci as $stupac){
				$sql=$sql.' '.$stupac.' = ?,';
				}//foreach
		$sql = substr($sql, 0, -1);
		$sql = $sql.' WHERE id = ? ';
		return $sql;
			
}//function

function replaceNull(&$Array,$String){
	foreach ($Array as &$x){
			foreach ($x as &$y){
					if (is_null($x) || $y=='null'){
						$y=$String;
						}
				}
		}
	}
	
function generirajEmail($ime,$prezime){
	
$ime = str_replace(' ','.',$ime);
$prezime = str_replace(' ','.',$prezime);

	$hrv = array( 
		 "Š","š", 
		 "Đ","đ", 
		 "Č","č", 
		 "Ć","ć", 
		 "Ž","ž" 
	); 
	
	$en = array( 
		 "S","s", 
		 "D","d;", 
		 "C","c", 
		 "C","c", 
		 "Z","z" 
	);
	
	$email = str_replace($hrv,$en,strtolower($ime.'.'.$prezime));	
	return $email.'@estudent.hr';

}//function

//PHPBB funkcije za generiranje i provjeru lozinka ****************************************************************************

//PHPBB password hash
 function phpbb_hash($password)
{
	$itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

	$random_state = unique_id();
	$random = '';
	$count = 6;

	if (($fh = @fopen('/dev/urandom', 'rb')))
	{
		$random = fread($fh, $count);
		fclose($fh);
	}

	if (strlen($random) < $count)
	{
		$random = '';

		for ($i = 0; $i < $count; $i += 16)
		{
			$random_state = md5(unique_id() . $random_state);
			$random .= pack('H*', md5($random_state));
		}
		$random = substr($random, 0, $count);
	}

	$hash = _hash_crypt_private($password, _hash_gensalt_private($random, $itoa64), $itoa64);

	if (strlen($hash) == 34)
	{
		return $hash;
	}

	return md5($password);
}




/* Check for correct password
*
* @param string $password The password in plain text
* @param string $hash The stored password hash
*
* @return bool Returns true if the password is correct, false if not.
*/
function phpbb_check_hash($password, $hash)
{
	$itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	if (strlen($hash) == 34)
	{
		return (_hash_crypt_private($password, $hash, $itoa64) === $hash) ? true : false;
	}

	return (md5($password) === $hash) ? true : false;
}


/**
* Generate salt for hash generation
*/
function _hash_gensalt_private($input, &$itoa64, $iteration_count_log2 = 6)
{
	if ($iteration_count_log2 < 4 || $iteration_count_log2 > 31)
	{
		$iteration_count_log2 = 8;
	}

	$output = '$H$';
	$output .= $itoa64[min($iteration_count_log2 + ((PHP_VERSION >= 5) ? 5 : 3), 30)];
	$output .= _hash_encode64($input, 6, $itoa64);

	return $output;
}

/**
* Encode hash
*/
function _hash_encode64($input, $count, &$itoa64)
{
	$output = '';
	$i = 0;

	do
	{
		$value = ord($input[$i++]);
		$output .= $itoa64[$value & 0x3f];

		if ($i < $count)
		{
			$value |= ord($input[$i]) << 8;
		}

		$output .= $itoa64[($value >> 6) & 0x3f];

		if ($i++ >= $count)
		{
			break;
		}

		if ($i < $count)
		{
			$value |= ord($input[$i]) << 16;
		}

		$output .= $itoa64[($value >> 12) & 0x3f];

		if ($i++ >= $count)
		{
			break;
		}

		$output .= $itoa64[($value >> 18) & 0x3f];
	}
	while ($i < $count);

	return $output;
}

/**
* The crypt function/replacement
*/
function _hash_crypt_private($password, $setting, &$itoa64)
{
	$output = '*';

	// Check for correct hash
	if (substr($setting, 0, 3) != '$H$')
	{
		return $output;
	}

	$count_log2 = strpos($itoa64, $setting[3]);

	if ($count_log2 < 7 || $count_log2 > 30)
	{
		return $output;
	}

	$count = 1 << $count_log2;
	$salt = substr($setting, 4, 8);

	if (strlen($salt) != 8)
	{
		return $output;
	}

	/**
	* We're kind of forced to use MD5 here since it's the only
	* cryptographic primitive available in all versions of PHP
	* currently in use.  To implement our own low-level crypto
	* in PHP would result in much worse performance and
	* consequently in lower iteration counts and hashes that are
	* quicker to crack (by non-PHP code).
	*/
	if (PHP_VERSION >= 5)
	{
		$hash = md5($salt . $password, true);
		do
		{
			$hash = md5($hash . $password, true);
		}
		while (--$count);
	}
	else
	{
		$hash = pack('H*', md5($salt . $password));
		do
		{
			$hash = pack('H*', md5($hash . $password));
		}
		while (--$count);
	}

	$output = substr($setting, 0, 12);
	$output .= _hash_encode64($hash, 16, $itoa64);

	return $output;
}

/**
* Return unique id
* @param string $extra additional entropy
*/
function unique_id($extra = 'c')
{
	static $dss_seeded = false;
	global $config;

	$val = $config['rand_seed'] . microtime();
	$val = md5($val);

	return substr($val, 4, 16);
}


?>