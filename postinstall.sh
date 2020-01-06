#!/bin/bash

#------------------------------------------------------------------------------#
#
# Este script pretende solucionar todos los problemas relacionados
# a los permisos de archivos y carpetas en proyectos de cake
#
# 1. Tienen que estar creadas las carpetas tmp y logs y con permisos 777 
# 2. Permisos en archivos/carpetas:
#   - /.htaccess - 644
#   - /webroot - 755
#   - /webroot/.htaccess - 644
#   - /webroot/index.php - 644
# 3. El archivo bin/cake tiene que tener permisos de ejecucion
#
#------------------------------------------------------------------------------#

ROJO='\033[0;91m'
SC='\033[0m'

# Para ejecutar necesitamos ser root
# [ "$UID" -eq 0 ] || exec sudo "$0" "$@"

function imprimir_bloque {
	echo "-----------------------------------------------------------"
	echo "--" $1
	echo "-----------------------------------------------------------"
}

function imprimir_error {
	echo -e "${ROJO}-----------------------------------------------------------"
	echo -e "--"
	echo -e "-- CUIDADO: " $1
	echo -e "--"
	echo -e "-----------------------------------------------------------${SC}"
}

function imprimir_linea {
	echo \*\* $1
	#echo "-----------------------------------------------------------"
}

imprimir_bloque "Post Install Script | Syloper"

#------------------------------------------------------------------------------#
# Numero 1
#------------------------------------------------------------------------------#

# Permisos a la carpeta ruta (public_html)
# La carpeta public_html debe tener por defecto los permisos 750
# https://www.hostgator.com/help/article/public-html-folder
chmod 755 "."
imprimir_linea "Permisos en carpeta ruta (public_html) actualizado."

if [[ ! -e "tmp" ]]; then
    #La carpeta tmp NO existe
    mkdir "tmp/"
    chmod -R 777 "tmp/"
    imprimir_linea "Se creó la carpeta tmp y se le dió los permisos necesarios"
else
    #La carpeta tmp ya existe
    chmod -R 777 "tmp/"
    imprimir_linea "Se encontró la carpeta tmp y se le dió los permisos necesarios"
fi 

if [[ ! -e "logs" ]]; then
    #La carpeta logs NO existe
    mkdir "logs/"
    chmod -R 777 "logs/"
    imprimir_linea "Se creó la carpeta logs y se le dió los permisos necesarios"
else
    #La carpeta logs ya existe
    chmod -R 777 "logs/"
    imprimir_linea "Se encontró la carpeta logs y se le dió los permisos necesarios"
fi 

#------------------------------------------------------------------------------#
# Numero 2
#------------------------------------------------------------------------------#
if [[ ! -e ".htaccess" ]]; then
    imprimir_error "El archivo .htaccess no existe en la carpeta ruta."
else
    chmod 644 ".htaccess";
    imprimir_linea "Permisos en /.htaccess actualizados."
fi

if [[ ! -e "webroot" ]]; then
    imprimir_error "La carpeta /webroot no existe"
else
    chmod 755 "webroot";
    imprimir_linea "Permisos en /webroot actualizados."
fi

if [[ ! -e "webroot/.htaccess" ]]; then
    imprimir_error "El archivo .htaccess no existe en la carpeta webroot."
else
    chmod 644 "webroot/.htaccess";
    imprimir_linea "Permisos en /webroot/.htaccess actualizados."
fi

if [[ ! -e "webroot/index.php" ]]; then
    imprimir_error "El archivo index.php no existe en la carpeta webroot."
else
    chmod 644 "webroot/index.php";
    imprimir_linea "Permisos en /webroot/index.php actualizados."
fi

#------------------------------------------------------------------------------#
# Numero 3
#------------------------------------------------------------------------------#
if [[ ! -e "bin/cake" ]]; then
    imprimir_error "El archivo binario cake no existe en la carpeta bin."
else
    chmod +x "bin/cake";
    imprimir_linea "bin/cake ahora tiene permisos de ejecucion."
fi



imprimir_bloque "David Gallegos | david@syloper.com | Syloper"
