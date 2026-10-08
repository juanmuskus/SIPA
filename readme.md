# SIPA — Sistema de Prácticas Académicas

## Estado de la migración

La aplicación nueva está en la raíz del proyecto y usa PHP 8.x sin depender del runtime de Zend Framework 1. El punto de entrada moderno es `public/index.php`; `app/Core` contiene el enrutador, sesiones, vistas y acceso PDO; `app/Modules` conserva los flujos funcionales y `app/Views` contiene las pantallas. La versión Zend anterior se conserva en `SIPA_Zend` solo como referencia y respaldo durante la transición.

La migración de código no sustituye ni transforma la base de datos. El repositorio no incluye un volcado ni un script de esquema. Se verificó conexión local con las bases `practicas`, `campus` y `kactus` usando la configuración predeterminada (`localhost`, usuario `root`, sin contraseña). Las tres conexiones respondieron y se encontraron las tablas/vistas esperadas. También se validaron, en modo de solo lectura, consultas representativas de los flujos principales. No se ejecutaron operaciones de escritura ni pruebas funcionales autenticadas. No borrar `SIPA_Zend` ni retirar el sistema anterior hasta completar el corte y la aceptación descritos abajo.

La interfaz y el flujo se contrastaron con el Manual de Usuario e Instalación adjunto: autenticación por rol; gestión administrativa de usuarios, calendario, rutas y recursos; registro y programación de prácticas; gestión logística y liquidación/pago de docentes y conductores.

La copia Zend también incluye pantallas de mantenimiento local para facultades, programas y asignaturas que no aparecen en los flujos del manual. La app migrada toma esos datos de las vistas de `campus`, como indica el manual. En la etapa de aceptación se debe confirmar con el área usuaria que esas pantallas dejaron de ser necesarias antes de retirar Zend.

## Requisitos

- PHP 8.0 o superior; se recomienda una versión 8.x mantenida y probada por el servidor.
- Apache con `mod_rewrite` y `AllowOverride` habilitado, o un servidor equivalente que dirija las rutas a `public/index.php`.
- Extensiones `PDO`, `pdo_mysql` para MySQL y `session`.
- Si `campus` o `kactus` usan Microsoft SQL Server, habilitar `pdo_sqlsrv` compatible con la versión exacta de PHP.
- Las bases de datos y vistas descritas por la instalación vigente del centro de datos.

## Instalación local

1. Respaldar la base de datos vigente y conservar intacta la aplicación Zend durante las pruebas.
2. En la instalación local ya existente, la aplicación usa por defecto MySQL en `localhost`, base `practicas`, usuario `root` y contraseña vacía; también intenta conectarse a las bases `campus` y `kactus` con esos valores. En otro entorno, confirmar que las tres bases/vistas estén disponibles y respaldar los datos antes de cualquier migración. Importar esquema o datos solo si se está preparando una base nueva y se dispone de un respaldo autorizado. El manual histórico incluye credenciales de ejemplo: no reutilizarlas ni guardar contraseñas en el repositorio.
3. Configurar el usuario, contraseña y nombre de cada base MySQL. SIPA crea tres conexiones independientes; si se omiten variables, usa `practicas`, `campus` y `kactus` en `localhost:3306`, con usuario `root` y contraseña vacía (solo desarrollo local). Para cambiar credenciales, definir estas variables de entorno antes de iniciar Apache/PHP:

   ```text
   SIPA_DB_PRACTICAS_DRIVER=mysql
   SIPA_DB_PRACTICAS_HOST=127.0.0.1
   SIPA_DB_PRACTICAS_PORT=3306
   SIPA_DB_PRACTICAS_NAME=practicas
   SIPA_DB_PRACTICAS_USER=sipa_app
   SIPA_DB_PRACTICAS_PASSWORD=<contraseña>

   SIPA_DB_CAMPUS_DRIVER=mysql
   SIPA_DB_CAMPUS_HOST=127.0.0.1
   SIPA_DB_CAMPUS_PORT=3306
   SIPA_DB_CAMPUS_NAME=campus
   SIPA_DB_CAMPUS_USER=sipa_lectura
   SIPA_DB_CAMPUS_PASSWORD=<contraseña>

   SIPA_DB_KACTUS_DRIVER=mysql
   SIPA_DB_KACTUS_HOST=127.0.0.1
   SIPA_DB_KACTUS_PORT=3306
   SIPA_DB_KACTUS_NAME=kactus
   SIPA_DB_KACTUS_USER=sipa_lectura
   SIPA_DB_KACTUS_PASSWORD=<contraseña>
   ```

   En Laragon/Windows, estas variables deben estar disponibles para el proceso de Apache/PHP. Se pueden configurar desde **Windows → Editar las variables de entorno del sistema → Variables de entorno** y luego reiniciar Laragon/Apache. Para una prueba rápida en PowerShell, se pueden definir en la sesión y lanzar Apache desde esa misma ventana:

   ```powershell
   $env:SIPA_DB_PRACTICAS_USER = 'root'
   $env:SIPA_DB_PRACTICAS_PASSWORD = ''
   $env:SIPA_DB_PRACTICAS_HOST = '127.0.0.1'
   ```

   Repetir para `CAMPUS` y `KACTUS` si usan credenciales distintas. No guardar contraseñas reales en este README, en el código ni en archivos versionados. En producción, crear usuarios MySQL dedicados: permisos de lectura/escritura solo sobre `practicas` y de solo lectura sobre `campus`/`kactus`, según las operaciones que requiera SIPA. Si Campus o Kactus usan SQL Server, usar `DRIVER=sqlsrv`, el puerto por defecto `1433` y habilitar `pdo_sqlsrv`.
4. Configurar el document root de Apache en `SIPA/public` (recomendado). La aplicación también admite un montaje en subcarpeta, por ejemplo `http://localhost/SIPA/login`; la detección del prefijo no distingue mayúsculas/minúsculas, por lo que también funciona como `/sipa/login` en Windows. Esto aplica tanto si Apache expone la raíz del proyecto como si reescribe internamente hacia `public/index.php`. En ese caso debe estar habilitado `mod_rewrite` y Apache debe permitir `.htaccess`. No exponer `app`, `application`, `library`, `SIPA_Zend`, `log` ni los demás archivos fuente como contenido público.
5. Verificar `php -v`, `php -m` (en particular los controladores PDO habilitados) y revisar el log de Apache/PHP. Para desarrollo solamente, `SIPA_DEBUG=1` habilita errores en pantalla; mantenerlo desactivado en producción.

Si PHP muestra `Unable to load dynamic library`, revisar que `extension_dir` apunte a la carpeta `ext` de la versión PHP seleccionada en Laragon y que `pdo_mysql` (y, si aplica, `pdo_sqlsrv`) esté habilitada.

## Credenciales locales de prueba

Estas cuentas están en la base local de desarrollo y sirven para iniciar sesión en la aplicación:

| Rol | Usuario | Contraseña |
|---|---|---|
| Administrador | `magu` | `123` |
| Departamento | `kami` | `12345` |
| Logística | `lilo` | `1234` |

Son credenciales débiles de prueba. No usarlas en un servidor accesible desde la red; cambiarlas antes de cualquier despliegue. La contraseña de la cuenta financiera no está confirmada.

## Funcionalidad migrada y evaluación por etapas

| Etapa | Flujo del manual | Estado del código | Evaluación/criterio para aceptar |
|---|---|---|---|
| 1. Arranque y acceso | Inicio de sesión, cierre y redirección según rol (administrador, departamento, logística y financiera). | Implementado en PHP 8.x; sesiones regeneradas al autenticar. | Abrir `/login`, probar credenciales válidas e inválidas por cada rol y verificar que una sesión cerrada no abra rutas privadas. |
| 2. Administración | Crear, listar, editar y eliminar usuarios, calendarios académicos, rutas y recursos especiales; registrar liquidaciones docentes. | Controladores y pantallas migrados. | Con datos de prueba, ejecutar el ciclo CRUD completo, confirmar alertas y comprobar que rutas/recursos estén disponibles al programar una práctica. |
| 3. Prácticas | Registrar y editar práctica, consultar información académica, agregar participantes, programar días/rutas/pernoctaciones y recursos especiales, consultar el listado y los detalles de liquidación. | Flujo y endpoints migrados; se añadieron las pantallas que faltaban, la edición de prácticas y se restringieron los endpoints de consulta/escritura a roles autorizados. | Crear y editar una práctica representativa de varios días; validar fechas, participantes, recursos, transacción completa y cálculo frente al manual y a la aplicación anterior. |
| 4. Logística | CRUD de conductores, vehículos y servicios; liquidar gastos y remitirlos a financiera. | Controladores migrados; se completaron las pantallas CRUD de logística y se corrigieron enlaces que apuntaban a acciones inexistentes. | Completar altas/cambios/bajas con datos de prueba, asignar vehículo y conductor, registrar liquidación y confirmar que el módulo financiero la vea. |
| 5. Financiera | Consultar y actualizar pago/legalización de docentes y conductores. | Controladores y pantallas migrados. | Verificar totales, estados, fechas de pago y legalización; confirmar que los cambios persisten y se reflejan en prácticas/logística. |
| 6. Corte de producción | Sustituir la aplicación Zend y conservar la trazabilidad de los datos. | Conexiones locales a `practicas`, `campus` y `kactus`, tablas/vistas y consultas representativas verificadas en modo de solo lectura. Pendientes las pruebas autenticadas de CRUD, cálculos y transacciones; no hay script de conversión del esquema en este repositorio. | Ejecutar todas las etapas en staging, comparar conteos/datos con Zend, respaldar antes del corte, definir reversa y retirar Zend solo con aprobación del área usuaria. |

Una etapa no se considera aceptada solo porque la pantalla cargue: sus operaciones deben probarse con una copia de la base, en cada rol involucrado, y compararse con los resultados de SIPA Zend y con las reglas del manual.

## Comprobaciones técnicas

Desde la raíz del proyecto, con PHP 8.x en `PATH`:

```powershell
Get-ChildItem app,public -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
php -l index.php
```

La comprobación de sintaxis y las consultas de solo lectura no reemplazan la prueba de integración: no se debe declarar lista la migración productiva hasta probar con usuarios/datos de prueba los CRUD, cálculos, permisos y guardado transaccional de una práctica, así como los flujos financieros y de logística.
