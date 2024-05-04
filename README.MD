Para garantizar el correcto funcionamiento del sistema desde el hosting de debe seguir los siguientes pasos.
1. Crear la caperta raíz sistema-de-convenios y 
dentro de esta agregar las capertas con sus archivos y los archivos que no están en carpetas.
.............................................................................................................
2. Editar en el archivo conexion.php con los datos del servidor los siguiente valores.
$servername = "localhost";
$username = "root";
$password = "";

3. Configuración de Correo para Sistema de Convenios
Ingresar a API, luego a utilities abrir el archivo send-mail.php dentro de este archivo
 se encuentran las contantes configuración para el envio de correo basado en el servidor 
 de pruebas mailtrap de la siguiente manera: 


Configuración de Constantes
Dentro del   archivo send-mail.php, debes configurar ciertas constantes que se utilizarán para la configuración del servidor de correo. Asegúrate de ajustarlas según tus necesidades:

define("EMAIL_HOST", "sandbox.smtp.mailtrap.io"); // Host del servidor de correo
define("EMAIL_USERNAME", "tu_usuario_de_mailtrap"); // Nombre de usuario del correo (Mailtrap en este caso)
define("EMAIL_PASS", "tu_contraseña_de_mailtrap"); // Contraseña del correo (Mailtrap en este caso)
define("EMAIL_SMTPSECURE", "tls"); // Tipo de seguridad SMTP (tls, ssl, o ninguno)
define("EMAIL_PORT", 2525); // Puerto SMTP
define("EMAIL_ADMIN", 'convenios@correo.com'); // Dirección de correo electrónico del administrador
Asegúrate de proporcionar los valores correctos de acuerdo a tu proveedor de correo.


Asegúrate de que las rutas especificadas en require_once coincidan con la ubicación real de los archivos en tu hosting. Las rutas pueden variar según la configuración de tu servidor.

Uso en tu Aplicación
Una vez que hayas configurado las constantes y cargado los archivos en tu hosting, puedes utilizar estas funciones para enviar correos electrónicos dentro de tu aplicación. Asegúrate de que la lógica de tu aplicación invoque adecuadamente estas funciones donde sea necesario.

require_once('C:/xampp/htdocs/sistema-de-convenios/library/SMTP.php');
require_once('C:/xampp/htdocs/sistema-de-convenios/library/POP3.php');
require_once('C:/xampp/htdocs/sistema-de-convenios/library/OAuth.php');
require_once('C:/xampp/htdocs/sistema-de-convenios/library/PHPMailer.php');
require_once('C:/xampp/htdocs/sistema-de-convenios/library/consulSQL.php');

4. Una vez se suban los archivos y esté funcionando el sistema, se debe configurar el cronJobs en el servidor de correo para que el sistema pueda enviar las alertas
teniendo en cuenta que en esta configuración se debe seleccionar el archivo expiracion_convenio.php que se encuentra en la carpeta cronJobs aquí muestro un ejemplo de cómo lo configuré para funcionar desde mi local.  C:\xampp\php\php.exe -f C:\xampp\htdocs\sistema-de-convenios\API\cronJobs\expiracion_convenio.p

