# AGENDS.md

## Principio Principal: Conversación Primitiva y Eficiente

- En cada conversación me enfoco primero en una comunicación primitiva: respuestas claras, directas y objetivas, con el mínimo gasto posible de tokens y peticiones.
- Evito rodeos, repeticiones y explicaciones infladas, pero sin omitir detalles importantes cuando afectan al resultado técnico.
- Prioridad: detectar la causa real del problema, dar una respuesta accionable y no dispersarme en soluciones secundarias si el usuario no las ha pedido.
- Si el usuario pide solo explicación, no aplico cambios; si pide solución, primero reviso el estado actual del código antes de tocar nada.

---

## Patrón: Inclusión de secciones en layouts Blade

- Cuando el usuario pregunta por la ubicación de un componente (ejemplo: nav), reviso el layout principal (app.blade.php) para ver si hay un @yield específico para esa sección.
- Si el componente está siendo incluido dentro de @section('content'), pero existe un @yield('nav'), recomiendo y aplico mover la inclusión a una sección @section('nav') en la vista hija.
- Esto mantiene la estructura modular y flexible, y asegura que los componentes se ubiquen correctamente según el diseño del layout.
- Registro este patrón para futuras respuestas y para optimizar la eficiencia en la resolución de solicitudes similares.

---

## Patrón: Navegación por secciones en Laravel Blade

- Un <a href="..."> no apunta a un @include; apunta a una URL o a una ruta nombrada.
- Para alternar secciones Blade, la navegación debe pasar por rutas reales como /home, /about, /projects y /contact.
- En routes/web.php no debo definir varias veces la misma URL /; cada sección necesita su propia ruta o una única ruta controlada por parámetro.
- Si la portada debe abrir en /home, uso una redirección desde / hacia /home.
- En main.blade.php, solo debe renderizarse una sección por vez según la variable $section.

---

## Patrón: Includes Blade y rutas de vistas

- @include('nav') busca resources/views/nav.blade.php.
- @include('components.nav') busca resources/views/components/nav.blade.php.
- Antes de corregir un error de vista no encontrada, verifico la ruta real del archivo y hago coincidir el include con esa estructura.
- Si main.blade.php referencia componentes como home, projects o contact, debo comprobar antes si esas vistas existen para evitar errores 500 por includes faltantes.

---

## Patrón: Responsive y media queries

- En media queries con max-width, el orden de importación correcto es de breakpoint mayor a menor para que la cascada no pise los estilos pequeños de forma inesperada.
- Antes de cambiar una media query, reviso si el problema es realmente de breakpoint o de reglas base con height fija, márgenes, overflow o variables no definidas.
- Si un contenedor va a hacer scroll vertical, evito justify-content: center; normalmente debe usar justify-content: flex-start para no recortar el primer bloque visible.
- No redefino :root dentro de media queries si el usuario ya centraliza las variables globales en variables.css y quiere conservar ese patrón.

---

## Patrón: Animación JS y texto justificado

- Si un párrafo usa text-align: justify, no debo reconstruirlo con spans inline-block o márgenes por palabra si se quiere conservar el justificado.
- Para mantener el flujo del texto, prefiero animar el párrafo completo o usar un efecto typewriter con textContent normal.
- Antes de culpar al CSS, reviso si el JS está reemplazando el contenido del nodo o inyectando estilos inline que alteren el layout.

---

## Estadística de solicitudes resueltas
- [x] Verificación y corrección de ubicación de nav en layouts Blade.
- [x] Registro de patrón en AGENDS.md para respuestas más rápidas y precisas.
- [x] Registro de patrón para rutas Laravel por secciones con Blade.
- [x] Registro de patrón para includes Blade y errores View not found.
- [x] Registro de patrón responsive y orden de media queries.
- [x] Registro de patrón para animaciones JS que no rompan texto justificado.
