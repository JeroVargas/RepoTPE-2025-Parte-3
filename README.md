# Proyecto de Venta de Pisos

Este proyecto es un trabajo práctico especial para la materia de Web 2. La temática del proyecto es la venta de pisos, ofreciendo una variedad de tamaños y calidades.

## Participantes

- jeronimovargas2604@gmail.com
- giulianonicolasbellocchio@gmail.com

## Temática

La página web se centrará en la venta de pisos, con una amplia gama de opciones en cuanto a materiales, tamaños y calidades.

## Base de Datos

La base de datos del proyecto se llama `pisostpe` y consta de las siguientes tablas:

### Tabla `categorias`

Esta tabla almacena las categorías de los pisos.

- **id**: Identificador único para cada categoría (Clave primaria).
- **nombre**: Nombre de la categoría (ej. Mármoles, Travertinos, Baldosas).

### Tabla `pisos`

Esta tabla almacena los detalles de los pisos disponibles.

- **id**: Identificador único para cada tipo de piso (Clave primaria).
- **id_categoria**: Referencia a la categoría a la que pertenece el piso (Clave foránea a `categorias.id`).
- **tipo_variante**: El tipo o variante del piso.
- **origen**: El país o región de origen del material.
- **acabados_comunes**: Los acabados más comunes para ese tipo de piso.
- **uso_recomendado**: El uso recomendado para el piso.

### Tabla `usuarios`

Esta tabla almacena la información de los usuarios registrados.

- **id**: Identificador único para cada usuario (Clave primaria).
- **email**: Correo electrónico del usuario (Único).
- **password**: Contraseña hasheada del usuario.
- **level**: Nivel de permisos del usuario (ej. usuario, admin).


## Admin Login

user: admin@todopisos.com

password: admin

## Imágenes del Proyecto

- [Ver Imagen](349c28fd-a95e-450c-8a3d-085ac4d34c7b.jfif)

---

## API Endpoints

### Autenticación por Token

Algunos endpoints de la API requieren autenticación. Para acceder a ellos, primero debes obtener un token de autenticación y luego incluirlo en las cabeceras de tus solicitudes.

**1. Obtener un Token (Login):**
*   **Método:** `POST`
*   **Endpoint:** `/login`
*   **Cuerpo (JSON):** `{"email": "admin@todopisos.com", "password": "admin"}`
*   **Respuesta:** `200 OK` con `{"token": "..."}`.

**2. Usar el Token:**
*   Para acceder a rutas protegidas, incluye el token en la cabecera `X-Authorization`.
*   **Cabecera:** `X-Authorization: <TU_TOKEN_OBTENIDO>`

### Recurso: Pisos (`productos`)

| Método | Endpoint          | Descripción              | Requiere Auth | Parámetros / Cuerpo (JSON)                                                                                                     |
|:-------|:------------------|:-------------------------|:--------------|:-------------------------------------------------------------------------------------------------------------------------------|
| `GET`    | `/productos`      | Lista todos los pisos.   | No            | **Query (opcional):** `sort` (columna), `order` (ASC/DESC)                                                                     |
| `GET`    | `/productos/{id}` | Obtiene un piso por ID.  | No            | **Ruta:** `id` del piso                                                                                                        |
| `POST`   | `/productos`      | Crea un nuevo piso.      | Sí            | **Cuerpo:** `{ "id_categoria": ..., "tipo_variante": ..., "origen": ..., "acabados_comunes": ..., "uso_recomendado": ... }`      |
| `PUT`    | `/productos/{id}` | Actualiza un piso por ID.| Sí            | **Ruta:** `id` del piso <br> **Cuerpo:** `{ "id_categoria": ..., "tipo_variante": ..., ... }`                                   |
| `DELETE` | `/productos/{id}` | Elimina un piso por ID.  | Sí            | **Ruta:** `id` del piso                                                                                                        |

**Ejemplo de ordenamiento:** `GET /productos?sort=origen&order=desc`


### Recurso: Categorías (`categorias`)

| Método | Endpoint          | Descripción                  | Requiere Auth | Parámetros / Cuerpo (JSON)                                   |
|:-------|:------------------|:-----------------------------|:--------------|:-------------------------------------------------------------|
| `GET`    | `/categorias`     | Lista todas las categorías.  | No            | **Query (opcional):** `sort` (columna), `order` (ASC/DESC)     |
| `GET`    | `/categorias/{id}`| Obtiene una categoría por ID.| No            | **Ruta:** `id` de la categoría                               |
| `POST`   | `/categoria`      | Crea una nueva categoría.    | Sí            | **Cuerpo:** `{ "nombre": "..." }`                            |
| `PUT`    | `/categoria/{id}` | Actualiza una categoría por ID.| Sí            | **Ruta:** `id` de la categoría <br> **Cuerpo:** `{ "nombre": "..." }` |
| `DELETE` | `/categoria/{id}` | Elimina una categoría por ID.| Sí            | **Ruta:** `id` de la categoría                               |

**Ejemplo de ordenamiento:** `GET /categorias?sort=nombre&order=asc`