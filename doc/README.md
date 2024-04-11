# Documentació bàsica del projecte

Alguns dels punts que han de quedar explicats:

## Objectius

L'objectiu principal d'aquest projecte és desenvolupar una aplicació web que permeti gestionar pel·lícules i la creació de seients per a projeccions de cinema. L'aplicació ha de proporcionar una interfície d'usuari intuitiva i fàcil d'utilitzar tant per als administradors com per als usuaris finals.

## Arquitectura bàsica

Tecnologies utilitzades

* Frontend: Vue.js com a framework de JavaScript per al desenvolupament del frontend de l'aplicació.
* Backend: Laravel com a framework de PHP per al desenvolupament del backend de l'aplicació.
* Base de dades: MySQL per emmagatzemar les dades de l'aplicació.

Interrelació entre els diversos components

El frontend desenvolupat amb Vue.js interactua amb el backend de Laravel a través d'API RESTful. Aquest backend gestiona les dades emmagatzemades a la base de dades MySQL i proporciona-les al frontend mitjançant peticions HTTP.

## Com crees l'entorn de desenvolupament

Per crear l'entorn de desenvolupament per a aquest projecte, segueix aquestes passes:

1. Instal·la les dependencies del frontend amb `npm install`.
2. Configura l'entorn de Laravel i la base de dades MySQL segons les instruccions de Laravel.
3. Executa les migracions per crear les taules de la base de dades amb `php artisan migrate`.
4. Inicia el servidor de desenvolupament del frontend amb `npm run serve`.
5. Inicia el servidor de Laravel amb `php artisan serve`.

## Com desplegues l'aplicació a producció

Per desplegar l'aplicació a producció, segueix aquestes passes:

1. Configura un servidor web compatible amb PHP i MySQL, com ara Apache o Nginx.
2. Puja els fitxers del frontend a un servidor estàtic o servidor web compatible amb Vue.js.
3. Configura l'entorn de producció de Laravel segons les instruccions de Laravel.
4. Puja els fitxers de backend a un servidor compatible amb PHP.
5. Configura la connexió de la base de dades MySQL per al servidor de producció.
6. Assegura't que els permisos dels fitxers i directoris són els adequats per al servidor web.

## Llistat d'endpoints de l'API de backend

### Rutes

A continuació es detallen les rutes de l'API de backend de Laravel:

- GET /api/movies: Retorna la llista de pel·lícules.
- POST /api/movies: Crea una nova pel·lícula.
- GET /api/movies/{id}: Retorna una pel·lícula específica segons la seva ID.
- PUT /api/movies/{id}: Actualitza una pel·lícula existent segons la seva ID.
- DELETE /api/movies/{id}: Elimina una pel·lícula existent segons la seva ID.

### Exemples de JSON de petició

Exemple de JSON per a una petició POST de creació de pel·lícula:

```json
{
  "title": "Títol de la pel·lícula",
  "director": "Nom del director",
  "year": 2022,
  "description": "Descripció de la pel·lícula"
}
