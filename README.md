# PortfolioMS
A Content Management System for basic portfolios.

### Setup
To setup PortfolioMS, create a MySQL database then update *classes/db.class.php* with the correct database information. Then go to */setup/* and follow the instructions.

### To-do
- Make setup.php rename /admin directory
- Sanitize setup inputs

### Project Goals
##### Required
1. ~~Developers can create themes and simply use ``$PMS->get("fieldName")`` to access data controlled through the Admin Dashboard.~~
2. ``$PMS->getProjects()``, ``$PMS->getProjects(id)``, and ``$PMS->getProjects(id1, id2, ..., idN)`` can be used in themes to get all projects, a specific project, or multiple specific projects that have been created in the Admin Dashboard.
3. ~~The Admin Dashboard can be used to create new static fields (such as 'name' or 'about me'), which can then be used in themes by using ``$PMS->get()``.~~
4. The Admin can create, edit, delete, hide, and re-order projects through their Dashboard.

##### Future
1. A theme store where themes can be hosted and downloaded in one-click.
2. Ability to enable comments and/or voting.
3. Social Media Integration (Share on Facebook/Twitter).
