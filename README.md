Install guide
Make sure that git is on your path, one can check this by running the command “git” in your command prompt. If it does not return that the command is not known then you are ready to go. (git can be downloaded from https://git-scm.com/download/win)
•	Install Virtual box from https://www.virtualbox.org/wiki/Downloads
•	Install Vagrant from http://www.vagrantup.com/downloads.html
•	Open a command prompt in admin mode
•	Go to the directory in which you want to place the sudosos code 
•	Run git clone https://github.com/GEWIS/Sudosos.git (note: this command creates a folder sudosos for you)
•	Run “git checkout -b develop”
•	Run “git pull”
•	Go to the directory in which you want to install the virtual box content: “cd {directory}”
•	Run: “vagrant box add laravel/homestead”
•	Choose for virtual box if you are asked for a provider
•	Run: “git clone https://github.com/laravel/homestead.git Homestead”
•	Go into the created folder: “cd Homestead”
If you already have a putty key pair you can skip this step
•	Open putty gen. One can get it from https://www.chiark.greenend.org.uk/~sgtatham/putty/latest.html by installing putty
•	click generate and generate a key by moving randomly over an area
•	you can optionally secure your key with a passphrase
•	export the public key as {name}.pub
•	Export the private key by clicking conversions and export as openssh key
Resume here if you already have a private key (if it is still in pkk format load it in putty and export as described in the previous step
•	Run “init.bat”
•	Open homestead.yaml (located in the homestead folder)
•	On the authorize line change the change “~/.ssh/id_rsa.pub” to the path of your own public key (FORWARD SLASHES)
•	Under keys change “~/.ssh/id_rsa” to the location of your private key (do not forget to keep the dash in front of the line) (FORWARD SLASHES)
•	Change under folders on the map line “~/Code” to the absolute path to the sudosos directory (FORWARD SLASHES)
•	Change under sites homestead.app to sudosos.dev and under to change the path to /home/vagrant/Code/public
•	Under the databases section add:  - gewisweb_test
Now we can start the VM
•	Go to the homestead folder
•	Run “vagrant up --provision”
•	Allow access if a firewall asks this
•	Run “vagrant ssh”
•	Run “cd Code”
•	Run “composer install”
•	Ignore all suggestions
•	Run “npm install”
•	Run “gulp”
•	Open the gewisweb_test DB and create the DB structure which can be obtained at one of the developers. 
•	Run “php artisan migrate” to initiate all databases for seeding in the next step
•	Run “php artisan db:seed” enter “yes” and execute
•	Do not care for potential errors
•	Run “cp .env.example .env”
•	Add the following text to your .env file:
         DB_CONNECTION=mysql_gewisdb
         DB_HOST=127.0.0.1
         DB_PORT=3306
         DB_DATABASE=gewisweb_test
         DB_USERNAME=homestead
         DB_PASSWORD=secret
         
         GEWISWEB_JWT_SECRET=TempSecretDoNotUseInProduction
         GEWISWEB_AUTH_URL=https://gewis.nl/token/sudosos
        

•	Run “vagrant provision” (outside the VM)
•	Run “php artisan key:generate

•	Optional: add sudosos.dev to hosts file
•	Add “192.168.10.10       sudosos.dev” to C:\Windows\System32\drivers\etc\hosts (must be done with admin rights)

Check if everything works:
•	Check if everything works by going to sudosos.dev (the frontend interface must appear)
•	Check if data is returned from sudosos.dev/api/v1/products

Potential other useful software:
-	PHP storm https://www.jetbrains.com/student/ (IDE for webdevelopment) 
-	GitKraken https://www.gitkraken.com/download (easy git management)
-	Insomnia (of postman) https://insomnia.rest/ (easy http requesting)

 Frontend information
For the frontend there are basically two important folders. The first one is the www folder in which all less css is stashed and also the javascript files. Since we are using less css it is necessary to execute the “gulp” command from the commandline in the root folder of sudosos after changes here. Only then the changes become active.
The other important directory is the public dir. In this dir all publicly accessible content will reside. The template folder contains a html file for every page that is made. Make sure to make full use of the angular library which should make sure that no or little code is needed in these templates. Two html files should be highlighted which are the sudosos html which contains the sidebar content and the angular html in the main folder which is the container for all other files. Includes are put in there.
When adding a new page also some javascript needs to be written. Add a controller to the controllers.js in www/js and add a state in sudosos.js. When this is all done you are ready to go.
