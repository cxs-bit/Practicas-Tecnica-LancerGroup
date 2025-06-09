📘 Práctica Técnica - LancerGroup (PHP)
Este proyecto está diseñado para verificar los conocimientos adquiridos en las siguientes tecnologías:

🛠️ Tecnologías requeridas
🐘 PHP (8.2+)

📦 Composer

⚙️ Laravel 12+ o CodeIgniter 4

🌐 Vue 3+ (Opcional: Vuetify o Bootstrap como framework de UI)

🎨 CSS (Preferiblemente con Bootstrap o Vuetify)

📖 Habilidades investigativas (lectura y aplicación de documentación)

🐙 Git

🧩 MySQL

🧱 Algún template visual basado en Vue o Bootstrap (ej. CoreUI, BootstrapVue, Vuetify Admin, etc.)

📚 Descripción de la práctica
Se deberá diseñar un sistema de administración de libros para una biblioteca. Este sistema debe contar únicamente con apartados para:

📕 Libros

✍️ Autores

🔁 Relación entre datos:
Un autor puede tener múltiples libros.

Un libro puede tener múltiples autores.

Un autor NECESITA poder crearse sin libros.

Un libro DEBE tener al menos un autor para ser creado.

📋 Vista en tablas:
Autores y Libros deben mostrarse en tablas independientes.

Cada tabla debe incluir botones de:
🔍 Ver Detalles | ✏️ Editar | 🗑️ Eliminar (o 👁️ Ocultar para autores).

Los autores eliminados mediante soft delete NO deben aparecer en la lista de autores, pero sí deben seguir apareciendo en los detalles de libros donde estén relacionados.

🗃️ Campos requeridos
✍️ Autores
Nombre

Apellido

País

📆 Fecha de Registro (oculto en tabla, visible en detalles)

📚 Cantidad de libros registrados (oculto en tabla, visible en detalles)

📕 Libros
Nombre

📅 Fecha de publicación

Edición

✍️ Autores (múltiples)

⚙️ Detalles técnicos
📐 La base de datos debe estar correctamente normalizada.

🧩 Puedes elegir entre Laravel 12+ o CodeIgniter 4.

🎨 El diseño visual no tiene que seguir un patrón específico, pero DEBE mantener consistencia en los estilos.

📡 Las operaciones pueden realizarse mediante formularios tradicionales o AJAX con Vue 3 o JavaScript.

🧾 Los commits deben ser continuos y bien organizados, con mensajes claros.

👁️‍🗨️ Los campos marcados con * NO deben mostrarse en la tabla, pero sí deben estar disponibles en la vista de detalles.

🧠 ¿Qué se evaluará?
🧱 Calidad del diseño de base de datos

🧼 Calidad del código

🎨 Uso y coherencia del diseño visual

🧭 Estructura del proyecto y uso de patrones

📌 Reglas de interpretación
DEBE: obligatorio e inalterable.

NECESITA: obligatorio, pero con flexibilidad en la forma de implementarlo.

PUEDE: opcional, no afectará la calificación, pero sirve como práctica adicional.

💡 Recomendaciones
🖼️ Puedes usar modals para mostrar información detallada de autores o libros.

🗑️ Para el soft delete de autores, agrega un campo deleted_at o is_deleted en la tabla correspondiente.

❗ Cometer errores está permitido. Explicar cómo los solucionaste o intentaste hacerlo puede sumar puntos.

✅ Asegúrate de validar que los libros no se creen sin al menos un autor.
