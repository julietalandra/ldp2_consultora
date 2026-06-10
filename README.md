# 🖥️ Panel de Administración - Consultora de Software

Este repositorio contiene la interfaz de administración y el diseño de base de datos para una aplicación web orientada a la gestión interna de proyectos, personal, empresas y países en una consultora de software. 

Este proyecto fue desarrollado en el marco de la materia **Lenguaje de Programación II** (Trabajo Práctico 3 - Segundo Desempeño).

---

## 🚀 Nombre del Repositorio y Descripción Recomendados

Si vas a crear el repositorio en GitHub, aquí tienes unas excelentes sugerencias:

### Opciones de Nombre
1. **`consultora-admin-dashboard`** *(Recomendado - Profesional y descriptivo)*
2. **`tp3-lp2-consultora`** *(Ideal si prefieres identificarlo por la materia académica)*
3. **`gestion-proyectos-consultora`** *(Enfocado en el propósito de negocio)*

### Descripción sugerida para GitHub
> 📊 Sistema de gestión interna y panel de administración para una consultora de desarrollo de software. Permite administrar proyectos, personal, clientes (empresas) y países. Desarrollado con Bootstrap 5, AdminKit y MySQL.

---

## 📁 Estructura del Proyecto

El proyecto está organizado de la siguiente manera:

*   **Páginas Principales (HTML/Frontend):**
    *   [`index.html`](file:///Users/julietalandra/Documents/ldp2/TP3_LP2_2doDesempenio/index.html): Panel de control / Dashboard de bienvenida.
    *   [`login.html`](file:///Users/julietalandra/Documents/ldp2/TP3_LP2_2doDesempenio/login.html): Interfaz de inicio de sesión con alertas de validación de credenciales y permisos.
    *   [`listado_proyectos.html`](file:///Users/julietalandra/Documents/ldp2/TP3_LP2_2doDesempenio/listado_proyectos.html): Tabla interactiva que muestra los proyectos actuales, sus líderes, fechas de inicio y estados.
    *   [`carga_proyecto.html`](file:///Users/julietalandra/Documents/ldp2/TP3_LP2_2doDesempenio/carga_proyecto.html): Formulario para el registro de nuevos proyectos.
    *   [`listado_usuarios.html`](file:///Users/julietalandra/Documents/ldp2/TP3_LP2_2doDesempenio/listado_usuarios.html): Vista de los integrantes del equipo y sus respectivos roles.
    *   [`listado_empresas.html`](file:///Users/julietalandra/Documents/ldp2/TP3_LP2_2doDesempenio/listado_empresas.html): Tabla de empresas clientes asociadas.
    *   [`carga_empresa.html`](file:///Users/julietalandra/Documents/ldp2/TP3_LP2_2doDesempenio/carga_empresa.html): Formulario de registro de nuevas empresas clientes.
    *   [`listado_paises.html`](file:///Users/julietalandra/Documents/ldp2/TP3_LP2_2doDesempenio/listado_paises.html): Listado de países registrados en el sistema.
*   **Base de Datos:**
    *   [`consultora.sql`](file:///Users/julietalandra/Documents/ldp2/TP3_LP2_2doDesempenio/consultora.sql): Script de creación e inicialización de tablas esenciales (`roles`, `estados`, `paises`) y datos semilla.
*   **Recursos Estáticos:**
    *   `css/`: Hojas de estilos del panel (basado en el tema de AdminKit).
    *   `js/`: Scripts de comportamiento interactivo, gráficos e inicialización de componentes.
    *   `img/`: Recursos gráficos, iconos y avatares de usuario.

---

## 🛠️ Tecnologías Utilizadas

*   **Frontend:** HTML5, CSS3, JavaScript (ES6+), Bootstrap 5, AdminKit (Template Dashboard).
*   **Base de Datos:** MySQL / MariaDB.
*   **Entorno de Servidor sugerido:** PHP 7.4+ (para procesamiento backend de formularios y consultas a base de datos).

---

## ⚙️ Configuración y Puesta en Marcha

Sigue estos pasos para ejecutar y probar el proyecto de forma local:

### 1. Requisitos Previos
Necesitarás un entorno local de servidor web y base de datos. Se recomienda utilizar herramientas como:
*   [XAMPP](https://www.apachefriends.org/)
*   [Laragon](https://laragon.org/)
*   [WampServer](https://www.wampserver.com/)

### 2. Clonar el repositorio
Abre una terminal en tu carpeta de proyectos y ejecuta:
```bash
git clone https://github.com/tu-usuario/nombre-del-repo.git
```

### 3. Configuración de la Base de Datos
1. Inicia los servicios de **Apache** y **MySQL** en tu panel de control local (ej. XAMPP).
2. Dirígete a [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3. Crea una nueva base de datos llamada `consultora`.
4. Selecciona la base de datos recién creada, haz clic en la pestaña **Importar** y selecciona el archivo [`consultora.sql`](file:///Users/julietalandra/Documents/ldp2/TP3_LP2_2doDesempenio/consultora.sql).
5. Haz clic en **Continuar / Importar** para cargar la estructura y datos iniciales.

---

## 🌟 Funcionalidades Clave

*   **Gestión de Proyectos:** Registro de nuevos proyectos, asignación de líder de equipo, definición de estados del proyecto (`Analisis Iniciado`, `En Desarrollo`, `Terminado`, `Cancelado`).
*   **Administración de Clientes:** Carga y visualización de empresas asociadas según su país de origen.
*   **Control de Accesos:** Vista de login interactiva orientada a la validación de perfiles (Administrador, Líder, Analista, Programador).
*   **Diseño Responsivo:** Adaptado completamente a dispositivos móviles y de escritorio mediante Bootstrap 5.

---

## 📝 Licencia

Este proyecto es de carácter académico. Eres libre de usarlo, modificarlo y adaptarlo con fines de aprendizaje y desarrollo.
