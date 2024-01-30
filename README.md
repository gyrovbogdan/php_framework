# PHP Framework From Scratch

### MVC Framework consist of classes:

- App - main class, that parse url and calls router function.
- Container - provide dependency enjections, that is create and store classes.
- Template Engine - provide rendeng the page and add variables to templates.
- Database - class for connect to database and for sending query.
- Validator - this class is needed to validate form data, whitch is send to server. Also framework contains a bunch of build in rules.
- Exeption classes for Container, Database, Validator.
- Router - this class is responsible for request identification. Class contian all routes and middlewares. Base on path Router execute requred function.

### App contains definitions of:

- Middlewares
- Controller with function that Router executes
- Servises to iteract with entities
- Page tempalates
- Global functions
- Class definitions for Container and other config files
