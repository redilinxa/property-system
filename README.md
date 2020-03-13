## Property System -  
##### Description
This project is a real estate property tracker. The data is mainly hydrated from the following API 
endpoint: [http://trialapi.craig.mtcdevserver.com/api/properties]. To retrieve the data an API_KEY 
needs to be added as a parameter to the request URL.
There is also a create and edit section to update existing and add you properties. All the operations 
and CTA's are accessed from the base rote of the project [/].
The full project functional specification can me accessed from the following shared file: 
[https://drive.google.com/file/d/15hbT7W0pRAwnRXZHDu3lOd5kk7a6-9fO/view?usp=sharing]. All the functional specifications
has been met.
This implementation was carried through with the following technical specifications:
- Plain php 7.1 version
- MySql 5.7.
- APACHE 2.4 web server.


###Installation

After cloning the repository on the master branch, carry on the following:
- Cloning the repository.
- cd into property-system directory.
- Under folder `public`, create the directory folder structure `files/full` and `files/thumbs`. Those
folders will hold the files uploaded from the create/update property action. Make sure that from the project
root the following folder links will be accessible: `public/files/full` and `public/files/thumbs` and both have
full read write access (0777).
- Create a database with name 'property-system' with user with username:`root` and password:`root`. 
If you need to adjust the database host, username or password, the variables can be found on the `config/database.php` file.
- Before accessing the system though, please don't forget to execute the sql scripts in the scripts folder. 
- Make sure you have internet connectivity as the assets are all pulled down from CDNs.
- If you are having issues setting up, a docker configuration could follow up if needed. Please email`redilinxa@gmail.com` for support.


###Usage
- Open the route `/`.
- Hit the `Refresh` button and after you will see the properties displaying automatically you on the table.
- Hit the `Add` button to create a new property. If you want to edit one, click the edit icon on each side of
the action column to display the popup with the filled in data.
- On every action the table will automatically refresh.
- Graphical interface screenshots of the project and the screen recorder video. [Link](https://drive.google.com/drive/folders/1diPs5xzXLrEgcTXQ5aVju2V3x-96_mty?usp=sharing)


###Improvements
- Well, it is plain php. You can improve the structure with namespaces and adding composer PSR standards.
- Display messages, with a little more time to spare i could have implemented a notification system.
- Detailed exceptions and validations.
- The design could use some changes in UX. 
- Docker file for development portability.
- Dynamic parametrization.

###Known bugs
- Missing refresh of the property types on addition after initial load from api. Need hard refresh from browser before clicking Add or Edit.
- Design issues in radio button.

Overall i can say that for the existing specification the application does what is intended.
The means behind the completion of this task was for me to be able to show as much diverse implementation logic and technologies
in order for you to be able to understand my existing knowledge as a developer.
