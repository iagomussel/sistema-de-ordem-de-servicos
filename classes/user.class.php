<?php
/* classe do usuario */
class User {
	public static $id;
	public static $username;
	public static $salt;
	public static $password;
	public static $user_browser;
	public static $is_user_logged;
	
	
	public function login($username, $password) {
    // Usando definições pré-estabelecidas significa que a injeção de SQL (um tipo de ataque) não é possível. 
		if(!isset($db)){
			$db = Database::conexao();
		}
		if ($stmt = $db->prepare("SELECT id, username, password, salt 
        FROM usuarios
		WHERE username = :username
        LIMIT 1")) {
        $stmt->bindValue('username', $username);  // Relaciona  "$username" ao parâmetro.
        $stmt->execute();    // Executa a tarefa estabelecida.
        // obtém variáveis a partir dos resultados. 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
	
		// faz o hash da senha com um salt exclusivo.
        $password = hash('sha512', $password . $row["salt"]);
        if ($stmt->rowCount() == 1) {
            // Caso o usuário exista, conferimos se a conta está bloqueada
            // devido ao limite de tentativas de login ter sido ultrapassado 
			self::$id = $row["id"];
			if (self::checkbrute() == true) {
                // A conta está bloqueada 
                // Envia um email ao usuário informando que a conta está bloqueada 
                return false;
            } else {
                // Verifica se a senha confere com o que consta no banco de dados
                // a senha do usuário é enviada.
                if ($row["password"] == $password) {
					self:$password = $row["password"];
                    // A senha está correta!
                    // Obtém o string usuário-agente do usuário. 
                    self::$user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // proteção XSS conforme imprimimos este valor
                    $user_id = preg_replace("/[^0-9]+/", "", $row["id"]);
                    $_SESSION['user_id'] = $row["id"];
					// proteção XSS conforme imprimimos este valor 
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                                                                "", 
                                                                $row["username"]);
                    $_SESSION['username'] = $username;
					self::$username = $username;
                    $_SESSION['login_string'] = hash('sha512', 
                              $password . self::$user_browser);
                    // Login concluído com sucesso.
					self::$is_user_logged = true;
                    return true;
                } else {
                    // A senha não está correta
                    // Registramos essa tentativa no banco de dados
                    $now = time();
                    $stmt = $db->prepare("INSERT INTO login_attempts(user_id, time) 
												VALUES (:id, :now)");
					$stmt->bindValue("id",$row["id"]);
					$stmt->bindValue("now",$now);
					$stmt->execute();
					self::$is_user_logged = false;
					return false;
                }	
            }
        } else {
            // Tal usuário não existe.
            return false;
        }
		};
	}
		public function checkbrute() {
			if(!isset($db)){
				$db = Database::conexao();
			}
			// Registra a hora atual 
			$now = time();
		 
			// Todas as tentativas de login são contadas dentro do intervalo das últimas 2 horas. 
			$valid_attempts = $now - (2 * 60 * 60);
		 
			if ($stmt = $db->prepare("SELECT time 
									 FROM login_attempts 
									 WHERE user_id = :id
									AND time > '$valid_attempts'")) {
				$stmt->bindValue(':id', self::$id);
		 
				// Executa a tarefa pré-estabelecida. 
				$stmt->execute();
		 
				// Se houve mais do que 5 tentativas fracassadas de login 
				if ($stmt->rowCount() > 5) {
					return true;
				} else {
					return false;
				}
			}
		}
		function login_check() {
			// Verifica se todas as variáveis das sessões foram definidas 
			if(!isset($db)){
				$db = Database::conexao();
			}
			if (isset($_SESSION['user_id'], 
								$_SESSION['username'], 
								$_SESSION['login_string'])) {
		 
				$user_id = $_SESSION['user_id'];
				$login_string = $_SESSION['login_string'];
				$username = $_SESSION['username'];
		 
				// Pega a string do usuário.
				$user_browser = $_SERVER['HTTP_USER_AGENT'];
		 
				if ($stmt = $db->prepare("SELECT password 
											  FROM usuarios 
											  WHERE id = :i LIMIT 1")) {
					// Atribui "$user_id" ao parâmetro. 
					$stmt->bindValue(':i', $user_id);
					$stmt->execute();   // Execute the prepared query.
					if ($stmt->rowCount() == 1) {
						// Caso o usuário exista, pega variáveis a partir do resultado.                 $stmt->bind_result($password);
						$row = $stmt->fetch();
						$login_check = hash('sha512', $row["password"] . $user_browser);
						if ($login_check == $login_string) {
							// Logado!!!
							return true;
						} else {
							// Não foi logado 
							return false;
						}
					} else {
						// Não foi logado 
						return false;
					}
				} else {
					// Não foi logado 
					return false;
				}
			} else {
				// Não foi logado 
				return false;
			}
		}
		public function can($perm){
			if(self::$is_user_logged === false){
				return false;
			}
			if(!isset($db)){
				$db = Database::conexao();
			}
			if ($stmt = $db->prepare(
			"SELECT  FROM usuarios 
											  WHERE id = :i LIMIT 1")) {  }
		}
}	