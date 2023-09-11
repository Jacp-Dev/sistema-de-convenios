<?php


class consultasSQL {
    public static function limpiarCadena($valor) {
        // Patrones de búsqueda para eliminar contenido no deseado
        $patrones = [
            "/<script[^>]*>/i",          // Etiquetas de script abiertas
            "/<\/script>/i",             // Etiquetas de script cerradas
            "/<script[^>]*src/i",        // Etiquetas de script con atributo src
            "/<script[^>]*type/i",       // Etiquetas de script con atributo type
            "/SELECT \* FROM/i",         // Consultas SELECT *
            "/DELETE FROM/i",            // Consultas DELETE FROM
            "/INSERT INTO/i",            // Consultas INSERT INTO
            "/--/",                      // Comentarios SQL (--)
            "/\^/",                      // Símbolo ^
            "/\[/",                      // Corchetes abiertos
            "/\]/",                      // Corchetes cerrados
            "/\\\\/",                    // Caracter de escape \
            "/=/",                       // Signo igual =
            "/==/"                       // Doble signo igual ==
        ];

        // Realizar las sustituciones utilizando expresiones regulares
        $valor = preg_replace($patrones, "", $valor);

        // Escapar caracteres especiales para su uso seguro en consultas SQL
        $valor = addslashes($valor);

        return $valor;
    }

    public static function CleanStringText($val) {
        // Limpiar la cadena de texto aplicando la función limpiarCadena
        $datos = consultasSQL::limpiarCadena($val);
        return $datos;
    }
}
?>