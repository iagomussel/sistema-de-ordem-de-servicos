<?php
function validar_cpf($cpf)
{
	$cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
	// Valida tamanho
	
	
	if (strlen($cpf) == 11) ///se cpf
	{
	// Calcula e confere primeiro dígito verificador
	for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
		$soma += $cpf{$i} * $j;
	$resto = $soma % 11;
	if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
		return false;
	// Calcula e confere segundo dígito verificador
	for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
		$soma += $cpf{$i} * $j;
	$resto = $soma % 11;
	return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
	
	
	} else if(strlen($cpf) == 14 ){ /// se cnpj
		// Valida primeiro dígito verificador
		for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
		{
			$soma += $cpf{$i} * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		$resto = $soma % 11;
		if ($cpf{12} != ($resto < 2 ? 0 : 11 - $resto))
			return false;
		// Valida segundo dígito verificador
		for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
		{
			$soma += $cpf{$i} * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		$resto = $soma % 11;
		return $cpf{13} == ($resto < 2 ? 0 : 11 - $resto);
	} else {
		return false;
	}
}
function validar_cnpj($cnpj)
{
	$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

	// Valida tamanho
	if (strlen($cnpj) != 14)
		return false;

	// Valida primeiro dígito verificador
	for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
	{
		$soma += $cnpj{$i} * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}

	$resto = $soma % 11;

	if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
		return false;

	// Valida segundo dígito verificador
	for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
	{
		$soma += $cnpj{$i} * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}

	$resto = $soma % 11;

	return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
}


function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // Estamos interessados somente em links relacionados provenientes de $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

function sec_session_start() {
    $session_name = 'sec_sytech';   // Estabeleça um nome personalizado para a sessão
    $secure = SECURE_LOGIN;
    // Isso impede que o JavaScript possa acessar a identificação da sessão.
    $httponly = true;
    // Assim você força a sessão a usar apenas cookies. 
   if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Obtém params de cookies atualizados.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Estabelece o nome fornecido acima como o nome da sessão.
    session_name($session_name);
    session_start();            // Inicia a sessão PHP 
    session_regenerate_id();    // Recupera a sessão e deleta a anterior. 
}
function sanitizeString($valor) {
	$str = str_replace(' ','_',preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim(" ".$valor))));
	$str = $str = preg_replace('/[^a-z0-9]/i', '_', $str);
    $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)

    return  strtolower($str);

}
?>