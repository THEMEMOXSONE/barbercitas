# Guía de Instalación para Desarrollo (Docker / Laravel Sail)

Sigue estos pasos para tener el programa corriendo en tu computadora exactamente igual que en el entorno original. Todo funciona mediante **Docker**, por lo que no necesitas instalar PHP ni Node directamente en tu sistema.

## Requisitos Previos
1. **Docker Desktop** instalado y ejecutándose.
2. (Recomendado en Windows) **WSL 2** instalado y usando una terminal de Ubuntu.
3. **Git** instalado.

## Pasos de Instalación

**1. Clonar el repositorio**
Abre tu terminal y descarga el código:
```bash
git clone https://github.com/THEMEMOXSONE/barbercitas.git
cd barbercitas
```

**2. Instalar dependencias de PHP temporales**
Como aún no tenemos el contenedor preparado, usamos un contenedor pequeño solo para instalar `composer`:
```bash
docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php83-composer:latest composer install --ignore-platform-reqs
```

**3. Configurar variables de entorno**
```bash
cp .env.example .env
```

**4. Levantar los contenedores de Docker (Sail)**
```bash
./vendor/bin/sail up -d
```
*Nota: La primera vez va a tardar un poco mientras descarga las imágenes de Ubuntu, PHP, MySQL, etc.*

**5. Generar la clave de la aplicación**
```bash
./vendor/bin/sail artisan key:generate
```

**6. Ejecutar migraciones y datos de prueba**
Prepara la base de datos y crea el usuario Administrador y la configuración por defecto:
```bash
./vendor/bin/sail artisan migrate --seed
```

**7. Compilar los estilos (TailwindCSS)**
Instala las librerías de Node (NPM) y compila el CSS:
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```
*(Si vas a hacer cambios al código, puedes usar `./vendor/bin/sail npm run dev` para que asimile los cambios en tiempo real).*

---

### ¡Listo!
Ya puedes abrir [http://localhost](http://localhost) en tu navegador.

**Credenciales de Administrador:**
- Email: `admin@barber.com`
- Contraseña: `password`

Para detener los contenedores cuando dejes de programar, simplemente ejecuta:
```bash
./vendor/bin/sail down
```
