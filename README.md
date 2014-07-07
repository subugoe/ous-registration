OUS Registration
================

#Overview
This Git reposiory contains the "Anmeldung2" [1] Application written by the Universitätsbibliothek Braunschweig. For a general description, a installation guide, see the home page

## Status
This repository contains the original software (tagged as 2.01) and the changes made by the Universitätsbibliothek Göttingen.

#Roadmap
## Get rid of dependencies
The current code depends on a Perl daemon and a MySQL Database. The per backend seems to be used to ensure that there is only one single call to the `doe` commend. The Database is used to store the requests. Both task can bes also solved by using a SQLite embedded database. This approach wouldn't only reduce the required maintenance of these dependencies, but also make the installation easier

## Cleanup configuration
Currently the user front end and the administrative back end each have their own configuration, this is unneeded.

## Easier skinning (CI)
Separate and comment the CSS classes used to make up the look and feel of the application.


[1]: http://www.biblio.tu-bs.de/anmeldung2/doc/