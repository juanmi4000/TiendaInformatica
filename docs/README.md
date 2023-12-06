# Tarea: Tienda Informática (Tema 4)
## Alumno: Juan Manuel García Moyano 

### 1. Resumen del proyecto
Tienda de informática online, se va encargar de gestionar todo lo relacionado con esta, como los usuarios, productos, ventas, etc. Además, habrá que manejar la base de datos. Para ello se han utilizado ficheros de PHP, que van a ser los encargados de conectarse a la base de datos y manejar la información que se obtenga ya sea para insertar, consultar, eliminar o modificar datos. Va a tener una vista para los administradores y otra diferente para los usuarios.

### 2. Instalación
Para probar el proyecto vamos a necesitar un servidor y que pueda ejecutar PHP. En mi caso lo he hecho con XAMPP, que es servidor web local multiplataforma que permite la creación y prueba de páginas web u otros elementos de programación. Además, ya parte con la ventaja que trae PHP y MySQL. Puedes descargar XAMPP en la siguiente página: https://www.apachefriends.org/es/download.html

Continuamos con la descarga del proyecto y una vez instalado XAMPP se va a crear un directorio, pero va a cambiar según el sistema operativo. Independientemente del sistema operativo, en el directorio anteriormente dicho va a haber uno que se llama **htdocs**. Una vez dentro creamos un directorio que se llame **docs**, por ejemplo. Al final se debería de ver así:
- **-Windows**: C:\xampp\htdocs\docs
- **-Linux**: /opt/lampp/htdocs/docs 

Metemos el proyecto dentro de **docs**. El siguiente paso es poner en un navegador **localhost/docs/ProyectoFinalTema4/fuente**. Por defecto se va a crear un administrador y un usuario:
    - Administrador --> correo: admin@gmail.com, contraseña: admin
    - Usuario --> correo: usuario@gmail.com, contraseña: 1234


### 3. Funcionalidad
Una vez se ejecute el proyecto por primera vez, comprobará si existen un administrador y un usuario.Si no existe se crearan por defecto, si existen no hará nada.

Un usuario podrá hacer compras que se le añadirán a un carrito y luego podrán realizar un pedido. Una vez se confirme el pedido verán un resumen de lo que han comprado.

Un administrador podrá modificar varias tablas de la base de datos, como la de categorías, productos y proveedores Independientemente de la operación antes de que se ejecute le pedirá su contraseña, si todo ha ido bien hará la acción, sino le pedirá de nuevo la contraseña. Las funcionalidades que tiene en las tablas anteriores son:
- **Insertar**: se pueden añadir categorías, productos y proveedores.
- **Elminar**: al eliminar una fila de alguna de las tablas anteriores, también se elimirán las filas de otras tablas a las que haga referencia. De esta manera se conseguirá mantener la integridad referencial en la base de datos.
- **Actualizar**: en la tabla productos se va a poder actualizar el stock, para ello se va a tener que elegir un proveedor. Una vez elegido el proveedor te pedirá la cantidad que quieres comprar y se actualizará el stock.






### 4. Base de datos
El proyecto va a tratar sobre una tienda de informática online. Esta va a tener una base de datos para gestionar todo lo relacionado con la tienda. La base de datos va a tener un total de 6 tablas. Vamos a ver que hace cada una de las siguientes tablas:
#### 1. Personas
Se va encargar de todo lo relacionado con las personas, ya sea, usuario o administradores. Tiene los siguientes atributos: 
    - **- idPersona**: llave principal y se autoincrementará. Los 10 primeros valores se han reservado para los administradores.
    - **- nombre**
    - **- apellidos**
    - **- direccion**
    - **- telefono**: unique
    - **- contrasena**: estará encriptada
    - **- email**: unique
    - **- fechaNac**
    - **- rol**: por defecto es usuario

#### 2. Proveedores
Por defecto tendrá un proveedor. Se va encargar de guardar los datos de los proveedores y tiene los siguientes atributos: 
    - **- idProveedor**: llave principal y se autoincrementará.
    - **- nombre**
    - **- razonSocial**: unique
    - **- direccion**
    - **- telefono**: unique
    - **- email**: unique

#### 3. Categorías
Tiene los siguientes atributos: 
    - **- idCategoria**: llave principal y se autoincrementará.
    - **- nombre**
    - **- descripcion**

#### 4. Productos
Define un producto y un producto va a estar asociado a una categoría. Se crea un producto por defecto. Tiene los siguientes atributos: 
    - **- idProducto**: llave principal y se autoincrementará. Los 10 primeros valores se han reservado para los administradores.
    - **- nombre**
    - **- descripcion**
    - **- categoria**: llave foránea de la tabla categorias (idCategoría)
    - **- modelo**:
    - **- precioUnitario**:
    - **- iva**
    - **- stock**

#### 5. Compras
Se tiene en cuenta cuando le conpramos a un proveedor una cantidad de un producto. Los siguientes atributos: 
    - **- numFacturasCompras**: llave principal y se autoincrementará.
    - **- productoId**: llave foránea de la tabla producto (idProducto)
    - **- proveedorId**:  llave foránea de la tabla proveedor (idProveedor)
    - **- fechaCompra**: se pone por defecto la fecha actual
    - **- cantidadComprada**
    - **- precioUnitario**
    - **- precioTotal**

#### 6. Ventas
La tabla ventas guardará lo datos cuando un cliente haga un pedido.Tiene los siguientes atributos: 
    - **- numFacturasVentas**: llave principal y se autoincrementará.
    - **- productoId**: llave foránea de la tabla producto (idProducto)
    - **- personaId**: llave foránea de la tabla persona (idPersona)
    - **- enviado**: booleano
    - **- fechaVenta**: se pone por defecto la fecha actual
    - **- cantidadVendida**
    - **- precioUnitario**
    - **- precioTotal**
