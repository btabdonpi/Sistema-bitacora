# 📘 Bitácora de Transacciones

**Bitácora de Transacciones** es un sistema de registro automatizado de acciones realizadas por el personal dentro de una organización. Este sistema permite documentar cada evento relevante como creación, modificación o eliminación de proyectos y tareas, de forma centralizada y trazable.

---

## 🎯 Objetivo

El sistema tiene como propósito registrar de manera automática las transacciones realizadas por el personal, generando una bitácora que permite el seguimiento detallado de los procesos internos, asignaciones y roles del personal dentro de los distintos proyectos.

---

## 🧩 Funcionalidades principales

### 📁 Gestión de Proyectos
- **Crear Proyecto**: Registra nombre, descripción, fechas y responsable.
- **Modificar Proyecto**: Actualiza los datos del proyecto existente.
- **Eliminar Proyecto**: Elimina un proyecto y todas sus tareas asociadas.
- **Asignar Recursos**: Asigna personal con roles y fechas a un proyecto.

### 📌 Gestión de Tareas
- **Crear Tarea**: Registra tareas asociadas a un proyecto.
- **Modificar Tarea**: Permite actualizar tareas existentes.
- **Eliminar Tarea**: Elimina una tarea específica.

### 🧠 Validaciones
- Los **proyectos son únicos**.
- Las **tareas deben estar asociadas a un proyecto**.
- Un **personal solo puede tener una tarea activa**.
- Los **administradores no pueden ser asignados a tareas o proyectos**.
- Solo **usuarios administrativos** pueden acceder al sitio de la bitácora y gestionar contenido.

---

## 🛠️ Tecnologías usadas

- ⚙️ **PHP** (interfaz y lógica del lado servidor)
- 💾 **MySQL** (base de datos y procedimientos almacenados)
- 🌐 **HTML/CSS** (estructura y estilos de la interfaz)
- 🔗 **SOAP** (servicios web)
- 📦 **Excel (.xlsx)** para carga masiva de datos
- 🖨️ **Exportación a PDF** para informes

---

## Inicio
<p align="center">
  <img src="imgs/inicio.jpg" alt="Inicio" width="500">
</p>
