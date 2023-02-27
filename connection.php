<?php
/**
 * Display friendly error message
 *
 * See there's type declaration in both the function arguments and return data type
 * - this is not covered in the lectures, but it's good to be considered (also make IDEs like PHPStorm happy)
 * (well we did discuss that PHP is a weakly-typed language, but it doesn't mean it cannot be specifically typed)
 * https://www.php.net/manual/en/language.types.declarations.php
 *
 * @param string $e Error Message
 * @return string Formatted error message
 */
function friendlyError(string $e): string {
    // PHP supports heredoc format for containing large paragraph of string
    // https://www.php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc
    return <<<END
    <div class="error-message center">
    <b>Error</b><br>
    Please contact system administrator.
    <pre>Error message: <br>{$e}</pre>
    </div>
    END;
}

// Database connection
$db_host = "localhost";
$db_username = "fit2104";
$db_passwd = "fit2104";
$db_name = "fit2104_a2";
$dsn = "mysql:host=$db_host;dbname=$db_name";
$dbh = new PDO($dsn,$db_username,$db_passwd);
