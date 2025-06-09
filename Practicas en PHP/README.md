# 📘 Práctica Técnica - LancerGroup (PHP)

Este proyecto está diseñado para verificar los conocimientos adquiridos en las siguientes tecnologías:

## 🛠️ Tecnologías requeridas

- 🐘 PHP (8.2+)
- 📦 Composer
- ⚙️ Laravel 12+ o CodeIgniter 4
- 🌐 Vue 3+ (opcional Vuetify o Bootstrap)
- 🎨 CSS (Bootstrap o Vuetify)
- 📖 Habilidades investigativas (lectura de documentación)
- 🐙 Git
- 🧩 MySQL
- 🧱 Algún template visual basado en Vue o Bootstrap (ej. CoreUI, BootstrapVue, Vuetify Admin, etc.)

---

## 📚 Descripción de la práctica

Se deberá diseñar un sistema de administración de libros para una biblioteca. Este sistema debe contar **únicamente** con apartados para:

- 📕 Libros
- ✍️ Autores

### 🔁 Relación entre datos:

- Un autor puede tener **múltiples libros**.
- Un libro puede tener **múltiples autores**.
- Un autor **NECESITA** poder crearse **sin** libros.
- Un libro **DEBE** tener al menos **un autor** para ser creado.

### 📋 Vista en tablas:

- Autores y libros deben mostrarse en tablas independientes.
- Cada tabla debe incluir botones para:  
  `🔍 Ver Detalles` | `✏️ Editar` | `🗑️ Eliminar` (o `👁️ Ocultar` para autores).
- Los autores eliminados mediante soft delete **NO deben aparecer en la lista de autores**, pero **SÍ deben seguir apareciendo en los detalles de los libros** donde estén relacionados.

---

## 🗃️ Campos requeridos

### ✍️ Autores

- Nombre
- Apellido
- País
- 📆 Fecha de registro (*)
- 📚 Cantidad de libros registrados (*)

### 📕 Libros

- Nombre
- 📅 Fecha de publicación
- Edición
- ✍️ Autores (*)

> Los campos marcados con (*) no deben aparecer en la tabla general, pero sí en la vista de detalles del elemento.

---

## ⚙️ Detalles técnicos

1. La base de datos debe estar correctamente **normalizada**.
2. Puedes usar **Laravel 12+** o **CodeIgniter 4**, según prefieras.
3. El diseño visual **no debe seguir un patrón específico**, pero debe ser coherente en estilos y colores.
4. Las interacciones pueden realizarse a través de formularios tradicionales o mediante **AJAX / Vue 3**.
5. Deben realizarse **commits continuos y organizados** durante el desarrollo.
6. La información oculta en tablas (*campos con asterisco*) debe mostrarse en las vistas de detalle.

---

## ✅ ¿Qué se evaluará?

- Estructura y normalización de la base de datos
- Calidad y organización del código
- Claridad y coherencia del diseño visual
- Uso correcto de Vue/AJAX en las interacciones
- Organización y claridad de los commits

---

## 📌 Reglas de interpretación

- **DEBE**: obligatorio e inalterable.
- **NECESITA**: obligatorio, pero puedes implementar a tu manera.
- **PUEDE**: opcional, no se evaluará, pero es una buena práctica.

---

## 💡 Recomendaciones

- Puedes usar **modales** para mostrar detalles de libros o autores.
- Para el soft delete de autores, utiliza un campo `deleted_at` (timestamp) o `is_deleted` (boolean).
- Cometer errores está permitido. Explicar cómo los solucionaste puede **sumar puntos**.
- Asegúrate de validar que un libro **no se cree sin autores**.

---

¡Éxito! 💪
