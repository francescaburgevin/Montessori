/** 
 ** Projet : Montessori Les Loulous Futés
 ** 3W Academy
 ** October 4, 2022
 ** by Francesca Nadel
 **
 **/

Access site via : 
https://francescanadel.sites.3wa.io/Montessori/index.php?page=home

In September 2023, a new Montessori school will open.
The school would like to be present on the internet and offer the students'
parents a glimpse into the everyday happenings through a private feed.
The teachers would like to post pictures and announcements.
The school's director would also like to administer the website through their
mobile device. Hence, the mobile web application.

3 experiences are active.
    - parent : adult with children (students) in the school
    - faculty : adult that works at the school
    - administrator : adult administrator at the school
* there are no children (student) accounts.

How to sign in :

Alice Burgevin, parent with 2 children.
    login parent1 & password parent11
    child : Rachel (class: cerise)
    child : Louise (class: pomme)

Cédric Burgevin, Alice's husband.
    login parent2 & password parent22

        
Clément Quinze, parent with 1 child.
    login parent3 & password parent33
    child : Louis (class: pomme)

Silvie Beyne, a faculty member and a teacher with 1 class.
She has feed add, write and delete permission.
    login faculty4 & password faculty44
    class : Pomme

Michel Goldmann, a faculty member associated to 1 class.
He does not have permissions.
    login faculty5 & password faculty55
    class : Pomme
    
Fleur Vanille, a faculty member and a teacher with 1 class.
She has feed add, write and delete permission.
    login faculty6 & password faculty66
    class : Cerise

Sandra Bartoli, a faculty member and a teacher with 1 class.
She has feed add, write and delete permission.
    login faculty7 & password faculty77
    class : Pêche
    
Admina Sita, the administrator.
    login admin2022 & password admin2022
    
        
Via their account, the Parent has access to a list of their children and link to
each childs' class feed.
The parent can READ feeds.
The parent can ADD a comment to the feed or respond to another comment. 
Their comment needs to be validate/published before appearing to others.

Faculty, or teacher, has access to their class list and its feed.
The teacher can READ feeds.
The teacher with permission can ADD feeds, MODIFY feeds and DELETE feeds.
The teacher with permission can validate a parent comment or a child comment 
(publish checkbox).

Administrator has access to all feeds by class name.
The administrator can READ, ADD, MODIFY and DELETE feeds.
The administrator can validate a parent comment or a child comment.
The admin can ADD users.


>>>> looking towards the future >>>>
Priority functions:
- limit image upload size
- limit length of image upload name (max 100 characters)
- create error messages for these functions


As of now, there are several functions that are inactive or need to be created :
- add, modify and delete the hero banner, the articles and the events on the home page
- lier une classe à un user
- modify and delete users
- add, modify and delete students
- modify and delete comments
- modify user information
- pages : équipe, formations, tarifs, vie de l'école, pédagogie Montessori
- envoie automatique d'un mail avec identifiant et mot de passe dès la création d'un user